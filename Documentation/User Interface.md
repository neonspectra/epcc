# User Interface Documentation

## High Level Design (post-refactor)

The UI is rendered through Laravel + Vue 3:

- `resources/views/main.blade.php` is the entry point (formerly `index.php`).
- Vue Router mounts into `#container` and swaps pages (`resources/js/app.js`).
- Modals and UI components live under `resources/js/components`.
- UIkit provides modal behavior and layout classes.
- Most user actions are AJAX calls (Axios) to `/api/*` routes.
- File loading reads JSON locally (`readJsonFile`) and posts to `/api/creator/load` (no iframe).

## Layout notes

- The main layout still uses 4 vertical content panes (`#primary`, `#secondary`, `#tertiary`, `#quaternary`).
- `#messages` is a top-centered alert overlay.
- The menu panel is positioned at the bottom-right with buttons for save/load/validate/export/new/about.
- Stats panel remains top-right.
- Popup modals cover most of the page for detailed actions (UIkit modals).

Minimal viewport size remains roughly 1400x630 for a no-scroll experience.
