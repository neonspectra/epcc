# EPCC Design Styleguide

This styleguide documents the theme tokens and how to apply them consistently across EPCC. Use the CSS custom properties defined in `resources/sass/theme.css` to keep light/dark themes aligned.

## Named Palette (Light & Dark)

Use these names in discussions and future docs. Actual values live in `resources/sass/theme.css`.

### Light Mode

- **Void White** — `#ffffff` (`--epcc-body-bg`, `--epcc-surface-solid`)
- **Steel Text** — `hsl(200,10%,40%)` (`--epcc-text`)
- **Ink Black** — `#000000` (`--epcc-text-strong`)
- **Signal Rose** — `rgb(186, 0, 80)` (`--epcc-accent`, `--epcc-accent-bg`)
- **Mist Surface** — `rgba(242, 242, 242, 0.8)` (`--epcc-surface`)
- **Mist Surface Strong** — `rgba(242, 242, 242, 0.9)` (`--epcc-surface-strong`)
- **Mist Hover** — `rgba(254, 254, 254, 0.85)` (`--epcc-surface-hover`)
- **Steel Panel** — `rgba(211, 211, 211, 0.8)` (`--epcc-surface-panel`)
- **Muted Rose** — `rgba(202, 194, 194, 0.61)` (`--epcc-surface-muted`)
- **Overlay White** — `rgba(255, 255, 255, 0.95)` (`--epcc-surface-overlay`)
- **Light Border** — `rgba(245, 245, 245, 0.8)` (`--epcc-border-light`)
- **Light Border Soft** — `rgba(245, 245, 245, 0.6)` (`--epcc-border-light-soft`)
- **Dark Divider** — `rgba(148, 155, 153, 0.8)` (`--epcc-border-dark`)
- **Dark Divider Soft** — `rgba(148, 155, 153, 0.6)` (`--epcc-border-dark-soft`)
- **Panel Outline** — `grey` (`--epcc-border-panel`)
- **Input Outline** — `#000000` (`--epcc-input-border`)
- **Shadow** — `rgba(0, 0, 0, 0.6)` (`--epcc-shadow`)

### Dark Mode

- **Void Black** — `#0f1114` (`--epcc-body-bg`)
- **Steel Text (Dark)** — `#868f96` (`--epcc-text`)
- **Fog White** — `#eef2f4` (`--epcc-text-strong`)
- **Signal Rose Light** — `#f598c6` (`--epcc-accent`)
- **Signal Rose Deep** — `#b41b5c` (`--epcc-accent-bg`)
- **Ash Surface** — `rgba(22, 26, 30, 0.85)` (`--epcc-surface`)
- **Ash Surface Strong** — `rgba(28, 33, 38, 0.9)` (`--epcc-surface-strong`)
- **Ash Hover** — `rgba(40, 46, 54, 0.9)` (`--epcc-surface-hover`)
- **Ash Solid** — `#1a1f24` (`--epcc-surface-solid`)
- **Panel Steel** — `rgba(26, 31, 36, 0.85)` (`--epcc-surface-panel`)
- **Muted Rose (Dark)** — `rgba(71, 58, 66, 0.7)` (`--epcc-surface-muted`)
- **Overlay Ash** — `rgba(20, 24, 28, 0.95)` (`--epcc-surface-overlay`)
- **Light Edge** — `rgba(255, 255, 255, 0.08)` (`--epcc-border-light`)
- **Light Edge Soft** — `rgba(255, 255, 255, 0.05)` (`--epcc-border-light-soft`)
- **Dark Edge** — `rgba(0, 0, 0, 0.6)` (`--epcc-border-dark`)
- **Dark Edge Soft** — `rgba(0, 0, 0, 0.4)` (`--epcc-border-dark-soft`)
- **Panel Outline (Dark)** — `rgba(255, 255, 255, 0.18)` (`--epcc-border-panel`)
- **Input Outline (Dark)** — `rgba(255, 255, 255, 0.35)` (`--epcc-input-border`)
- **Shadow (Dark)** — `rgba(0, 0, 0, 0.7)` (`--epcc-shadow`)

## Theme Tokens

All tokens are CSS variables on `:root` (light) and `[data-theme="dark"]` (dark). Use tokens instead of hard-coded colors.

### Core Colors

- `--epcc-body-bg` — Global page background.
- `--epcc-text` — Default body text color for paragraphs, labels, meta text, and standard UI copy.
- `--epcc-text-strong` — Headings and emphasized text on dark surfaces.
- `--epcc-text-inverse` — Text on strong accent backgrounds.
- `--epcc-accent` — Accent/brand color for links, hover text, and non-solid highlights.
- `--epcc-accent-bg` — Solid accent background for selected/active states.

