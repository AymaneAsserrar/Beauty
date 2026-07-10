# Ninich Beauty

Plateforme web de réservation de prestations de beauté en ligne, développée avec Laravel 12, Livewire 3, Blade et Tailwind CSS.

---

## Sommaire

1. [Présentation](#présentation)
2. [Stack technique](#stack-technique)
3. [Fonctionnalités](#fonctionnalités)
4. [Rôles et permissions](#rôles-et-permissions)
5. [Prérequis](#prérequis)
6. [Installation](#installation)
7. [Comptes de démonstration](#comptes-de-démonstration)
8. [Lancement du projet](#lancement-du-projet)
9. [Guide d'utilisation](#guide-dutilisation)
10. [Architecture du code](#architecture-du-code)
11. [Base de données](#base-de-données)
12. [Tests et validation](#tests-et-validation)
13. [Dépannage](#dépannage)

---

## Présentation

Ninich Beauty permet aux clientes de consulter un catalogue de prestations de beauté et de réserver un rendez-vous en ligne, en remplacement de la prise de rendez-vous manuelle (téléphone ou sur place).

L'application gère trois types d'utilisateurs (client, prestataire, administrateur), chacun disposant de son propre tableau de bord et de ses propres droits d'accès.

---

## Stack technique

| Composant | Technologie |
|-----------|-------------|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend réactif | Livewire 3 (interactions sans rechargement de page) |
| Templates | Blade |
| Interface / CSS | Tailwind CSS (responsive) |
| Authentification | Laravel Breeze (stack Livewire) |
| Base de données | MySQL |
| Compilation des assets | Vite |

Remarque : le projet fonctionne sous Laravel 12, qui requiert PHP 8.2. Pour une éventuelle migration vers Laravel 13 (PHP 8.3+), il suffit de mettre à jour la version de PHP puis d'exécuter `composer update` ; le code applicatif reste identique.

---

## Fonctionnalités

- Authentification complète (inscription, connexion, gestion du profil) via Laravel Breeze.
- Catalogue des prestations présenté sous forme de cartes illustrées d'une photo, avec recherche en temps réel.
- Photos des prestations : chaque prestation peut porter une image mise en avant dans le catalogue et sur sa fiche.
- Tunnel de réservation (composant Livewire) : sélection de la prestation, du prestataire, de la date et d'un créneau horaire.
- Créneaux calculés dynamiquement : les heures déjà réservées ou passées sont automatiquement désactivées, en tenant compte de la durée de la prestation.
- Système d'avis et de notes : après une prestation terminée, la cliente laisse une note (1 à 5 étoiles) et un commentaire. La note moyenne et le nombre d'avis sont affichés sur chaque prestation.
- Tableaux de bord adaptés au rôle de l'utilisateur connecté.
- Annulation d'une réservation par le client.
- Protection des routes par un middleware de rôle.

---

## Rôles et permissions

| Rôle | Droits |
|------|--------|
| Client | S'inscrire, se connecter, consulter les prestations et leurs avis, réserver un créneau, consulter et annuler ses réservations, laisser un avis sur une prestation terminée. |
| Prestataire | Consulter uniquement les rendez-vous qui lui sont attribués, les confirmer ou les marquer comme terminés. |
| Administrateur | Gestion complète (création, modification, suppression) des prestations, gestion des utilisateurs, consultation de toutes les réservations et modification de leur statut. |

Le rôle est stocké dans la colonne `role` de la table `users` (valeurs possibles : `client`, `prestataire`, `admin`). Toute inscription publique crée par défaut un compte de type `client`.

---

## Prérequis

- PHP 8.2 ou supérieur, avec les extensions usuelles de Laravel (`pdo_mysql`, `mbstring`, `openssl`, etc.).
- Composer 2.x.
- Node.js 18 ou supérieur et npm.
- MySQL (via XAMPP, WAMP, Laragon ou un serveur MySQL autonome). phpMyAdmin est recommandé pour administrer la base.

---

## Installation

Suivez ces étapes lors d'une première installation sur une nouvelle machine. Si le projet est déjà installé, passez directement à la section [Lancement du projet](#lancement-du-projet).

### 1. Installer les dépendances

```bash
composer install
npm install
```

### 2. Configurer l'environnement

Copiez le fichier d'exemple, puis générez la clé d'application :

```bash
cp .env.example .env
php artisan key:generate
```

Vérifiez ensuite les paramètres de connexion à la base de données dans le fichier `.env` :

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ninich_beauty
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Créer la base de données

Dans phpMyAdmin, créez une base de données vide nommée `ninich_beauty` (interclassement recommandé : `utf8mb4_unicode_ci`).

### 4. Exécuter les migrations et les données de démonstration

```bash
php artisan migrate --seed
```

Cette commande crée les tables (`users`, `prestations`, `reservations`, etc.) et insère les comptes ainsi que les prestations de démonstration.

### 5. Compiler les assets front-end

```bash
npm run build
```

---

## Comptes de démonstration

Ces comptes sont créés automatiquement par le seeder. Le mot de passe est `password` pour chacun d'eux.

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Administrateur | admin@ninich.test | password |
| Prestataire | sara@ninich.test | password |
| Prestataire | imane@ninich.test | password |
| Cliente | cliente@ninich.test | password |

Il est également possible de créer un nouveau compte client via la page d'inscription du site.

---

## Lancement du projet

Ouvrez deux terminaux à la racine du projet.

Terminal 1 - serveur PHP :

```bash
php artisan serve
```

Le site est alors accessible à l'adresse http://127.0.0.1:8000.

Terminal 2 - assets en mode développement (rechargement automatique) :

```bash
npm run dev
```

En production, le mode développement n'est pas nécessaire : les assets sont compilés une seule fois avec `npm run build`.

---

## Guide d'utilisation

### Visiteur

1. Depuis la page d'accueil, accédez au catalogue via le bouton de découverte des prestations.
2. Le catalogue est consultable sans compte, mais la réservation nécessite une connexion.

### Cliente

1. Connectez-vous (cliente@ninich.test / password) ou inscrivez-vous.
2. Ouvrez la page Prestations, choisissez un soin et cliquez sur Réserver.
3. Dans le tunnel de réservation :
   - sélectionnez un prestataire,
   - choisissez une date,
   - sélectionnez un créneau disponible (les créneaux occupés ou passés sont désactivés),
   - ajoutez une remarque si nécessaire, puis confirmez.
4. Retrouvez vos rendez-vous dans la page Mes réservations, où vous pouvez annuler un rendez-vous à venir.
5. Une fois un rendez-vous marqué comme terminé, laissez un avis (note de 1 à 5 étoiles et commentaire) sur la prestation ; cet avis apparaît alors sur la fiche de la prestation.

### Prestataire

1. Connectez-vous (sara@ninich.test / password).
2. Ouvrez la page Mon agenda : seuls vos rendez-vous sont affichés, répartis entre les onglets À venir et Passés.
3. Vous pouvez confirmer un rendez-vous en attente ou le marquer comme terminé.

### Administrateur

1. Connectez-vous (admin@ninich.test / password).
2. Prestations : ajoutez, modifiez, supprimez ou masquez des prestations, et associez-leur une photo.
3. Réservations : consultez l'ensemble des réservations et modifiez leur statut.
4. Utilisateurs : créez, modifiez ou supprimez des comptes et attribuez les rôles (client, prestataire, admin).

Après connexion, la route `/dashboard` redirige automatiquement chaque utilisateur vers le tableau de bord correspondant à son rôle.

---

## Architecture du code

```
app/
  Http/
    Controllers/
      DashboardController.php     Redirige /dashboard selon le rôle
    Middleware/
      RoleMiddleware.php          Protection des routes par rôle (alias 'role')
  Livewire/
    ListPrestations.php           Catalogue et recherche
    BookAppointment.php           Tunnel de réservation (créneaux dynamiques)
    ClientReservations.php        Réservations du client et annulation
    LeaveReview.php               Dépôt d'un avis (note + commentaire)
    Admin/
      PrestationManager.php       Gestion des prestations
      ReservationList.php         Toutes les réservations et leur statut
      UserManager.php             Gestion des utilisateurs
    Prestataire/
      AgendaList.php              Rendez-vous attribués au prestataire
  Models/
    User.php                      Rôles et relations
    Prestation.php                Prestation, photo, note moyenne et avis
    Reservation.php
    Avis.php                      Avis client (note + commentaire)

resources/views/
  welcome.blade.php               Page d'accueil
  livewire/                       Vues des composants Livewire
  client/reservations.blade.php   Page Mes réservations
  admin/                          Pages d'administration
  prestataire/agenda.blade.php    Page agenda du prestataire

routes/web.php                    Routes regroupées par rôle
database/
  migrations/                     Schéma de la base de données
  seeders/DatabaseSeeder.php      Comptes et prestations de démonstration
```

### Middleware de rôle

Le middleware est enregistré dans `bootstrap/app.php` sous l'alias `role`. Il s'utilise ainsi dans les routes :

```php
Route::middleware('role:admin')->group(function () { /* ... */ });
Route::middleware('role:admin,prestataire')->group(function () { /* ... */ });
```

---

## Base de données

### Table `users` (étendue)

| Colonne | Type | Description |
|---------|------|-------------|
| role | enum(admin, prestataire, client) | Rôle de l'utilisateur (défaut : client) |
| phone | string, nullable | Numéro de téléphone |
| bio | text, nullable | Biographie ou spécialité (principalement pour les prestataires) |

### Table `prestations`

| Colonne | Type | Description |
|---------|------|-------------|
| nom | string | Nom de la prestation |
| description | text, nullable | Description |
| prix | decimal(8,2) | Prix |
| duree | int (unsigned) | Durée en minutes |
| image | string, nullable | URL ou chemin de l'image |
| active | boolean | Visibilité dans le catalogue (défaut : true) |

### Table `reservations`

| Colonne | Type | Description |
|---------|------|-------------|
| client_id | clé étrangère vers users | La cliente qui réserve |
| prestataire_id | clé étrangère vers users | Le prestataire assigné |
| prestation_id | clé étrangère vers prestations | La prestation réservée |
| date_heure | datetime | Date et heure du rendez-vous |
| statut | enum | en_attente, confirmee, annulee, terminee |
| notes | text, nullable | Remarque du client |

Une contrainte d'unicité sur le couple (`prestataire_id`, `date_heure`) empêche la double réservation d'un même prestataire sur un même créneau.

### Table `avis`

| Colonne | Type | Description |
|---------|------|-------------|
| reservation_id | clé étrangère vers reservations (unique) | La réservation terminée à l'origine de l'avis (un seul avis par réservation) |
| client_id | clé étrangère vers users | Le client auteur de l'avis |
| prestation_id | clé étrangère vers prestations | La prestation notée |
| note | tinyint (unsigned) | Note de 1 à 5 étoiles |
| commentaire | text, nullable | Commentaire du client |

La contrainte d'unicité sur `reservation_id` garantit qu'un client ne peut déposer qu'un seul avis par réservation. Toutes les clés étrangères sont supprimées en cascade.

### Réinitialiser la base de données

La commande suivante supprime toutes les données et recrée la base à partir de zéro :

```bash
php artisan migrate:fresh --seed
```

---

## Tests et validation

La validation de la plateforme repose sur une stratégie de test à plusieurs niveaux. Des tests manuels ont permis de vérifier, page par page, la cohérence entre les maquettes, le cahier des charges et le comportement réel de l'application, en particulier sur les parcours critiques que sont l'inscription, la réservation et le dépôt d'avis.

Des scénarios de test ciblés ont été définis pour les cas limites identifiés dès la conception du diagramme de séquence : tentative de réservation sur un créneau déjà passé, tentative de réservation sur un créneau venant d'être pris par une autre cliente, ou encore tentative de dépôt d'un second avis sur une même réservation. Ces scénarios permettent de vérifier que les contraintes définies au niveau de la base de données (unicité, clés étrangères) sont correctement doublées par des contrôles applicatifs, offrant ainsi une double sécurité contre les incohérences de données.

À terme, ces vérifications manuelles ont vocation à être complétées par des tests automatisés écrits avec PHPUnit, l'outil de test intégré à Laravel, afin de garantir la non-régression du comportement de l'application au fil des évolutions futures.

---

## Dépannage

Base de données introuvable (SQLSTATE - Unknown database 'ninich_beauty')
: La base n'existe pas. Créez-la dans phpMyAdmin (voir l'étape 3 de l'installation).

Connexion refusée (SQLSTATE - Connection refused)
: Le serveur MySQL n'est pas démarré. Lancez MySQL depuis XAMPP, WAMP ou Laragon.

Les styles Tailwind ne s'affichent pas
: Exécutez `npm run dev` (développement) ou `npm run build` (production), puis rechargez la page.

Page blanche ou erreur 500
: Consultez le fichier de log `storage/logs/laravel.log`. Vérifiez que la clé `APP_KEY` est bien définie (`php artisan key:generate`).

Les modifications de routes ou de configuration ne sont pas prises en compte
: Videz les caches avec la commande `php artisan optimize:clear`.

---

Ninich Beauty - Plateforme de réservation de prestations de beauté.
