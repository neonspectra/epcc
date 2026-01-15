<details>
  <summary><b>Version Nomenclature</b></summary>
Following the release of 2.00 Argonaut, EPCC now uses a consistent naming convention for version numbering that prioritises inter-version character sheet compatibility:
- The version EPCC version number must be a float number. It must always increase with the release of new versions.
- Any change that DOES impact character sheet compability will increment the integer component (ie, number to the left of the decimal point) of the version number.
    - Incrementing this number will result in a new version codename assigned (which may or may not be alphabetical).
- Any change that DOES NOT impact character sheet compability will increment the decimal component (ie, number to the right of the decimal point) of the version number.
    - Generally, the minor version number has two digits, giving up to 99 versions before we end up in an awkward situation if we want to keep the version a float without rolling over.
    - In the event that we for some reason were to get over 99 releases in a minor version, we will start incrementing to the right. IE, the next minor version after `X.99` would be `X.991` and so on. I don't expect this to ever happen.
</details>

# 2.01 Argonaut (2026-01-16)
This release includes UI fixes as well as introduces a new dark mode (enabled by default).
- Dark Mode 😎
- Added a settings menu (replaces "About" menu) to include a toggle for dark mode as well as for whether to show background images.
- Reworked landing page styling to properly fit all elements as page shifts
- Cleaned up column wrapping to remove awkward spacing on mobile
- Fixed mojibake database entries for some flavour texts in various gear/traits.
- Fixed popup modals getting cut off and rendering off-screen on mobile

# 2.00 Argonaut (2026-01-15)
This release is the first EPCC release under [neonspectra/epcc](https://github.com/neonspectra/epcc). This release focuses on long-overdue plumbing updates as well as automating testing and build processes for further new releases. 

There are no new features or user-facing changes, but this release cleans up almost a decade worth of accrued technical debt. While there shouldn't be any intentionally breaking changes and your old sheets will *probably still work*, it is advisable to use caution loading sheets from old versions of EPCC.

CI Workflows (GitHub Actions):
- [`.github/workflows/ci.yml`](.github/workflows/ci.yml) - Automated the test suite, as well as adding a few tests
- [`.github/workflows/nightly-image.yml`](.github/workflows/nightly-image.yml) - Automated nightly builds to ghcr.io on new pushes to main. Builds are parallelised over AMD64 and ARM64 runners to create multiarch tagged images.
- [`.github/workflows/nightly-image.yml`](.github/workflows/nightly-image.yml) - Manual release builds to ghcr.io with user input version details. Also multiarch.

Major EOL Frameworks Refactor:
- Laravel 5.6 -> Laravel 12
- PHP 7.4 -> PHP 8.4
- Vue 2 -> Vue 3

Other plumbing this refactor upgraded:
- Backend: `bootstrap/app.php`, `public/index.php`, `artisan`, `app/Providers/RouteServiceProvider.php`, `app/Http/Middleware/TrustProxies.php`, `app/Exceptions/Handler.php`, `routes/*.php, composer.json, composer.lock`, `phpunit.xml`, `tests/*.
- Frontend: `package.json`, `package-lock.json`, `webpack.mix.js`, `resources/js/app.js`, `resources/sass/vendor.scss`, `resources/views/`, `main.blade.php`.
- Docker/runtime: Dockerfile now uses Node 24 and PHP 8.4; includes required PHP extensions.

# 1.51 Gate Jump (December 2018)

This releases was based on a move to Laravel, which affected almost every part of the application.

* PHP 7.2 is now required
* Now available using Docker
* Database has experienced major changes (added auto incrementing id's and re-named tables)
* Javascript and CSS are now built using webpack, and injected on page load.

Removed:
* Removed the ability to buy more than one Muse/Ai
* Players may not modify anything that they have not added to their character, and removing something from their character may (in the future will) remove any modifications to that item.

And many other changes under the hood.

Incomplete/ToDo Items:
* Move from the custom .ini file to using the Laravel configuration system.
* Implement CRUD functionality with a JSON API
* Move to a proper single page application that consumes JSON.
    The current version sends raw POST data and consumes HTML.
* Don't read the entire database into the current session
* Save the session information to the database so nothing is lost if the server is rebooted.  Laravel Feature.
* Use object IDs for database objects instead of their names.  Names are NOT guaranteed to be unique.
* Finish moving the database to a proper relational model using object IDs. Currently it is using names, and objects are not linked to each other.
* Prepare for Eclipse Phase Version 2

# 1.50 Gate Prep (May 2018)

Final release before moving to Laravel

# 1.49 Nano Seed (December 2016)

First version with named releases

# Internal 0.93 (April 2016)
# 1.2.1 (July 2015)
# 1.2.0 (September 2014)
# 1.1.0 (August 2014)
# 1.0.0 Original EPCC Sources (July 2014)
