# Version Compatibility Matrix

This document outlines the tested compatibility matrix for the Laravel Backpack PHPStan Extension.

## ⚠️ Important Compatibility Notice

**This extension was built and tested against specific versions of Laravel Backpack packages. Compatibility with newer versions is not guaranteed and may require updates to stubs and extension logic.**

## 🎯 Tested Compatibility Matrix

| Component | Tested Version | Status | Notes |
|-----------|---------------|--------|--------|
| **PHP** | 8.1, 8.2, 8.3 | ✅ Fully Supported | Required minimum: PHP 8.1 |
| **PHPStan** | 1.10+, 2.0+ | ✅ Fully Supported | Both major versions supported |
| **Laravel** | 10.x, 11.x | ✅ Tested | Should work with 12.x |
| **Backpack CRUD** | 6.0+ | ✅ Stubs Generated | Built against 6.0.x series |
| **Backpack Basset** | 1.0+ | ✅ Basic Support | Minimal static analysis needs |
| **Backpack Pro** | 6.0+ | ⚠️ Limited Support | Stubs for core operations only |

## 🔍 Version-Specific Notes

### Backpack CRUD 6.0+
- ✅ Dynamic field/column methods fully supported
- ✅ Fluent interface chains properly typed
- ✅ Magic `__call` methods handled
- ⚠️ New operations in 6.1+ may need stub updates

### Backpack Pro 6.0+
- ✅ Clone, Fetch, InlineCreate operations stubbed
- ✅ Chart controllers covered
- ❌ Advanced Pro fields/widgets may lack coverage
- ⚠️ Pro package updates frequently - monitor for breaking changes

### PHPStan 1.x vs 2.x
- ✅ Extension works with both major versions
- ✅ Configuration automatically adapts
- ✅ `scanFiles` parameter used for 2.x compatibility

## 🚨 Known Limitations

### Pro Package Limitations
Due to licensing restrictions, we cannot:
- ❌ Install Pro package in CI/CD
- ❌ Test against all Pro features
- ❌ Guarantee compatibility with Pro updates
- ❌ Provide comprehensive Pro field/widget stubs

### Version Drift Risk
As Backpack packages evolve:
- 🔄 New dynamic methods may not be covered
- 🔄 Method signatures may change
- 🔄 New operations/features need manual stub updates
- 🔄 PHP/Laravel version bumps may require testing

## 🔧 Compatibility Checking

### Manual Compatibility Check
```bash
# 1. Update to latest Backpack versions
composer update backpack/crud backpack/basset

# 2. Inspect for changes
./scripts/inspect-backpack.sh

# 3. Run health check
./scripts/health-check.sh

# 4. Test PHPStan analysis
./scripts/test-extension.sh
```

### Automated Monitoring
The extension includes automated compatibility monitoring:
- 📅 Weekly CI checks for package updates
- 🤖 Automatic issue creation for compatibility problems
- 📊 Health checks in release pipeline

## 🛠️ Updating for New Versions

### When Backpack CRUD Updates
1. **Check for new dynamic methods**
   ```bash
   ./scripts/inspect-backpack.sh
   ```

2. **Update stubs if needed**
   - Review `stubs/CrudField.stub`
   - Review `stubs/CrudColumn.stub`
   - Add new methods maintaining fluent interface

3. **Test compatibility**
   ```bash
   composer test
   ./scripts/health-check.sh
   ```

### When PHPStan Updates
1. **Test with new version**
   ```bash
   composer require phpstan/phpstan:^X.Y --dev
   vendor/bin/phpstan analyse src
   ```

2. **Check extension configuration**
   - Review `extension.neon` for deprecated parameters
   - Update service definitions if needed

3. **Validate across PHP versions**
   - Run CI pipeline or test locally across PHP 8.1-8.3

## 📈 Roadmap for Version Support

### Short Term (3-6 months)
- 🎯 Monitor Backpack 6.1+ releases
- 🎯 Test Laravel 12.x compatibility
- 🎯 Support PHP 8.4 when stable

### Medium Term (6-12 months)
- 🎯 Implement dynamic stub generation
- 🎯 Improve Pro package coverage
- 🎯 Add semantic versioning for stubs

### Long Term (1+ years)
- 🎯 PHPStan 3.x preparation
- 🎯 Backpack 7.x compatibility planning
- 🎯 Community contribution workflow

## 🆘 Compatibility Issues

### Reporting Issues
If you encounter compatibility issues:

1. **Check existing issues** at [GitHub Issues](https://github.com/aazbeltran/laravel-backpack-phpstan-extension/issues)

2. **Provide detailed information**:
   - PHP version
   - PHPStan version
   - Backpack package versions
   - Specific PHPStan errors
   - Minimal reproduction example

3. **Include environment details**:
   ```bash
   php --version
   composer show backpack/crud
   composer show phpstan/phpstan
   vendor/bin/phpstan --version
   ```

### Community Contributions
See [AGENTS.md](AGENTS.md) for guidelines on:
- Agentic maintenance procedures
- Automated compatibility updates
- Contributing fixes and improvements
