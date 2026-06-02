

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Floating Chat Button Handler
document.addEventListener('DOMContentLoaded', function() {
    const chatButton = document.getElementById('chatButton');
    
    if (chatButton) {
        chatButton.addEventListener('click', function() {
            // Vérifier si l'utilisateur est connecté
            const isAuth = document.querySelector('[data-auth]')?.dataset.auth === 'true';
            
            if (isAuth) {
                // Rediriger vers le chat
                window.location.href = '/chat';
            } else {
                // Afficher une alerte ou rediriger vers la connexion
                window.location.href = '/login';
            }
        });
        
        // Animation d'entrée
        chatButton.style.opacity = '0';
        chatButton.style.transform = 'scale(0.8)';
        setTimeout(() => {
            chatButton.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
            chatButton.style.opacity = '1';
            chatButton.style.transform = 'scale(1)';
        }, 300);
    }
});

