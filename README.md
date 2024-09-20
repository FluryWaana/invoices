### README - Installation du projet Laravel

---

## Table des matières

1. [Prérequis](#prérequis)
2. [Installation avec Docker Compose](#installation-avec-docker-compose)
3. [Installation sans Docker Compose](#installation-sans-docker-compose)
4. [Utilisation de l'API](#utilisation-de-lapi)
5. [Tests](#tests)

---

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **Docker** et **Docker Compose** (si vous utilisez l'installation Docker).
- **PHP 8.3** ou supérieur (si vous installez manuellement sans Docker).
- **Composer** (gestionnaire de dépendances PHP).
- **MySQL 8.0** ou supérieur (si vous installez manuellement).

---

## Installation avec Docker Compose

### Étape 1 : Cloner le dépôt

```bash
git clone [https://github.com/votre-utilisateur/mon-projet-facture.git](https://github.com/FluryWaana/invoices.git)
cd invoices
```

### Étape 2 : Lancer Docker Compose

Lancez l'application avec Docker Compose en exécutant la commande suivante :

```bash
docker-compose up --build
```

Docker Compose va :
- Télécharger les dépendances si elles ne sont pas présentes.
- Lancer un service PHP avec Laravel.
- Lancer un conteneur MySQL pour la base de données.

### Étape 3 : Migrer la base de données

Ensuite, exécutez les migrations pour créer les tables de la base de données :

```bash
docker-compose exec web php artisan migrate --seed
```

### Accéder à l'application

L'application est maintenant disponible à l'adresse [http://localhost:8000](http://localhost:8000).

---

## Installation sans Docker Compose

Si vous préférez installer le projet manuellement sans Docker Compose, suivez les étapes suivantes.

### Étape 1 : Cloner le dépôt

```bash
git clone [https://github.com/votre-utilisateur/mon-projet-facture.git](https://github.com/FluryWaana/invoices.git)
cd invoices
```

### Étape 2 : Installer PHP et les dépendances

Assurez-vous que **PHP 8.3** ou supérieur est installé sur votre machine.

Installez les dépendances PHP avec Composer :

```bash
composer install
```

### Étape 3 : Configuration de l'environnement

Copiez le fichier `.env.example` et configurez les informations de la base de données MySQL :

```bash
cp .env.example .env
```

Modifiez les variables dans le fichier `.env` pour pointer vers votre base de données MySQL locale.

Générez la clé de l'application Laravel :

```bash
php artisan key:generate
```

### Étape 4 : Configurer la base de données

Créez une base de données MySQL (par exemple `laravel`), puis exécutez les migrations pour créer les tables :

```bash
php artisan migrate --seed
```

### Étape 5 : Lancer le serveur Laravel

Lancez le serveur Laravel localement :

```bash
php artisan serve
```

L'application sera accessible à l'adresse [http://localhost:8000](http://localhost:8000).

---

## Utilisation de l'API

L'API vous permet de gérer des **factures** et leurs **lignes de factures**. Voici quelques exemples de requêtes que vous pouvez effectuer :

### 1. Lister les factures (paginées et triées)
/!\ Le paramètre 'password' est obligatoire pour accéder à cette route.
```bash
GET /api/v1/invoices?password=1234
```

Vous pouvez ajouter des paramètres pour le tri :
- **order-by** : `total`, `sent_at`, `customer`
- **order** : `asc` ou `desc`

Exemple :

```bash
GET /api/v1/invoices?password=1234&order-by=total&order=desc
```

### 2. Créer une nouvelle facture

```bash
POST /api/v1/invoices
```

Body (JSON) :

```json
{
  "customer": "John Doe",
  "number": "FA-2023-001",
  "status": "sent",
  "sent_at": "2023-01-01",
  "lines": [
    { "product": "Produit 1", "amount": 100.50 },
    { "product": "Produit 2", "amount": 50.75 }
  ]
}
```

### 3. Filtrer et trier les factures

```bash
GET /api/v1/invoices?password=1234&order-by=total&order=desc
```

---

## Tests

### Exécution des tests avec Docker Compose

Pour exécuter les tests unitaires et fonctionnels dans le conteneur Docker :

```bash
docker-compose exec web php artisan test
```

### Exécution des tests sans Docker

Si vous avez installé le projet sans Docker, lancez les tests directement depuis votre machine :

```bash
php artisan test
```
