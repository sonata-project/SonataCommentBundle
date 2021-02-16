# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [3.3.0](https://github.com/sonata-project/SonataCommentBundle/compare/3.2.0...3.3.0) - 2021-02-15
### Added
- [[#234](https://github.com/sonata-project/SonataCommentBundle/pull/234)] Added Dutch translations ([@zghosts](https://github.com/zghosts))

### Changed
- [[#190](https://github.com/sonata-project/SonataCommentBundle/pull/190)] SonataEasyExtendsBundle is now optional, using SonataDoctrineBundle is preferred ([@jordisala1991](https://github.com/jordisala1991))

### Deprecated
- [[#190](https://github.com/sonata-project/SonataCommentBundle/pull/190)] Using SonataEasyExtendsBundle to add Doctrine mapping information ([@jordisala1991](https://github.com/jordisala1991))

### Removed
- [[#190](https://github.com/sonata-project/SonataCommentBundle/pull/190)] Support for Symfony < 4.4 ([@jordisala1991](https://github.com/jordisala1991))

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
