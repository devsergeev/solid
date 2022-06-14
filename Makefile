docker-compose = docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env

docker-compose-up:
	$(docker-compose) up -d
docker-compose-start:
	$(docker-compose) start
docker-compose-stop:
	$(docker-compose) stop
docker-compose-bash:
	$(docker-compose) run php-fpm bash
