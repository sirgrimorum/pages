# Changelog

All notable changes to Pages will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.3.3] - 2026-03-01

### Added
- Laravel 12 support
- Minimum PHP version raised to 8.2

## [1.3.2] - 2026-03-01

### Added
- Scrutinizer CI configuration using PHP 8.2 and PHPUnit 10

## [1.3.1] - 2026-03-01

### Fixed
- Special section content was being accumulated and duplicated across multiple `buildPage()` calls in the same request
- Access policy pattern `*name` (ends-with) and `name*` (starts-with) were swapped — matching logic corrected

## [1.3.0] - 2026-02-23

### Changed
- Updated compatibility to PHP ^8.x and Laravel ^9.0|^10.0|^11.0
- Minimum PHP raised from 7.x to 8.x

## [1.2.12] - 2021-03-04

### Changed
- Updated CrudGenerator integration to latest version

## [1.2.11] - 2021-01-11

### Fixed
- Various helper handling improvements

## [1.2.10] - 2021-01-05

### Added
- Included support for CrudGenerator's `CrudGenForModels` trait on the Page model

## [1.2.9] - 2020-09-10

### Changed
- Updated to Laravel 7 compatibility

## [1.2.8] - 2020-08-24

### Added
- Icons and indentation support in artisan command output
- Middleware always applied to admin routes

## [1.2.7] - 2020-03-04

### Added
- Dynamic loading of Eloquent collections inside special sections (`type: 'collection'`)

## [1.2.6] - 2019-07-31

### Fixed
- Special sections error

## [1.2.5] - 2019-07-30

### Added
- `pages:createseed` artisan command to dump current pages/sections to a seed file

### Fixed
- Seeder name error

## [1.2.4] - 2019-07-30

### Added
- Pages with `order <= 0` are excluded from the AutoMenu

## [1.1.x]

### Added
- BigInt support on the `id` column (Laravel 5.8+)
- Initial public release with page/section management, access policies, and AutoMenu integration

---

> Versions prior to 1.1.0 are not documented here.

[Unreleased]: https://github.com/sirgrimorum/pages/compare/1.3.3...HEAD
[1.3.3]: https://github.com/sirgrimorum/pages/compare/1.3.2...1.3.3
[1.3.2]: https://github.com/sirgrimorum/pages/compare/1.3.1...1.3.2
[1.3.1]: https://github.com/sirgrimorum/pages/compare/1.3.0...1.3.1
[1.3.0]: https://github.com/sirgrimorum/pages/compare/1.2.12...1.3.0
[1.2.12]: https://github.com/sirgrimorum/pages/compare/1.2.11...1.2.12
[1.2.11]: https://github.com/sirgrimorum/pages/compare/1.2.10...1.2.11
[1.2.10]: https://github.com/sirgrimorum/pages/compare/1.2.9...1.2.10
[1.2.9]: https://github.com/sirgrimorum/pages/compare/1.2.8...1.2.9
[1.2.8]: https://github.com/sirgrimorum/pages/compare/1.2.7...1.2.8
[1.2.7]: https://github.com/sirgrimorum/pages/compare/1.2.6...1.2.7
[1.2.6]: https://github.com/sirgrimorum/pages/compare/1.2.5...1.2.6
[1.2.5]: https://github.com/sirgrimorum/pages/releases/tag/1.2.5
