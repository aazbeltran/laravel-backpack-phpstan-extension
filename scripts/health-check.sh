#!/bin/bash
# Health Check Script for Laravel Backpack PHPStan Extension

set -e

echo "🔍 Laravel Backpack PHPStan Extension Health Check"
echo "=================================================="

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

success() {
    echo -e "${GREEN}✅ $1${NC}"
}

error() {
    echo -e "${RED}❌ $1${NC}"
}

warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

# Function to check if file exists
check_file() {
    if [ -f "$1" ]; then
        success "$2"
        return 0
    else
        error "$2"
        return 1
    fi
}

# Function to check if directory exists and has files
check_directory() {
    if [ -d "$1" ] && [ "$(ls -A $1)" ]; then
        success "$2"
        return 0
    else
        error "$2"
        return 1
    fi
}

echo ""
echo "📁 Checking Project Structure..."

# Check essential files
check_file "composer.json" "composer.json exists"
check_file "extension.neon" "PHPStan extension config exists"
check_file "bootstrap.php" "Bootstrap file exists"
check_file "README.md" "README documentation exists"
check_file "AGENTS.md" "Agentic maintenance guide exists"

# Check directories
check_directory "src" "Source code directory exists and has files"
check_directory "stubs" "Stubs directory exists and has files"
check_directory "tests" "Tests directory exists and has files"
check_directory ".github/workflows" "CI/CD workflows exist"

echo ""
echo "🧪 Running Tests..."

# Install dependencies if needed
if [ ! -d "vendor" ]; then
    echo "Installing dependencies..."
    composer install --quiet
fi

# Run PHPUnit tests
if composer test > /dev/null 2>&1; then
    success "All tests pass"
else
    error "Tests are failing"
    echo "Run 'composer test' for details"
fi

echo ""
echo "🔧 Checking PHPStan Integration..."

# Test PHPStan analysis on our own code
if vendor/bin/phpstan analyse src --level 8 --quiet > /dev/null 2>&1; then
    success "PHPStan analysis passes on source code"
else
    error "PHPStan analysis fails on source code"
fi

# Test extension loading
if echo "parameters:
  level: 8
  paths:
    - tests/fixtures
includes:
  - extension.neon" | vendor/bin/phpstan analyse -c - --quiet > /dev/null 2>&1; then
    success "Extension loads correctly in PHPStan"
else
    error "Extension fails to load in PHPStan"
fi

echo ""
echo "📦 Checking Package Health..."

# Check composer.json validity
if composer validate --quiet > /dev/null 2>&1; then
    success "composer.json is valid"
else
    error "composer.json validation fails"
fi

# Check for security vulnerabilities
if composer audit --quiet > /dev/null 2>&1; then
    success "No security vulnerabilities detected"
else
    warning "Security audit found issues (run 'composer audit' for details)"
fi

echo ""
echo "🎯 Stub Validation..."

# Check that all core stubs exist
core_stubs=(
    "CrudPanel.stub"
    "CrudField.stub"
    "CrudColumn.stub"
    "CrudFilter.stub"
    "Widget.stub"
    "CrudController.stub"
    "CrudPanelFacade.stub"
    "LaravelFacades.stub"
)

stub_errors=0
for stub in "${core_stubs[@]}"; do
    if [ -f "stubs/$stub" ]; then
        success "Core stub exists: $stub"
    else
        error "Missing core stub: $stub"
        ((stub_errors++))
    fi
done

# Check Pro stubs
pro_stubs=(
    "Pro/CloneOperation.stub"
    "Pro/FetchOperation.stub"
    "Pro/InlineCreateOperation.stub"
    "Pro/ChartController.stub"
)

for stub in "${pro_stubs[@]}"; do
    if [ -f "stubs/$stub" ]; then
        success "Pro stub exists: $stub"
    else
        error "Missing Pro stub: $stub"
        ((stub_errors++))
    fi
done

echo ""
echo "🔍 Extension Class Validation..."

# Check that all extension classes exist and are properly autoloaded
extension_classes=(
    "LaravelBackpackPhpstanExtension\\Methods\\CrudFieldMethodsClassReflectionExtension"
    "LaravelBackpackPhpstanExtension\\Methods\\CrudColumnMethodsClassReflectionExtension"
    "LaravelBackpackPhpstanExtension\\Reflection\\CrudFieldMethodReflection"
    "LaravelBackpackPhpstanExtension\\Reflection\\CrudColumnMethodReflection"
    "LaravelBackpackPhpstanExtension\\ReturnTypes\\CrudFieldFluentReturnTypeExtension"
    "LaravelBackpackPhpstanExtension\\ReturnTypes\\CrudColumnFluentReturnTypeExtension"
)

class_errors=0
for class in "${extension_classes[@]}"; do
    if php -r "require 'vendor/autoload.php'; class_exists('$class') ? exit(0) : exit(1);" > /dev/null 2>&1; then
        success "Extension class exists: $(basename $class)"
    else
        error "Missing extension class: $class"
        ((class_errors++))
    fi
done

echo ""
echo "📊 Summary..."

total_errors=$((stub_errors + class_errors))

if [ $total_errors -eq 0 ]; then
    success "All health checks passed! Extension is ready for use."
    echo ""
    echo "🚀 Quick Start:"
    echo "   composer require --dev aazbeltran/laravel-backpack-phpstan-extension"
    echo "   vendor/bin/phpstan analyse"
else
    error "Health check found $total_errors issue(s). Please fix before using."
    echo ""
    echo "🔧 Next Steps:"
    echo "   1. Review failed checks above"
    echo "   2. Run 'composer install' if dependencies are missing"
    echo "   3. Check AGENTS.md for maintenance procedures"
    echo "   4. Run this script again after fixes"
fi

echo ""
echo "📚 Resources:"
echo "   📖 README.md - Installation and usage guide"
echo "   🤖 AGENTS.md - Agentic maintenance procedures"
echo "   🧪 composer test - Run full test suite"
echo "   🔍 composer analyse - Run PHPStan analysis"

exit $total_errors