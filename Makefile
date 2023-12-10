container_id := $$(docker-compose ps | grep praybot-fpm | cut -d" " -f1)

start:
	cd ./docker/dev/ && docker-compose start
migrate:
	cd ./docker/dev/ && docker exec $(container_id) php artisan migrate
migrate_status:
	cd ./docker/dev/ && docker exec $(container_id) php artisan migrate:status
rollback:
	cd ./docker/dev/ && docker exec $(container_id) php artisan migrate:rollback
phpunit:
	cd ./docker/dev/ && docker exec $(container_id) ./vendor/bin/phpunit
bash:
	cd ./docker/dev/ && docker exec -it $(container_id) bash
stop:
	cd ./docker/dev/ && docker-compose stop
