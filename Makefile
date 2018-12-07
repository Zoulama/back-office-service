reset: stop down remove ##@Docker system prune && down
	docker system prune -a

##remove: ##@Docker remove image and container
##    docker rm $(docker ps -a -q)
##
##stop: ##@Docker remove image and container
##    docker stop $(docker ps -a -q)

build: ##@Docker install services dependencies
	docker-compose -f infrastructure/docker/docker-compose-build.yml up --build

up: ##@Docker Build and deploy services
	docker-compose -f infrastructure/docker/docker-compose-local.yml --project-name userdata up --build -d

migrate: ##@Docker Build and deploy services
	docker-compose -f infrastructure/docker/docker-compose-local-migrate.yml up --build

down: ##@Docker Take down service
	docker-compose -f infrastructure/docker/docker-compose-local.yml down

connect-php: ##@Docker Connect on the container php-fpm
	docker exec -it docker_php-fpm_1 /bin/bash

connect-mysql: ##@Docker Connect on the container database
	docker exec -it docker_mysql_1 /bin/bash

test: ##@Docker Launch behat test on the container php-fpm
	docker exec -it docker_php-fpm_1 vendor/behat/behat/bin/behat

full-test: reset clean build up migrate test ##@Docker rebuild from scratch and run test