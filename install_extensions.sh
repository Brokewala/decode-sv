#!/bin/bash

echo "=== Installation des extensions PHP manquantes ==="

# Vérifier les extensions actuellement installées
echo "Extensions PHP actuellement installées :"
php -m | sort

echo ""
echo "=== Vérification des extensions critiques ==="

# Fonction pour vérifier une extension
check_extension() {
    if php -m | grep -q "^$1$"; then
        echo "✓ $1 est installé"
        return 0
    else
        echo "✗ $1 n'est PAS installé"
        return 1
    fi
}

# Vérifier les extensions critiques
check_extension "mbstring"
check_extension "sqlite3"
check_extension "pdo_sqlite"
check_extension "openssl"
check_extension "json"
check_extension "tokenizer"
check_extension "xml"
check_extension "ctype"
check_extension "fileinfo"
check_extension "gd"

echo ""
echo "=== Tentative d'installation via apt (nécessite sudo) ==="

# Essayer d'installer les extensions manquantes
if ! check_extension "mbstring"; then
    echo "Tentative d'installation de php-mbstring..."
    sudo apt install -y php8.4-mbstring || echo "Échec de l'installation de mbstring"
fi

if ! check_extension "gd"; then
    echo "Tentative d'installation de php-gd..."
    sudo apt install -y php8.4-gd || echo "Échec de l'installation de gd"
fi

if ! check_extension "xml"; then
    echo "Tentative d'installation de php-xml..."
    sudo apt install -y php8.4-xml || echo "Échec de l'installation de xml"
fi

if ! check_extension "curl"; then
    echo "Tentative d'installation de php-curl..."
    sudo apt install -y php8.4-curl || echo "Échec de l'installation de curl"
fi

echo ""
echo "=== Vérification finale ==="
php -m | sort
