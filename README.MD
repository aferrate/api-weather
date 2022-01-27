# Every modification needs a image build and new start (sorry for the incovenience).

### First you should put your API key in Dockerfile.

### Steps for installing and running
Build image:
```
docker build -t weather-api .
```

Run image:
```
docker run -dit weather-api
```

Check id container:
```
docker ps
```

Enter container:
```
docker exec -it <contaier-id> sh
```

Stop running container:
```
docker stop <contaier-id>
```

Run program (execute inside container):
```
php ./main.php weather new-york
```

Run tests (execute inside container):
```
./vendor/bin/phpunit ./tests/TestWeather.php
```