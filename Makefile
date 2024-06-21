.PHONY: prod
prod:
	docker compose up -d

.PHONY: dev_backend
dev_backend:
	cd backend/ && make dev_server

.PHONY: dev_frontend
dev_frontend:
	cd frontend/ && make dev_server