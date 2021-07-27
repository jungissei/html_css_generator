up:
	docker-compose up
upd:
	docker-compose up -d
down:
	docker-compose down --remove-orphans
restart:
	@make down
	@make up
app:
	docker-compose exec php bin/bash
