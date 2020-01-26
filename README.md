# Library

Basic Library application

## Quick Start
Install dependencies
```
composer install
```
Edit env file and add DB params

Create Book schema
```
php bin/console doctrine:migrations:diff
```

Run migrations
```
php bin/console doctrine:migrations:migrate
```
