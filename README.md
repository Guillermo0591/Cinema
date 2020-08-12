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
### Docker
- Install dependencies for composer
```
docker run --rm -v $(pwd):/app composer install
```

- Permission for project folder
```
sudo chown -R $USER:$USER ~/cinema
```

- Run docker compose up
```
docker-compose up -d
```

- Create .env from .env-docker
```
docker-compose exec app cp .env-docker .env
```

- Generate key 
```
docker-compose exec app php artisan key:generate
```

- (Optional) config cache
```
docker-compose exec app php artisan config:cache
```

### Mysql config
```
docker-compose exec db bash
```
- Login inside container
```
mysql -proot -u root
```
- Create user admin for .env config
```
GRANT ALL ON laravel.* TO 'admin'@'%' IDENTIFIED BY 'admin';
```
- Flush privileges for user admin
```
FLUSH PRIVILEGES;
```
- Exit mysql console
```
EXIT
```
- Exit container
```
exit
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
if key exist select option no
