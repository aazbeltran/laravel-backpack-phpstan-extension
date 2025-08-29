# AGENTS.md - Agentic Maintenance & Development Guide

This document outlines the agentic (AI-assisted) maintenance and development patterns for the Laravel Backpack PHPStan Extension. This project was built with AI assistance and is designed to be maintained through automated and semi-automated processes.

## 🤖 Project Philosophy

This extension embraces **agentic development** - a paradigm where AI agents assist in code maintenance, issue detection, and feature development. The codebase is structured to be:

- **Self-documenting**: Clear patterns that AI can understand and extend
- **Test-driven**: Comprehensive tests that validate functionality automatically  
- **Modular**: Components that can be updated independently
- **Pattern-based**: Consistent approaches that AI can replicate

## 🔧 Maintenance Automation

### Automated Workflows

1. **Continuous Integration** (`.github/workflows/ci.yml`)
   - Tests across PHP 8.1-8.3 and PHPStan 1.x-2.x
   - Laravel compatibility testing
   - Code style enforcement

2. **Scheduled Maintenance** (`.github/workflows/maintenance.yml`)
   - Weekly compatibility checks
   - Dependency update detection
   - Automatic issue creation for problems

3. **Release Automation** (`.github/workflows/release.yml`)
   - Automated releases on git tags
   - Package validation
   - GitHub release notes generation

### Maintenance Commands

```bash
# Run full test suite
composer test

# Analyze code with PHPStan
composer analyse

# Fix code style
composer fix-style

# Check for package updates
composer outdated

# Test extension loading
./scripts/test-extension.sh
```

## 🎯 Common Maintenance Tasks

### 1. Adding Support for New Backpack Versions

When new Backpack versions are released:

```bash
# 1. Update dependencies
composer require backpack/crud:^6.1 --dev

# 2. Inspect new/changed classes
./scripts/inspect-backpack.sh

# 3. Update stubs if needed
# Check: stubs/CrudField.stub, stubs/CrudColumn.stub, etc.

# 4. Run tests
composer test

# 5. Update version constraints
# Edit: composer.json "suggest" section
```

### 2. Extending Pro Package Support

For new Pro operations/features:

```bash
# 1. Explore Pro package structure
find vendor/backpack/pro -name "*.php" -path "*/Operations/*" | head -10

# 2. Create stub files
# Pattern: stubs/Pro/NewOperation.stub

# 3. Add to extension.neon
# Add to scanFiles section

# 4. Create tests
# Pattern: tests/Integration/Pro/NewOperationTest.php
```

### 3. PHPStan Version Compatibility

When PHPStan releases major updates:

```bash
# 1. Test with new version
composer require phpstan/phpstan:^2.1 --dev

# 2. Check extension loading
vendor/bin/phpstan analyse --level 8 src

# 3. Update extension.neon if needed
# Check for deprecated parameters

# 4. Update CI matrix
# Edit: .github/workflows/ci.yml
```

## 🧠 AI Agent Interaction Patterns

### Code Analysis Prompts

When working with AI agents on this project, use these patterns:

```
1. "Analyze the Laravel Backpack source code in [directory] and identify 
   dynamic methods that need PHPStan stubs"

2. "Compare the current CrudField.stub with the actual CrudField class 
   and suggest updates"

3. "Review the PHPStan extension configuration and identify missing 
   dynamic method support"

4. "Generate test cases for the new [FeatureName] extension functionality"
```

### Debugging Workflow

```
1. "I'm getting PHPStan error [error]. Please analyze the codebase 
   and suggest the required stub or extension update"

2. "The extension is not detecting methods for [ClassName]. 
   Please review the reflection extension and fix the issue"

3. "Tests are failing for [TestName]. Please identify the root cause 
   and provide a fix"
```

## 📋 Contribution Guidelines for AI Agents

### Code Standards

