# Bgrfacile Backend - Laravel Multi-Tenant API

## Description

Ce projet constitue le backend de l’application Bgrfacile, un système multi-tenant développé avec le framework Laravel. Le backend fournit une API RESTful pour la gestion des cours et des étudiants, en utilisant une architecture multi-tenant pour isoler les données des différents clients. L’application est documentée avec OpenAPI grâce à zircote/swagger-php, et le déploiement continu est géré par GitHub Actions.

## Fonctionnalités

- Gestion multi-tenant des données (cours, étudiants, etc.)
- API RESTful avec documentation OpenAPI
- Séparation des données entre différents tenants
- Support CRUD complet pour les entités “Cours” et “Étudiants”
- Authentification et autorisation basées sur JWT
- Validation des requêtes via des tests unitaires et d’intégration avec Pest

## Prérequis

- PHP >= 8.3.10
- Composer
- MySQL ou PostgreSQL
- Redis (pour la gestion des files d’attente et le cache)
- Node.js (pour le frontend s’il est couplé)
- Laravel 11.x

## Installation

1. Cloner le dépôt

```shell
git clone https://github.com/benaja-bendo/bgr-dashboard-01.git
cd bgr-dashboard-01
```

2. Installer les dépendances

```shell
composer install
```

3. Créer un fichier `.env` à partir du modèle `.env.example`

```shell
cp .env.example .env
```

4. Générer une clé d’application

```shell
php artisan key:generate
```

5. Configurer les variables d’environnement dans le fichier `.env`

6. Créer la base de données et exécuter les migrations

```shell
php artisan migrate --seed
```

7. Démarrer le serveur de développement

```shell
php artisan serve
```

## Utilisation
L’API expose plusieurs endpoints pour gérer les cours et les étudiants. Pour plus de détails, consultez la documentation OpenAPI disponible à l’URL /documentation.json.

### Exemple d'Endpoints

- Liste des cours :
  - `GET` /api/v1/courses
- Créer un cours :
  - `POST` /api/v1/courses
- Récupérer un cours spécifique :
  - `GET` /api/v1/courses/{id}
- Mettre à jour un cours :
  - `PUT` /api/v1/courses/{id}
- Supprimer un cours :
  - `DELETE` /api/v1/courses/{id}

## Tests

Pour exécuter les tests unitaires et d’intégration, utilisez la commande suivante :

```shell
php artisan test
```
Les tests couvrent principalement le backend, avec une couverture étendue des fonctionnalités critiques.

## Licence

Ce projet est sous licence MIT. Pour plus d’informations, consultez le fichier `LICENSE`.



