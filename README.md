# E-commerce Laravel — Boutique + Chatbot IA

Projet Framework Web (ITeam) : plateforme e-commerce avec administration, panier, commandes et assistant IA connecté aux données métier (Groq).

## Prérequis

- PHP 8.3+
- Composer
- MySQL (XAMPP)
- Node.js 18+
- Clé API [Groq](https://console.groq.com/)

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configurer `.env` : base MySQL, `GROQ_API_KEY`, `APP_URL=http://127.0.0.1:8000`

```bash
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

## Comptes

| Rôle | Connexion |
|------|-----------|
| Admin | `/admin/login` |
| Client | `/login` ou `/register` |

Créer un admin : `role = admin` dans la table `users`, ou seeder `DatabaseSeeder`.

## Tests

```bash
php artisan test
```

Couverture (nécessite l’extension PHP **PCOV** ou **Xdebug**) :

```bash
php artisan test --coverage --min=80
```

Les tests mockent l'API Groq (pas d'appel réel). Rapport HTML : `build/coverage/`.

## Structure

- `app/Models/` — User, Product, Category, Order, ChatMessage
- `app/Services/` — ChatService, OrderCheckoutService
- `app/Policies/` — OrderPolicy
- `app/Http/Middleware/` — IsAdmin
- `routes/web.php` — boutique + admin
- `docs/Diagrammes-UML-Ecommerce.html` — diagrammes UML

## Chatbot

Flux : question → `ChatController` → `ChatService` (contexte Eloquent + historique) → API Groq → réponse JSON + sauvegarde en base.

Route : `POST /chat` (authentification requise).
