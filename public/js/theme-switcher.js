// Script pour la gestion du mode sombre/clair
document.addEventListener('DOMContentLoaded', function() {
    initTheme();
    
    // Ajouter l'écouteur d'événement au bouton de bascule du thème
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }
});

// Initialiser le thème
function initTheme() {
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    
    // Vérifier si le thème sombre est activé
    if (localStorage.getItem('color-theme') === 'dark' ||
        (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        // Mode sombre
        document.documentElement.classList.add('dark');
        // Afficher l'icône de la lune
        themeToggleLightIcon.classList.remove('hidden');
        themeToggleDarkIcon.classList.add('hidden');
    } else {
        // Mode clair
        document.documentElement.classList.remove('dark');
        // Afficher l'icône du soleil
        themeToggleDarkIcon.classList.remove('hidden');
        themeToggleLightIcon.classList.add('hidden');
    }
}

// Basculer le thème
function toggleTheme() {
    const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
    
    // Basculer les icônes
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');
    
    // Si le thème est actuellement sombre, passer en clair
    if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('color-theme', 'light');
    } else {
        // Sinon, passer en sombre
        document.documentElement.classList.add('dark');
        localStorage.setItem('color-theme', 'dark');
    }
}