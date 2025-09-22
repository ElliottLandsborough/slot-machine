# Hello World PHP Application

A basic command-line PHP application with Docker support, unit testing, and development automation tools.

## Features

- **PHP 8.4** command-line application
- **Docker** containerization with development support
- **Auto-reload** during development (via volume mounting)
- **Unit testing** with PHPUnit
- **Makefile** with common development commands
- **Composer** dependency management

## Prerequisites

- PHP 8.3+ (for local development)
- [Composer](https://getcomposer.org/) (for local development)
- [Docker](https://www.docker.com/) (for containerized execution)

## Quick Start

### Local Development

1. **Install dependencies**:
   ```bash
   make install
   ```

2. **Run the application**:
   ```bash
   make run
   # or directly:
   php hello.php
   ```

3. **Run tests**:
   ```bash
   make test
   # or directly:
   composer test
   ```

### Docker Development

1. **Build Docker containers**:
   ```bash
   make docker-build
   ```

2. **Run the application in Docker**:
   ```bash
   make docker-run
   ```

3. **Run tests in Docker**:
   ```bash
   make docker-test
   ```

4. **Start development environment with auto-reload**:
   ```bash
   make docker-dev
   ```
   
   This starts a container in the background with your code mounted as a volume. Any changes to your files will be immediately available in the container.

5. **Access the development container**:
   ```bash
   make docker-shell
   ```
   
   This gives you a bash shell inside the development container where you can run commands like `php hello.php`, `composer test`, etc.

## Available Commands

Run `make help` to see all available commands:

```bash
make help
```

### Development Commands

- `make install` - Install PHP dependencies locally
- `make run` - Run the application locally
- `make test` - Run tests locally
- `make dev-setup` - Setup complete development environment
- `make dev-watch` - Watch for file changes and run tests

### Docker Commands

- `make docker-build` - Build Docker containers
- `make docker-run` - Run the application in Docker
- `make docker-test` - Run tests in Docker
- `make docker-dev` - Start development container (with auto-reload)
- `make docker-shell` - Get shell access to development container
- `make docker-stop` - Stop all Docker containers

### Utility Commands

- `make clean` - Clean up generated files and Docker containers
- `make help` - Show all available commands

## Project Structure

```
.
├── src/
│   └── HelloWorld.php      # Main application class
├── tests/
│   └── HelloWorldTest.php  # Unit tests
├── hello.php               # CLI entry point
├── composer.json           # PHP dependencies
├── phpunit.xml             # PHPUnit configuration
├── Dockerfile              # Docker container definition
├── docker-compose.yml      # Docker services configuration
├── Makefile                # Development automation
└── README.md               # This file
```

## Development Workflow

### With Auto-reload (Recommended)

1. **Start the development environment**:
   ```bash
   make docker-dev
   ```

2. **Open a shell in the container**:
   ```bash
   make docker-shell
   ```

3. **Make changes** to your PHP files in your local editor

4. **Test changes immediately** in the container:
   ```bash
   php hello.php    # Run the app
   composer test    # Run tests
   ```

   Your changes are automatically available because the code is mounted as a volume.

### Traditional Development

1. **Make changes** to your PHP files
2. **Test locally**:
   ```bash
   make run
   make test
   ```
3. **Test in Docker**:
   ```bash
   make docker-build  # Rebuild container
   make docker-run    # Test the app
   make docker-test   # Test in container
   ```

## Testing

The project includes unit tests using PHPUnit:

- Tests are located in the `tests/` directory
- Run locally: `make test` or `composer test`
- Run in Docker: `make docker-test`

### Test Structure

- `HelloWorldTest.php` - Tests the main HelloWorld class
  - Tests the `sayHello()` method returns correct string
  - Tests the `run()` method outputs correctly

## Docker Services

The `docker-compose.yml` defines three services:

1. **app** - Runs the application once and exits
2. **dev** - Development container with mounted volumes (stays running)
3. **test** - Runs the test suite

All services use the same base image but with different commands and configurations.

## Customization

### Adding New Features

1. **Add new classes** to the `src/` directory
2. **Follow PSR-4 autoloading** - classes in `App\` namespace
3. **Add corresponding tests** in the `tests/` directory
4. **Update composer.json** if you need new dependencies

### Environment Variables

You can customize the Docker environment by creating a `docker-compose.override.yml` file:

```yaml
services:
  dev:
    environment:
      - DEBUG=true
      - LOG_LEVEL=debug
```

## Troubleshooting

### Common Issues

1. **Permission errors with Docker**:
   ```bash
   make docker-stop
   make clean
   make docker-build
   ```

2. **Composer dependency issues**:
   ```bash
   rm -rf vendor/ composer.lock
   make install
   ```

3. **Docker build fails**:
   ```bash
   docker system prune -f
   make docker-build
   ```

### Getting Help

- Run `make help` for available commands
- Check the Docker logs: `docker compose logs`
- Ensure Docker daemon is running

## License

MIT License - see the project files for details.