# Procédure d'installation 
## Prérequis
- serveur web local
- PHP 7.3
Ouvrir un dossier en local
- faire un git clone du repository 
- Faire un composer update/install
## Création de la base de données 
- ```bin/console doctrine:database:create```
## Migrations entités 
1. Création du fichier de migration (code SQL) ```bin/console make:migration```
2. Exécuter la migration ```bin/console doctrine:migrations:migrate```
## Fixtures
1. Les fixtures en mode développement, "normalement".
```bin/console doctrine:fixtures:load```

