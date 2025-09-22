.PHONY: help install build run test docker-build docker-run docker-test docker-dev docker-shell clean

# Default target
help: ## Show this help message
	@echo "Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

install: ## Install PHP dependencies locally
	composer install

build: ## Build the Docker image
	docker compose build

run: ## Run the application locally
	php hello.php

test: ## Run tests locally
	composer test

docker-build: ## Build Docker containers
	docker compose build

docker-run: ## Run the application in Docker
	docker compose up app

docker-test: ## Run tests in Docker
	docker compose up test

docker-dev: ## Start development container
	docker compose up -d dev

docker-shell: ## Get shell access to development container
	docker compose exec dev bash

docker-stop: ## Stop all Docker containers
	docker compose down

clean: ## Clean up generated files
	rm -rf vendor/
	docker compose down --rmi all --volumes --remove-orphans

# Development workflow commands
dev-setup: install build ## Setup development environment
	@echo "Development environment ready!"
	@echo "Run 'make docker-dev' to start development container"
	@echo "Run 'make docker-shell' to access the container"

dev-watch: ## Watch for file changes and run tests
	@echo "Watching for file changes... (Press Ctrl+C to stop)"
	@while true; do \
		make test; \
		sleep 2; \
	done