### Surfaces

- `--epcc-surface` — Primary panel and card backgrounds; used for most containers.
- `--epcc-surface-strong` — Dropdown/menu containers or slightly stronger panels.
- `--epcc-surface-hover` — Hover background for list items and buttons.
- `--epcc-surface-solid` — Inputs, popovers, and tooltip backgrounds.
- `--epcc-surface-panel` — Game-style box backgrounds (`.game-box`).
- `--epcc-surface-muted` — Section headers and subtle group labels.
- `--epcc-surface-overlay` — Floating message overlay background.

### Borders & Shadows

- `--epcc-border-light` — Light inner borders (top separators).
- `--epcc-border-light-soft` — Light divider lines.
- `--epcc-border-dark` — Dark border on inputs and panels.
- `--epcc-border-dark-soft` — Dark divider lines.
- `--epcc-border-panel` — Panel border outline (game-style border + tooltips).
- `--epcc-input-border` — Thick checkbox/legacy input outline.
- `--epcc-shadow` — Shadows for popovers/tooltips.

## Component Usage

### Layout & Containers

- **Body**: `background-color: var(--epcc-body-bg)` and `color: var(--epcc-text)`.
- **Panels (`section.panel`, `.mainlist`, `.skills`)**: `var(--epcc-surface)` background with `--epcc-text` text.
- **Game boxes (`.game-box`)**: `background: var(--epcc-surface-panel)` with `border: 2px solid var(--epcc-border-panel)`.
- **Modal dialogs (`.uk-modal-dialog`)**: `background: var(--epcc-surface)` and text `var(--epcc-text)`.

### Navigation & Selection

- **Active list item**: `background: var(--epcc-accent-bg)` and `color: var(--epcc-text-inverse)`.
- **Hover list item**: `background: var(--epcc-surface-hover)` and `color: var(--epcc-accent)`.
- **Section headers (`.listSection`, `.foldingListSection`)**: `background: var(--epcc-surface-muted)` and `color: var(--epcc-accent)`.

### Buttons

- **Primary buttons (`.uk-button-primary`)**: `background: var(--epcc-accent-bg)` + `color: var(--epcc-text-inverse)`.
- **Secondary/default buttons (`.uk-button-secondary`, `.uk-button-default`, `.popupButton`)**: `background: var(--epcc-surface)` + `color: var(--epcc-text)`.
- **Hover state**: `background: var(--epcc-surface-hover)` + `color: var(--epcc-accent)`.

### Links

- **Links**: `color: var(--epcc-accent)`.
- **Hover**: keep `var(--epcc-accent)` to maintain emphasis and contrast.

### Forms & Inputs

- **Inputs/select/textarea**: `background: var(--epcc-surface-solid)` + `color: var(--epcc-text-strong)` + `border: 1px solid var(--epcc-border-dark)`.
- **Focus**: `border-color: var(--epcc-accent)`.
- **Checkboxes**: `background: var(--epcc-surface-solid)` + `border-color: var(--epcc-border-dark)`.
- **Legacy checkbox outline**: use `var(--epcc-input-border)`.

### Tooltips & Help

- **Help icons (`.btnhelp`)**: `color: var(--epcc-text)` for default state.
- **Tooltips (`.ui-tooltip`)**: `background: var(--epcc-surface-solid)`, `border: 1px solid var(--epcc-border-panel)`, `color: var(--epcc-text)`, `box-shadow: var(--epcc-shadow)`.

### Messages & Alerts

- **Message banner (`#messages`)**: `background: var(--epcc-surface-overlay)`, `color: var(--epcc-text)`.
- **Error/invalid highlight**: use `var(--epcc-accent-bg)` as the background and `var(--epcc-text-inverse)` for readability.

## Do/Don’t

- Do use the tokens above instead of hard-coded colors.
- Do keep hover/active contrast consistent with the reference styles.
- Don’t introduce new hard-coded colors without updating `resources/sass/theme.css`.
- Don’t use `var(--epcc-accent)` as a solid background; use `--epcc-accent-bg` instead.

## File References

- Theme tokens: `resources/sass/theme.css`
- Legacy UI styles: `resources/sass/main7.css`, `resources/sass/ui.css`, `resources/sass/popup.css`
- Game UI components: `resources/sass/new-ui.scss`
