#!/bin/bash

# Script complet pour remplacer toutes les références du thème GitHub par le thème professionnel

cd /home/acer/Bureau/work/project_IA/decode_sv

# Remplacements pour tous les fichiers blade
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:hover:text-github-accent/dark:hover:text-dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/hover:text-github-accent/hover:text-dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/dark:bg-github/dark:bg-dark/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/text-github-/text-dark-/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-accent/dark-accent/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-button/dark-button/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-buttonHover/dark-buttonHover/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-bg/dark-bg/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-header/dark-header/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-secondary/dark-surface/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-hover/dark-surface/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-border/dark-border/g' {} \;
find resources/views -type f -name "*.blade.php" -exec sed -i 's/github-text/dark-text/g' {} \;

# Vérifier s'il reste des références et les afficher
echo "Références GitHub restantes:"
echo "-------------------------"
grep -r "github" resources/views --include="*.blade.php"
echo "-------------------------"
echo "Nombre total de références restantes : $(grep -r "github" resources/views --include="*.blade.php" | wc -l)"

echo "Remplacement du thème GitHub par le thème professionnel terminé."