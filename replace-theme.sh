#!/bin/bash

# Script pour remplacer les classes GitHub par de nouvelles classes professionnelles dark/light

cd /home/acer/Bureau/work/project_IA/decode_sv

# Remplacements principaux
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-bg/dark:bg-dark-bg/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-secondary/dark:bg-dark-surface/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-header/dark:bg-dark-header/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:border-github-border/dark:border-dark-border/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:text-github-text/dark:text-dark-text/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:bg-github-secondary/dark:hover:bg-dark-surface/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:focus:border-github-accent/dark:focus:border-dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:focus:ring-github-accent/dark:focus:ring-dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:focus:ring-offset-github-bg/dark:focus:ring-offset-dark-bg/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:text-github-accent/dark:text-dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:text-github-hover/dark:hover:text-dark-accentHover/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:bg-github-header/dark:hover:bg-dark-surface/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-button/dark:bg-dark-button/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:bg-github-buttonHover/dark:hover:bg-dark-buttonHover/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-hover/dark:bg-dark-surface/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-bg\//dark:bg-dark-bg\//g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:border-github-accent/dark:hover:border-dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:divide-github-border/dark:divide-dark-border/g' {} \;

# Cas particuliers
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:border-github-accent\/30/dark:hover:border-dark-accent\/30/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-primary-900\/20/dark:bg-dark-surface\/80/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-bg\/20/dark:bg-dark-bg\/20/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:bg-github-bg\/30/dark:hover:bg-dark-bg\/30/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:border-github-accent\/30/dark:border-dark-accent\/30/g' {} \;

# Modification du JS pour utiliser le nouveau thème
sed -i 's/github-hover/dark-surface/g' public/js/theme-switcher.js
sed -i 's/github-secondary/dark-surface/g' public/js/theme-switcher.js
sed -i 's/github-accent/dark-accent/g' public/js/theme-switcher.js
sed -i 's/github-header/dark-header/g' public/js/theme-switcher.js
sed -i 's/github-bg/dark-bg/g' public/js/theme-switcher.js
sed -i 's/github-button/dark-button/g' public/js/theme-switcher.js
sed -i 's/github-buttonHover/dark-buttonHover/g' public/js/theme-switcher.js
sed -i 's/github-border/dark-border/g' public/js/theme-switcher.js

echo "Remplacement des classes de thème terminé"