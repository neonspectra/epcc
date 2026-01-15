# AGENTS.md

This repo is a Laravel + Vue web app (Eclipse Phase Character Creator) with a Dockerized standalone runtime. It was modernized recently (Laravel 12, PHP 8.4, Vue 3, Laravel Mix 6). This file is for AI agents and humans to keep changes safe, testable, and consistent.

## Architecture Overview

- **Backend (Laravel)**  
  - Entry: `public/index.php` → `bootstrap/app.php`  
  - Routes: `routes/web.php` (page + export), `routes/api.php` (JSON API)  
  - Controllers: `app/Http/Controllers/*`  
  - Domain logic: `app/Creator/**` (core character creation, validation, exports)  
  - Helper functions: `app/Creator/HelperFunctions.php` (e.g., `creator()` accessor)

- **Frontend (Vue 3 + Vue Router + Vuex)**  
  - App entry: `resources/js/app.js`  
  - Pages: `resources/js/pages/*`  
  - Components: `resources/js/components/*`  
  - Modals: `resources/js/components/modals/*` (UIkit modals)
  - Legacy JS helpers: `resources/js/legacy/*` (loading popup, etc.)

- **Views / HTML shell**
  - `resources/views/main.blade.php` is the SPA container and inlines compiled JS/CSS.

- **Static assets**
  - `public/` is bundled into the Docker image.  
  - Local modal images live in `public/img/` (e.g., `forkme.png`, `creativecommons.png`).

- **Docker**
  - `Dockerfile` builds assets (Node), installs PHP deps (Composer), initializes SQLite, and runs nginx + php-fpm via s6.
  - Standalone env defaults are from `standalone.env` (copied to `.env` in Docker build).

## Important Interaction Paths

- **Landing page + modals**  
  `resources/js/pages/Welcome.vue` → `new-character-modal`, `load-dialog`, `about`

- **Main workflow**
  - `POST /api/creator/` → `HighLevelCreatorController@store` creates a session-based creator.
  - Client reloads page after creation; Vue Router switches to main page.
  - `GET /api/creator/` provides current point/credits state.

- **Save / Load / Export**
  - Save: `GET /api/creator/save`  
  - Load: `POST /api/creator/load`  
  - Export: `GET /export/pdf`, `GET /export/txt` (web routes, require a creator session)

- **Version display**
  - `GET /api/version` returns display version info (name/number/commit/date).
  - Defaults are “NIGHTLY / 0.0 / na” locally unless CI injects values via build args.

## Style & Naming Conventions

- **PHP**
  - Follow existing class/method naming in `app/Creator/*`.
  - Keep additions consistent with current procedural helpers in `app/Creator/HelperFunctions.php`.
  - Avoid new dynamic properties; prefer explicit properties and typed parameters.

- **Vue**
  - Vue 3 single-file components with `export default { ... }`.
  - Use explicit imports for `axios` (module scope) and legacy helpers via `window.*`.
  - For UIkit toggles, always use explicit targets:
    - `uk-toggle="target: #modal-id"`  
    - Do not use bare `uk-toggle` on buttons (prevents self-toggle bugs).

- **JS**
  - Avoid global `app` in modules; use `window.app` if needed.
  - Keep legacy helper usage explicit (`window.startLoading`, `window.readJsonFile`, etc.).

- **Assets**
  - Place local images in `public/img/` and reference with absolute `/img/...` URLs.

## Testing: What to Run

### Fast/Local (PHP tests)
If PHP isn’t installed locally, use the Composer container:
```bash
sudo docker run --rm -v "$PWD:/app" -w /app composer:2 sh -lc \
  "cp testing.env .env && composer install --no-interaction && php artisan test"
```

### Docker Image Build + Smoke Checks
```bash
sudo docker build -t epcc .
sudo docker run --rm -d -p 8080:80 --name epcc_test epcc
curl -fsS http://localhost:8080/ | head -n 5
curl -fsS http://localhost:8080/api/version
sudo docker stop epcc_test
```

### Export Smoke Check (inside app context)
Exports require a creator session. Use PHP to seed it:
```bash
sudo docker run --rm -v "$PWD:/app" -w /app composer:2 sh -lc \
  "cp testing.env .env && composer install --no-interaction && \
   php artisan tinker --execute=\"session()->put('cc', new App\\Creator\\EPCharacterCreator(1000)); \
   echo json_encode(json_decode(app(App\\Http\\Controllers\\HighLevelCreatorController::class)->save()->getContent(), true)['versionCommit']);\""
```

## Feature Test Loop (No Browser Required)

When implementing UI or API features without browser access:

1. **Identify route + entry points**
   - API: `routes/api.php` and controller.
   - UI: `resources/js/pages/*` + modals/components.

2. **Add/extend tests**
   - Use `tests/Feature` for route assertions.
   - Use `tests/Unit` for JS/template regressions (string assertions).

3. **Run test suite**
   - `php artisan test` (via Composer container if needed).

4. **Run minimal Docker smoke check**
   - Build and run container, hit `/api/version`.

5. **Report results**
   - Explicitly state which tests ran and what was verified.

If a UI change cannot be fully validated without a browser, note that clearly and suggest a manual click-through.

## Known Gotchas

- **Creator session**: Many routes require an active `creator()` session. Tests or CLI checks must seed the session.
- **`/api/creator/save`**: Requires a creator session or returns 401.
- **Metadata drift**: Version info is injected at build time in CI; tests should not hardcode display metadata.
- **Assets**: Remote asset URLs may fail due to CSP/cross-origin. Prefer local `public/img/` assets.
- **Nginx + PHP**: The Docker healthcheck hits `/` and requires nginx + php-fpm running together.

## CI/Release Workflows

- **PR tests**: `.github/workflows/ci.yml` runs tests on PRs only.
- **Nightly**: `.github/workflows/nightly-image.yml` builds per-arch images and creates multi-arch tags.
- **Manual release**: `.github/workflows/release-image.yml` supports workflow_dispatch with version inputs.

These workflows inject version metadata via Docker build args:
`EPCC_DISPLAY_VERSION`, `EPCC_DISPLAY_VERSION_NAME`, `EPCC_DISPLAY_COMMIT`, `EPCC_DISPLAY_RELEASE_DATE`.

---

If you add new flows, update this file with test examples and a brief description of where the change lives (route, controller, component).
