docker-compose = docker-compose -f ./docker/docker-compose.yml --env-file ./docker/.env

docker-compose-up:
	$(docker-compose) up -d
