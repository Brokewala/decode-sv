#!/bin/bash

# Script pour remplacer les références GitHub restantes dans les templates

cd /home/acer/Bureau/work/project_IA/decode_sv

# Références spécifiques aux hover states et autres cas manqués
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:text-github-accent/dark:hover:text-dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:bg-github-accent/dark:hover:bg-dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:text-github-text-secondary/dark:text-dark-textSecondary/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-bg\/10/dark:bg-dark-bg\/10/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-bg\/15/dark:bg-dark-bg\/15/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github-bg\/5/dark:bg-dark-bg\/5/g' {} \;

# Vérifier s'il reste des références
echo "Références GitHub restantes:"
grep -r "github" resources/views --include="*.blade.php" | wc -l

echo "Remplacement des références GitHub restantes terminé"