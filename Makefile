cs:
	php ./vendor/bin/php-cs-fixer fix
	php ./vendor/bin/phpstan analyse src --memory-limit 0
