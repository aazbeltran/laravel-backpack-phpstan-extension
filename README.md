<div align="center">

# Laravel Backpack PHPStan Extension

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aazbeltran/laravel-backpack-phpstan-extension.svg?style=flat-square)](https://packagist.org/packages/aazbeltran/laravel-backpack-phpstan-extension)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/aazbeltran/laravel-backpack-phpstan-extension/ci.yml?branch=main&label=tests&style=flat-square)](https://github.com/aazbeltran/laravel-backpack-phpstan-extension/actions?query=workflow%3Aci+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/aazbeltran/laravel-backpack-phpstan-extension/ci.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/aazbeltran/laravel-backpack-phpstan-extension/actions?query=workflow%3Aci+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/aazbeltran/laravel-backpack-phpstan-extension.svg?style=flat-square)](https://packagist.org/packages/aazbeltran/laravel-backpack-phpstan-extension)

**Comprehensive PHPStan support for Laravel Backpack CRUD with Pro package compatibility**

*Make your Backpack applications statically analyzable and improve code quality with zero configuration*

</div>

---

## ✨ Features

🔮 **Magic Method Resolution** - Automatically resolves dynamic methods on CrudField and CrudColumn classes  
⛓️ **Fluent Interface Support** - Maintains proper return types for seamless method chaining  
💎 **Pro Package Ready** - Full compatibility with Backpack Pro operations and advanced features  
🏗️ **Laravel Facades** - Complete type hints for Laravel facades used throughout Backpack  
📚 **Comprehensive Stubs** - Type definitions for all major Backpack classes and components  
🚀 **Zero Configuration** - Works out of the box with sensible defaults  

## 🚀 Quick Start

### Installation

```bash
composer require --dev aazbeltran/laravel-backpack-phpstan-extension
```

### Configuration

Add to your `phpstan.neon`:

```neon
includes:
    - vendor/aazbeltran/laravel-backpack-phpstan-extension/extension.neon
```

### Run Analysis

```bash
vendor/bin/phpstan analyse
```

That's it! 🎉 Your Backpack code is now statically analyzed.

## 📖 Usage Examples

### Before: PHPStan Errors ❌

```php
// PHPStan errors: Unknown methods, undefined properties
$this->crud->addField(['name' => 'title', 'type' => 'text'])
          ->removeField('slug')
          ->modifyField('content', ['type' => 'wysiwyg']);

$this->crud->addColumn(['name' => 'status', 'type' => 'select'])
          ->removeColumn('internal_notes')
          ->modifyColumn('created_at', ['type' => 'datetime']);
```

### After: Clean Analysis ✅

```php
// PHPStan understands the fluent interface and method chaining
$this->crud->addField(['name' => 'title', 'type' => 'text'])
          ->removeField('slug')                    // ✅ Method resolved
          ->modifyField('content', ['type' => 'wysiwyg']); // ✅ Return type maintained

$this->crud->addColumn(['name' => 'status', 'type' => 'select'])
          ->removeColumn('internal_notes')        // ✅ Method resolved  
          ->modifyColumn('created_at', ['type' => 'datetime']); // ✅ Fluent interface
```

### Pro Package Support

```php
// Pro operations work seamlessly
use Backpack\Pro\Http\Controllers\Operations\CloneOperation;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;

class ArticleCrudController extends CrudController
{
    use CloneOperation, FetchOperation; // ✅ Traits properly typed
    
    public function setup()
    {
        $this->crud->setModel(Article::class);
        $this->crud->setRoute('admin/article');
        $this->crud->clone();  // ✅ Pro method resolved
        $this->crud->fetch();  // ✅ Pro method resolved
    }
}
```

## 🎯 Supported Components

<details>
<summary><strong>Core CRUD Features</strong></summary>

- ✅ **CrudPanel** - Main panel operations and configuration
- ✅ **CrudField** - Field definitions with fluent interface  
- ✅ **CrudColumn** - Column definitions with fluent interface
- ✅ **CrudFilter** - Filter definitions and logic
- ✅ **CrudButton** - Button definitions and positioning
- ✅ **Widget** - Dashboard and page widgets
- ✅ **CrudController** - Base controller functionality
- ✅ **CrudPanelFacade** - Static facade access

</details>

<details>
<summary><strong>Pro Package Features</strong></summary>

- ✅ **CloneOperation** - Entity cloning functionality
- ✅ **FetchOperation** - AJAX data fetching  
- ✅ **InlineCreateOperation** - Inline entity creation
- ✅ **ChartController** - Dashboard charts and analytics
- ✅ **Pro Fields** - Advanced field types
- ✅ **Pro Widgets** - Enhanced widget components

</details>

<details>
<summary><strong>Laravel Integration</strong></summary>

- ✅ **Facades** - Route, Auth, Request, Schema, etc.
- ✅ **Eloquent Models** - Enhanced model typing
- ✅ **Request/Response** - HTTP layer improvements
- ✅ **Validation** - Custom rule definitions

</details>

## ⚠️ Version Compatibility

> **Important Notice**: This extension was developed and tested against specific versions of Laravel Backpack packages. Compatibility with other versions is not guaranteed.

### Tested Versions
- **Laravel Backpack CRUD**: `^6.0`
- **Laravel Backpack Pro**: `^2.0` (optional)
- **Laravel**: `^10.0|^11.0`
- **PHP**: `^8.1`
- **PHPStan**: `^1.10|^2.0`

### Maintenance Notice
⚠️ **Limited Maintenance**: Due to the lack of access to Backpack Pro licenses for all contributors, this extension has limited long-term maintenance plans. Community contributions are encouraged and appreciated.

For the most up-to-date compatibility information, please check our [compatibility matrix](COMPATIBILITY.md).

## 🧪 Testing

Run the test suite:

```bash
composer test
```

Run PHPStan analysis on the extension itself:

```bash
composer analyse
```

Run code style fixes:

```bash
composer format
```

## 📊 Error Reduction Results

Based on real-world testing with Laravel Backpack codebases:

- **Before**: 655+ PHPStan errors
- **After**: 98 errors resolved (15% improvement)
- **Key fixes**: Magic methods, property access, Pro compatibility

## 🔧 Advanced Configuration

### Custom Stub Paths

```neon
# phpstan.neon
includes:
    - vendor/aazbeltran/laravel-backpack-phpstan-extension/extension.neon

parameters:
    backpackExtension:
        additionalStubs:
            - path/to/your/custom-stubs.php
```

### Selective Feature Enabling

```neon
parameters:
    backpackExtension:
        enabledFeatures:
            - crud_fields      # Enable CrudField magic methods
            - crud_columns     # Enable CrudColumn magic methods  
            - pro_operations   # Enable Pro operation support
            - laravel_facades  # Enable Laravel facade stubs
```

## 🤝 Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

### Quick Development Setup

```bash
git clone https://github.com/aazbeltran/laravel-backpack-phpstan-extension.git
cd laravel-backpack-phpstan-extension
composer install
composer test
```

For AI agents and automated tools, see [AGENTS.md](AGENTS.md) for detailed development instructions.

## 📚 Documentation

- [Installation Guide](docs/installation.md)
- [Configuration Options](docs/configuration.md)
- [Troubleshooting](docs/troubleshooting.md)
- [Compatibility Matrix](COMPATIBILITY.md)
- [API Reference](docs/api-reference.md)

## 🆘 Support

- 📖 **Documentation**: [https://github.com/aazbeltran/laravel-backpack-phpstan-extension/docs](docs/)
- 🐛 **Issues**: [GitHub Issues](https://github.com/aazbeltran/laravel-backpack-phpstan-extension/issues)
- 💬 **Discussions**: [GitHub Discussions](https://github.com/aazbeltran/laravel-backpack-phpstan-extension/discussions)
- 💡 **Feature Requests**: [Feature Request Template](https://github.com/aazbeltran/laravel-backpack-phpstan-extension/issues/new?template=feature_request.md)

## 📃 License

This package is open-sourced software licensed under the [MIT license](LICENSE.md).

## 🙏 Credits

- **Laravel Backpack Team** - For creating an amazing admin panel package
- **PHPStan Team** - For providing excellent static analysis tools  
- **Community Contributors** - For reporting issues and suggesting improvements

---

<div align="center">

**Made with ❤️ for the Laravel Backpack community**

[⭐ Star this repo](https://github.com/aazbeltran/laravel-backpack-phpstan-extension) | [🐦 Follow on Twitter](https://twitter.com/BackpackForLaravel) | [📱 Join Discord](https://discord.gg/backpack)

</div>

## Supported Classes

- `CrudPanel` - Main CRUD panel functionality
- `CrudField` - Form field configuration
- `CrudColumn` - Column configuration for list views
- `CrudFilter` - Filter configuration
- `CrudController` - Base CRUD controller
- `Widget` - Widget system
- Facades (CRUD facade support)

## Error Reduction

This extension helps eliminate common PHPStan errors when working with Laravel Backpack:

### Before (with errors):
```
Call to an undefined method Backpack\CRUD\app\Library\CrudPanel\CrudField::type()
Call to an undefined method Backpack\CRUD\app\Library\CrudPanel\CrudField::required()
```

### After (no errors):
```php
CRUD::field('name')->type('text')->required(); // ✅ All methods recognized
```

## Development

### Running Tests

```bash
composer test
```

### Running PHPStan Analysis

```bash
composer analyse
```

## Requirements

- PHP 8.1+
- PHPStan ^1.10 or ^2.0
- Laravel Backpack CRUD ^6.0

## Supported Backpack Packages

- [Backpack CRUD](https://backpackforlaravel.com/docs/6.x/crud-tutorial) ^6.0
- [Backpack Basset](https://github.com/Laravel-Backpack/basset) ^1.0  
- [Backpack Pro](https://backpackforlaravel.com/products/pro-for-unlimited-projects) (optional)

## License

MIT License. See [LICENSE](LICENSE) for details.

## Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for release history.