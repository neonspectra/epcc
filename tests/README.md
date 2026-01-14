# Tests

This folder contains automated tests used to validate the app before producing a Docker image.

## How to run

```bash
composer install
php artisan test
```

## Test coverage overview

### Feature tests

- `tests/Feature/NewCharacterSmokeTest.php`
  - Verifies the "Begin!" flow by exercising `POST /api/creator/` and ensuring a creator session is created.

### Unit smoke tests

- `tests/Unit/FrontendSmokeTest.php`
  - Guards against UI regressions for the modal buttons by asserting explicit `uk-toggle="target: #..."` usage.
  - Ensures modal scripts import `axios` and call the legacy window helpers (`startLoading`, `readJsonFile`).
- `tests/Unit/ExportSmokeTest.php`
  - Ensures PDF export emits valid PDF bytes (`%PDF-` prefix).
  - Ensures TXT export emits the expected plain-text sections.

## Notes

- Tests rely on the SQLite test database seeded from `database/database.sql` by `tests/TestCase.php`.
- The export smoke tests invoke the exporter code directly and use output buffering to validate output.
