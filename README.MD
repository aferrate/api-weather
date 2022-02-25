# API weather city

### Steps for installing and running

Run:
```
cd laradock
docker-compose up -d workspace
```

Enter container:
```
docker-compose exec workspace bash
```

Stop running container:
```
docker stop
```

Before run program (execute inside container):
```
composer install
```

Run program (execute inside container):
```
php ./main.php weather new-york
```

Run tests (execute inside container):
```
./vendor/bin/phpunit ./tests/TestWeather.php
```