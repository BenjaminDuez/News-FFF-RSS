# News-FFF-RSS

Le site de la FFF ne propose pas de flux RSS.
Voici donc un petit scrapper basé sur fabpot/goutte qui en génère un :)

## Installation

```
composer install
php artisan key:generate
```

## Configuration

Mettez à jour votre fichier .env avec les actualités que vous voulez réccépérer en RSS.

Par défaut le scrapper va chercher les news de l'équipe de France uniquement.

`FFF_NEWS_URL=https://www.fff.fr/equipes-de-france/1/france-a/actualites`