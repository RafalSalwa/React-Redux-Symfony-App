up:
	docker compose up -d
	docker compose logs -f

down:
	docker compose down

local:
	symfony server:stop
	docker compose up -d
	symfony server:start -d --no-tls
	symfony server:log
