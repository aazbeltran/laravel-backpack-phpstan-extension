#!/bin/bash
# Inspect Backpack Package Structure for PHPStan Extension Updates

set -e

echo "🔍 Backpack Package Structure Inspector"
echo "========================================"

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

success() {
    echo -e "${GREEN}✅ $1${NC}"
}

warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

# Function to analyze a PHP class
analyze_class() {
    local file="$1"
    local class_name=$(basename "$file" .php)
    
    echo ""
    echo "📋 Class: $class_name"
    echo "   File: $file"
    
    # Extract namespace
    local namespace=$(grep -m1 "^namespace " "$file" 2>/dev/null | sed 's/namespace //; s/;//')
    if [ ! -z "$namespace" ]; then
        echo "   Namespace: $namespace"
    fi
    
    # Check for magic methods
    if grep -q "__call" "$file" 2>/dev/null; then
        echo "   🪄 Has __call magic method"
    fi
    
    # Extract public methods
    local methods=$(grep -o "public function [a-zA-Z_][a-zA-Z0-9_]*" "$file" 2>/dev/null | sed 's/public function //' | head -10)
    if [ ! -z "$methods" ]; then
        echo "   📝 Public methods (first 10):"
        echo "$methods" | sed 's/^/      - /'
    fi
    
    # Check for traits used
    local traits=$(grep -o "use [A-Z][a-zA-Z0-9_\\\\]*;" "$file" 2>/dev/null | sed 's/use //; s/;//' | head -5)
    if [ ! -z "$traits" ]; then
        echo "   🔗 Uses traits:"
        echo "$traits" | sed 's/^/      - /'
    fi
}

# Function to inspect a package
inspect_package() {
    local package_path="$1"
    local package_name="$2"
    
    echo ""
    echo "📦 Inspecting $package_name"
    echo "Path: $package_path"
    
    if [ ! -d "$package_path" ]; then
        warning "Package not found at $package_path"
        return 1
    fi
    
    # Find key classes
    echo ""
    info "Looking for key classes..."
    
    # CRUD specific classes
    if [ "$package_name" = "CRUD" ]; then
        local crud_classes=(
            "app/Library/CrudPanel/CrudPanel.php"
            "app/Library/CrudPanel/CrudField.php"
            "app/Library/CrudPanel/CrudColumn.php"
            "app/Library/CrudPanel/CrudFilter.php"
            "app/Library/Widget.php"
            "app/Http/Controllers/CrudController.php"
        )
        
        for class_file in "${crud_classes[@]}"; do
            local full_path="$package_path/$class_file"
            if [ -f "$full_path" ]; then
                analyze_class "$full_path"
            else
                warning "Expected class not found: $class_file"
            fi
        done
        
        # Find operations
        echo ""
        info "Scanning for Operations..."
        find "$package_path" -name "*Operation.php" -type f | head -10 | while read operation; do
            echo "   🎯 $(basename "$operation")"
        done
    fi
    
    # Pro specific classes
    if [ "$package_name" = "Pro" ]; then
        echo ""
        info "Scanning Pro Operations..."
        find "$package_path" -path "*/Operations/*.php" -type f | while read operation; do
            analyze_class "$operation"
        done
        
        echo ""
        info "Scanning Pro Controllers..."
        find "$package_path" -path "*/Controllers/*.php" -type f | head -5 | while read controller; do
            analyze_class "$controller"
        done
        
        echo ""
        info "Scanning Pro Fields/Columns/Widgets..."
        find "$package_path" -path "*/resources/views/fields/*.blade.php" -type f | head -10 | while read field; do
            echo "   🎨 Field: $(basename "$field" .blade.php)"
        done
    fi
}

# Main inspection
echo ""
info "Checking for installed Backpack packages..."

# Install dependencies if needed
if [ ! -d "vendor" ]; then
    echo "Installing dependencies to inspect packages..."
    composer install --quiet
fi

# Inspect CRUD package
if [ -d "vendor/backpack/crud" ]; then
    inspect_package "vendor/backpack/crud" "CRUD"
else
    warning "Backpack CRUD not found. Install with: composer require backpack/crud --dev"
fi

# Inspect Pro package
if [ -d "vendor/backpack/pro" ]; then
    inspect_package "vendor/backpack/pro" "Pro"
else
    warning "Backpack Pro not found. This is expected if you don't have a Pro license."
fi

# Inspect Basset package
if [ -d "vendor/backpack/basset" ]; then
    echo ""
    echo "📦 Inspecting Basset"
    echo "Path: vendor/backpack/basset"
    
    # Basset is simpler, just check for main classes
    find vendor/backpack/basset -name "*.php" -type f | head -5 | while read file; do
        echo "   📄 $(basename "$file")"
    done
else
    warning "Backpack Basset not found. Install with: composer require backpack/basset --dev"
fi

echo ""
echo "🔧 Maintenance Recommendations"
echo "================================"

echo ""
info "Stub Updates Needed:"
echo "   1. Compare analyzed classes with current stubs in stubs/ directory"
echo "   2. Look for new public methods that need stub coverage"
echo "   3. Check for new magic method patterns"
echo "   4. Verify Pro operations are covered in stubs/Pro/"

echo ""
info "Extension Updates Needed:"
echo "   1. Check if new classes need reflection extensions"
echo "   2. Look for new fluent interfaces that need return type extensions"
echo "   3. Verify operation traits are properly handled"

echo ""
info "Test Updates Needed:"
echo "   1. Add tests for any new operations or features"
echo "   2. Update fixture classes if interfaces change"
echo "   3. Verify Pro package tests cover new functionality"

echo ""
info "Next Steps:"
echo "   1. Review the output above"
echo "   2. Update relevant stub files in stubs/ directory"
echo "   3. Add new extension classes if needed in src/"
echo "   4. Update extension.neon configuration"
echo "   5. Add/update tests in tests/ directory"
echo "   6. Run './scripts/health-check.sh' to validate changes"

echo ""
success "Inspection complete! Use this information to update the PHPStan extension."