1. **Follow existing patterns** - Maintain consistency with current structure
2. **Add comprehensive tests** - Every new feature needs test coverage
3. **Update documentation** - Keep README and this file current
4. **Version compatibility** - Test against supported PHP/PHPStan versions

### Stub Creation Guidelines

```php
// Pattern for new stubs
<?php

namespace Backpack\Package\Path;

/**
 * [Description] stub for PHPStan static analysis
 * 
 * This class uses magic methods (__call) to provide fluent interface
 * for configuring [feature]. All setter methods return $this for chaining.
 */
class ClassName
{
    /** @var array<string, mixed> */
    protected $attributes = [];

    public function __construct(array $data = [])
    {
        $this->attributes = $data;
    }

    // Explicit method declarations for common methods
    public function commonMethod(string $param): self
    {
        return $this;
    }

    // Magic method for dynamic attributes
    public function __call(string $method, array $parameters): self
    {
        $this->attributes[$method] = $parameters[0] ?? true;
        return $this;
    }
}
```

### Extension Pattern

```php
// Pattern for new reflection extensions
<?php

namespace LaravelBackpackPhpstanExtension\Methods;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\Reflection\MethodReflection;

class NewClassMethodsClassReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        // Check if this extension should handle this class/method
        return $classReflection->getName() === 'Target\\Class\\Name'
            && in_array($methodName, $this->getSupportedMethods());
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        return new NewClassMethodReflection($classReflection, $methodName);
    }

    private function getSupportedMethods(): array
    {
        return [
            // List of dynamic methods this extension supports
        ];
    }
}
```

## 🚨 Issue Detection & Resolution

### Automated Issue Detection

The maintenance workflow automatically detects:

- ❌ Backpack package updates that break compatibility
- ❌ PHPStan version conflicts  
- ❌ Test failures across PHP versions
- ❌ Missing stub coverage for new classes
- ❌ Deprecated extension patterns

### Resolution Process

1. **Automated Issue Creation** - GitHub Actions creates issues for detected problems
2. **AI Agent Analysis** - Use prompts from this guide to analyze the issue
3. **Targeted Fixes** - Apply specific fixes based on issue type
4. **Validation** - Run tests to confirm fix
5. **Documentation Update** - Update relevant docs if needed

## 📊 Metrics & Monitoring

### Key Metrics to Track

- **Test Coverage**: Maintain >90% coverage
- **PHPStan Level**: Support level 8 analysis
- **Version Compatibility**: Support matrix defined in CI
- **Issue Resolution Time**: Target <7 days for compatibility issues

### Health Checks

```bash
# Extension health check
./scripts/health-check.sh

# Outputs:
# ✅ All stubs exist and are valid
# ✅ Extension classes load correctly  
# ✅ Tests pass across PHP versions
# ✅ PHPStan analysis completes successfully
# ✅ No deprecated patterns detected
```

## 🔮 Future Development

### Planned Enhancements

1. **Dynamic Stub Generation** - Auto-generate stubs from Backpack source
2. **Intelligent Compatibility Detection** - Smarter version compatibility checks
3. **Community Contributions** - Streamlined process for external contributions
4. **Advanced Pattern Recognition** - Better detection of Laravel patterns

### Technology Evolution

- **PHPStan 3.x Preparation** - Monitor for breaking changes
- **PHP 8.4+ Support** - Add support as versions stabilize
- **Laravel 12+ Compatibility** - Ensure forward compatibility
- **Backpack Evolution** - Track major architectural changes

## 📞 Support & Escalation

### For AI Agents

1. **Routine Maintenance** - Follow patterns in this document
2. **Complex Issues** - Create detailed issue with analysis
3. **Architectural Changes** - Flag for human review

### For Humans

1. **Review AI Contributions** - Validate automated fixes
2. **Approve Breaking Changes** - Major version updates
3. **Strategic Decisions** - Technology choices, architecture

---

**Last Updated**: December 2024  
**Maintained By**: AI Agents + Human Oversight  
**License**: MIT