# Cinema Api

## Requeriments

- Docker
- Docker compose

## Technological Stack 
| Name |	Version |
| --------|------------- |
| Language | PHP	7.2 |
| Framework | Laravel 7 |
| Database | MYSQL 5.7 |

## Installation
- Run docker compose up
```
docker-compose up -d
```

- Run migrations for Laravel
```
docker-compose exec app php artisan migrate
```

- Run seed for laravel
```
docker-compose exec app php artisan db:seed
```

- Generate secret key for jwt
```
docker-compose exec app php artisan jwt:secret
```
