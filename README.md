# CDAPizza

Application interne de gestion de commandes pour pizzeria.  
Développée en PHP natif avec architecture MVC, sans framework externe.

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

## Comptes de test

| Login | Mot de passe | Rôle | must_change_password |
|---|---|---|---|
| guichet1 | guichet1 | Guichet | non |
| cuisine1 | cuisine1 | Cuisine | non |
| gerant1 | gerant1 | Gérant | non |
| newuser1 | newuser1 | Guichet | **oui** (forcé à la connexion) |

> Les mots de passe sont hashés en bcrypt dans la BDD — jamais stockés en clair.

## Rôles et droits

| Action | Guichet | Cuisine | Gérant |
|---|---|---|---|
| Commandes — liste | ✅ (sans Livrées) | ✅ (En préparation uniquement) | ❌ |
| Commandes — show | ✅ | ✅ | ❌ |
| Commandes — create / update / delete | ✅ | ❌ | ❌ |
| Changement état PAYER → PREPARATION | ✅ | ❌ | ❌ |
| Changement état PREPARATION → PRETE | ❌ | ✅ | ❌ |
| Changement état PRETE → LIVRER | ✅ | ❌ | ❌ |
| Clients — CRUD | ✅ | ❌ | ❌ |
| Pizzas — liste / show | ❌ | ✅ | ✅ |
| Pizzas — create / update / delete | ❌ | ❌ | ✅ |
| Modification stock pizza | ❌ | ✅ | ✅ |

## Fonctionnalités

- Authentification avec gestion des rôles (Guichet, Cuisine, Gérant)
- Changement de mot de passe forcé à la première connexion
- CRUD Commandes avec table de pizzas dynamique (JS)
- Calcul automatique du montant via triggers SQL
- Système de réductions (fidélité et quantité) avec badges
- CRUD Clients et Pizzas
- Soft delete sur clients et pizzas (`deleted_at`)
- Protection CSRF sur tous les formulaires POST
- Navbar adaptée selon le rôle connecté

## Structure du projet

```
src/
├── Controllers/        # Contrôleurs (Auth, Commande, Client, Pizza, Password)
├── Core/               # Framework maison (Model, Router, View, Session, Auth, Validator)
│   ├── Middlewares/    # Auth, CSRF, Role, Password
│   └── Traits/         # HasRelationships, IsFillable
├── Enum/               # EtatCommande, Role, TypeReduction, ValidationError
├── Helpers/            # Csrf, functions
├── Models/             # Client, Commande, Commande_Pizza, Pizza, Utilisateur
└── Services/           # ReductionService
views/
├── auth/               # login, password
├── clients/            # form, index, show
├── commandes/          # form, index, show
├── layouts/            # main.php
├── pizzas/             # form, index, show
└── HomePage/           # index
public/
├── js/                 # scriptFormCommande.js
└── index.php           # point d'entrée
init-db/
├── bdd.sql             # Création des bases (CDAPizza + CDAPersonnel) et triggers
└── seed.sql            # Données de test
```

## Bases de données

Le projet utilise deux bases de données séparées :

- **CDAPizza** — données métier (clients, pizzas, commandes, commande_pizza)
- **CDAPersonnel** — gestion des utilisateurs et authentification

Les triggers SQL sur `commande_pizza` calculent automatiquement `montant_initial` à chaque INSERT, UPDATE ou DELETE.