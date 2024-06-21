up:
	docker compose up -d
	docker compose logs -f

down:
	docker compose down

dev_server:
	composer install
	symfony server:stop
	docker compose up -d
	symfony server:start -d --no-tls
	symfony server:log

lint:
	vendor/bin/parallel-lint src --no-progress

static_analysis: lint test_unit
	-vendor/bin/phpcs --standard=config/analysis/phpcs.xml -s src tests
	-vendor/bin/psalm --config=config/analysis/psalm.xml --no-cache --no-file-cache --no-reflection-cache || true
	-vendor/bin/phpstan analyse --configuration=config/analysis/phpstan.neon || true
	-vendor/bin/php-cs-fixer --config=config/analysis/php-cs-fixer.php check --diff --verbose || true
	-vendor/bin/phpmd src/ html config/analysis/phpmd.xml > var/reports/phpmd.html || true
	-vendor/bin/phpmetrics --config=config/analysis/phpmetrics.yml src/
	-vendor/bin/rector process --dry-run

test_unit: ### run test
	./vendor/bin/phpunit --configuration ./config/analysis/phpunit.xml --testsuite=unit
