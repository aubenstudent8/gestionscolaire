# Proposition de projet - Plateforme PIGSE

## Objectif

Développer une plateforme de gestion scolaire sécurisée et multilingue, avec un accès role-based pour les administrateurs et des menus dynamiques basés sur les permissions.

## Contexte

Le projet est bâti sur Laravel 12 avec authentification Breeze et le package Spatie Permissions. L'application devra proposer une interface claire pour les modules principaux de gestion scolaire, tout en masquant les sections non autorisées selon le rôle utilisateur.

## Fonctionnalités principales

- Authentification sécurisée avec gestion de sessions
- Gestion des rôles et permissions via Spatie Permissions
- Accès à certaines pages réservé au rôle `Super Administrator`
- Menu et sidebar dynamiques basés sur le rôle de l'utilisateur
- Sélecteur de langue (français, anglais, espagnol)
- Persistance de la préférence de langue en base et en session
- Page d'erreur 403 personnalisée et localisée
- Navigation responsive avec menu mobile et sidebar fixe sur desktop

## Rôles cibles

La configuration prévoit la gestion des rôles suivants :

- Super Administrator
- Administrator
- Enseignant
- Étudiant
- Bibliothécaire
- Comptable
- Ressources Humaines
- Infirmerie
- Chargé de Qualité
- Chargé de Communication
- Chercheur

## Modules et sections du menu

- Accueil
- Tableau de bord
- Administration
- Scolarité
- Académie
- Bibliothèque numérique
- E-learning
- Communication
- Finance
- Ressources Humaines
- Infirmerie
- Recherche
- Qualité
- Rapports
- Paramètres
- Sécurité

## Architecture technique

- Backend : Laravel 12
- Authentification : Breeze
- Permissions : Spatie Permissions
- Templates : Blade
- Frontend : Tailwind / classes CSS utilitaires
- Base de données : MySQL/MariaDB via WAMP

## Livrables

- `config/menu.php` : définition centralisée des menus et règles de visibilité
- Pages Blade pour la navigation, la sidebar et la gestion responsive
- Middleware de localisation pour persister la langue utilisateur
- Page d'erreur `403` personnalisée
- Seeders pour créer les rôles et des comptes de test

## Tâches réalisées

- Mise en place de l’authentification et des rôles
- Implémentation du menu dynamique basé sur `config/menu.php`
- Ajout du sélecteur de langue desktop et mobile
- Ajout du seeder pour créer les rôles automatiquement
- Ajout de la page 403 personnalisée et localisée

## Prochaines étapes recommandées

1. Finaliser les modules métiers (Admissions, Académique, Étudiants, Finance, Bibliothèque)
2. Ajouter les écrans de gestion et les formulaires pour chaque section
3. Implémenter des tests d’intégration pour les rôles et la navigation
4. Ajouter des traductions complètes pour toutes les pages et les libellés
5. Déployer une version initiale pour validation fonctionnelle

## Notes

Cette proposition correspond à l’architecture et aux fonctionnalités déjà présentes dans le projet Laravel actuel. Elle sert de base pour structurer la suite du développement et prioriser les modules métier.
