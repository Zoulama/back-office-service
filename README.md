# authentication-service

#### Run composer and run the app containers
```
docker-compose -f infrastructure/docker/docker-compose-build.yml up --build
docker-compose -f infrastructure/docker/docker-compose-local.yml up -d  --build
```

Head to http://localhost:8084

### Set database
```
php artisan migrate
```

### Create the encryption keys for API authentication
```
php artisan passport:keys
```

### Creating A Password Grant Client
```
php artisan passport:client --personal
```

### Creating A client
```
php artisan passport:client
```
### How to test in preprod ?
Head to https://devel01.test.tsipayment.net/testV5/ ,  chose the amount, click the (Payer Avec Ticket Premium) button, then the (Open TSI Panel Payment) link


