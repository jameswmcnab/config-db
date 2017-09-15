# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Basic integration tests (under PHP 5.6, 7.0 and 7.1).
- Add change log (`CHANGELOG.md`) and upgrade guide (`UPGRADE.md`).

### Changed
- Update to Laravel 5.4. This package now ONLY supports one Laravel `MAJOR`
  release at a time, a new `MAJOR` release of this package will be released
  for each `MAJOR` Laravel release.
- Update project structure and use PSR-4.
- Migrations are now loaded from the package instead of requiring publishing.

### Removed
- No longer supports PHP 5.4, 5.5 and HHVM.

## [1.0] - 2015-08-03
### Fixed
- Config update fix for existing keys.
- Remove existing database entries when saving a key that already exists.

## [0.5] - 2015-03-05
### Added 
- Initial Release
