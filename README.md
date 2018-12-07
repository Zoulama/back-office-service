# Back-office-service

#### Run composer and run the app containers
```
docker-compose -f infrastructure/docker/docker-compose-build.yml up --build
docker-compose -f infrastructure/docker/docker-compose-local.yml up -d --build
```



### Set database
```
php artisan migrate
```

Head to http://localhost:8082

