# Changelog

All notable changes to the Laravel Backpack PHPStan Extension will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Initial release of Laravel Backpack PHPStan Extension
- Static analysis support for CrudField magic methods
- Static analysis support for CrudColumn magic methods  
- Static analysis support for CrudFilter magic methods
- Static analysis support for Widget class
- Fluent interface return type recognition
- CrudController method recognition
- CrudPanel facade support
- Comprehensive stubs for all major Backpack classes

### Features
- Magic method resolution for fluent APIs
- Return type extensions for method chaining
- Bootstrap file for helper function registration
- Stubs for CrudPanel, CrudField, CrudColumn, CrudFilter, Widget, and CrudController
- Support for PHP 8.1, 8.2, and 8.3
- Compatible with PHPStan 1.10+ and 2.0+
- Compatible with Laravel Backpack CRUD 6.0+

### Technical Implementation
- Custom MethodsClassReflectionExtension implementations
- DynamicMethodReturnTypeExtension for fluent interfaces  
- Comprehensive stub files for static analysis
- Bootstrap file for runtime helper registration
- Modular architecture for extensibility

## [1.0.0] - TBD

### Added
- First stable release