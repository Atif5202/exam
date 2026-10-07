# BiblioTech - Gestion de bibliothèque

Application Laravel : livres, adhérents, emprunts et retours, tableau de bord.

## Stack choisie

- PHP 8.3 / Laravel 13
- Base MySQL (`examen` sur 127.0.0.1:3306, voir `.env`)
- Eloquent, migrations, seeders
- Vues Blade + Tailwind CSS (via Vite)
- Authentification Laravel (session)

## Installation et lancement

```sh
cd d:\www\examen\laravel
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Créer la base MySQL `examen` (vide), puis :

```sh
php artisan migrate --seed
npm run build
php artisan serve
```

Ouvrir http://localhost:8000 (redirige vers /login).

## Compte et données de test

- Email : `bibliothecaire@example.com`
- Mot de passe : `bibliothecaire`

Données : 10 livres, 5 adhérents, 3 emprunts en cours dont 1 en retard.

## Fonctionnalités réalisées

- F1 : CRUD livres (liste, ajout, modification, suppression)
- F2 : CRUD adhérents (liste, ajout, modification, suppression)
- F3 : validation des formulaires avec messages en français
- F4 : enregistrer un emprunt (retour prévu = +14 jours par défaut)
- F5 : enregistrer un retour (stock remonté)
- F6 : recherche titre/auteur, filtre catégorie, filtre disponibles uniquement
- F7 : liste des emprunts en cours, retards en ligne rouge
- F8 : tableau de bord (livres, adhérents, en cours, retards)
- F9 : authentification bibliothécaire (toutes les pages protégées)
- F10 : pagination de la liste des livres (10 par page)
- F11 : historique des emprunts sur la fiche adhérent
- F12 : export CSV des emprunts en cours

## Règles de gestion

1. Emprunt seulement si quantite_disponible > 0
2. Emprunt = -1 en stock, retour = +1 en stock
3. Maximum 3 emprunts en cours par adhérent
4. Adhérent en retard ne peut pas emprunter
5. Livre ou adhérent avec emprunts en cours ne peut pas être supprimé
6. quantite_totale ne peut pas passer sous le nombre d'exemplaires empruntés

## Limites connues

- Un seul compte bibliothécaire, pas de rôles multiples
- Pas d'inscription publique (compte créé par seeder)
- Historique adhérent sans pagination
- CSV avec séparateur point-virgule et BOM UTF-8 pour Excel
