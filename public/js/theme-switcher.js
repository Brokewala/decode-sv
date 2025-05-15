// Script pour la gestion du mode sombre/clair
document.addEventListener('DOMContentLoaded', function() {
    console.log("Theme switcher loaded");
    applyTheme();
    
    // Ajouter l'écouteur d'événement au bouton de bascule du thème
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            toggleTheme();
            // Force reload pour appliquer le thème
            window.location.reload();
        });
    }
});

// Appliquer le thème depuis localStorage
function applyTheme() {
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    
    const isDarkMode = localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
    
    console.log("Current theme:", isDarkMode ? "dark" : "light");
    
    if (isDarkMode) {
        // Mode sombre
        document.documentElement.classList.add('dark');
        if (themeToggleLightIcon && themeToggleDarkIcon) {
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
        }
    } else {
        // Mode clair
        document.documentElement.classList.remove('dark');
        if (themeToggleLightIcon && themeToggleDarkIcon) {
            themeToggleDarkIcon.classList.remove('hidden');
            themeToggleLightIcon.classList.add('hidden');
        }
    }
}

// Basculer le thème
function toggleTheme() {
    const isDarkMode = document.documentElement.classList.contains('dark');
    
    console.log("Toggling theme from:", isDarkMode ? "dark" : "light");
    
    if (isDarkMode) {
        // Passer en mode clair
        document.documentElement.classList.remove('dark');
        localStorage.setItem('color-theme', 'light');
    } else {
        // Passer en mode sombre
        document.documentElement.classList.add('dark');
        localStorage.setItem('color-theme', 'dark');
    }
    
    console.log("Theme set to:", localStorage.getItem('color-theme'));
}