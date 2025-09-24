# Default target

# I did not write this first one, borrowed it from someone else.
# Searches the Makefile(s) for lines that define
# targets with a help comment (marked by ##), sorts them,
# and then formats and prints them in color.
# It is used to generate a nicely formatted list of available
# Makefile commands and their descriptions when you run make help.
help: ## Show this help message
	@echo "Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

install: ## Install PHP dependencies locally
	composer install

build: ## Build the Docker image
	docker compose build

run: ## Run the application locally
	php game.php

test: ## Run tests locally
	composer test

docker-build: ## Build Docker containers
	docker compose build

## NOTE: this is broken.
docker-run: ## Run the application in Docker
	docker run -it slot-machine-app php game.php

docker-test: ## Run tests in Docker
	docker compose up test

docker-dev: ## Start development container
	docker compose up -d dev

docker-shell: ## Get shell access to development container
	docker compose exec dev bash

docker-stop: ## Stop all Docker containers
	docker compose down

## Not tested properly, rememver to run it twice to fully clean up.
clean: ## Clean up generated files
	rm -rf vendor/
	docker compose down --rmi all --volumes --remove-orphans
	docker system prune -f