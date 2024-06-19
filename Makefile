.PHONY: prod
prod:
	docker compose up -d

.PHONY: dev_backend
dev_backend:
	cd backend/ && make local

.PHONY: dev_frontend
dev_frontend:
	cd frontend && npm start