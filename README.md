# CDAPizza

Application interne de gestion de commandes pour pizzeria.  
Gestion des rôles **Guichet** et **Cuisine** avec deux interfaces dédiées.

## Prérequis

- [Docker](https://www.docker.com/) — choisir la version **AMD64** pour Windows

> ⚠️ Si Docker ne démarre pas, vérifier que la **virtualisation est activée** dans le BIOS de votre machine.

## Installation

1. Cloner le repo
```bash
git clone https://github.com/Jaeemiel/CDAPizzaPHP.git
cd CDAPizzaPHP
```

2. Copier `.env.example` en `.env` et remplir les valeurs
```bash
cp .env.example .env
```

3. Lancer l'application
```bash
docker compose up --build -d
```

## Commandes Docker

| Commande | Description |
|---|---|
| `docker compose up --build -d` | Démarre les conteneurs |
| `docker compose down` | Arrête les conteneurs |
| `docker compose down -v` | Arrête et supprime les volumes (reset BDD) |
| `docker compose logs db` | Affiche les logs de la BDD |

## Accès

| Service | URL |
|---|---|
| Application | http://localhost:8081 |
| phpMyAdmin | http://localhost:8082 |

## Structure du projet
```
src/
├── Controllers/    # Contrôleurs de l'application
├── Core/           # Classes du framework (Model, Router, Database...)
├── Enum/           # Énumérations PHP (Role...)
├── Models/         # Modèles (Pizza, Commande, Utilisateur...)
└── Views/          # Templates HTML
init-db/
├── bdd.sql      # Création des bases et tables
└── seed.sql     # Données de test
```

## Comptes de test

| Login | Mot de passe | Rôle |
|---|---|---|
| guichet1 | password | Guichet |
| cuisine1 | password | Cuisine |