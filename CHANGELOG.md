# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [3.2.0](https://github.com/sonata-project/SonataCommentBundle/compare/3.1.1...3.2.0) - 2020-06-29
### Removed
- [[#185](https://github.com/sonata-project/SonataCommentBundle/pull/185)]
  Remove SonataCoreBundle dependencies
([@wbloszyk](https://github.com/wbloszyk))
- [[#155](https://github.com/sonata-project/SonataCommentBundle/pull/155)]
  Support for Symfony < 3.4 ([@franmomu](https://github.com/franmomu))
- [[#155](https://github.com/sonata-project/SonataCommentBundle/pull/155)]
  Support for Symfony >= 4, < 4.2 ([@franmomu](https://github.com/franmomu))

## [3.1.1](https://github.com/sonata-project/SonataCommentBundle/compare/3.1.0...3.1.1) - 2018-05-11
### Added

### Changed
- Switch all templates references to Twig namespaced syntax
- Switch from templating service to sonata.templating

### Fixed

- `addChild` deprecations
- commands not working on symfony4
- missing Russian translations

## [3.1.0](https://github.com/sonata-project/SonataCommentBundle/compare/3.0.0...3.1.0) - 2017-11-30
### Changed
- Changed internal folder structure to `src`, `tests` and `docs`

### Fixed
- Fixed hardcoded paths to classes in `.xml.skeleton` files of config
- It is now allowed to install Symfony 4

### Removed
- internal test classes are now excluded from the autoloader
- Support for old versions of PHP and Symfony.
