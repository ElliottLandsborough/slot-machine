# Slot Machine

A simple slot machine game implemented in Python. Spin the reels, test your luck, and try to win big!

## Features

- Classic slot machine gameplay
- Randomized reel symbols
- Win/loss detection
- Configurable bet amounts
- Simple command-line interface

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/yourusername/slot-machine.git
    cd slot-machine
    ```
3. Install compoer deps
    ```bash
    make install
    ```

3. Run the code (with docker):
    ```bash
    make build
    make docker-run
    ```

4. Run the code (without docker):
    ```
    make run
    ```

## Usage

# Slot Machine Project Makefile

This repository includes a Makefile to streamline development, testing, and deployment for a PHP-based slot machine application. The Makefile supports both local and Docker-based workflows.

## Available Commands

| Command         | Description                                         |
|-----------------|-----------------------------------------------------|
| `help`          | Show a list of available commands and their descriptions. |
| `install`       | Install PHP dependencies locally using Composer.    |
| `build`         | Build the Docker image for the application.         |
| `run`           | Run the application locally using PHP.              |
| `test`          | Run tests locally via Composer.                     |
| `docker-build`  | Build Docker containers for the project.            |
| `docker-run`    | Run the application inside a Docker container.      |
| `docker-test`   | Run tests inside a Docker container.                |
| `docker-dev`    | Start the development container in detached mode.   |
| `docker-shell`  | Access a shell inside the development container.    |
| `docker-stop`   | Stop all running Docker containers.                 |
| `clean`         | Remove generated files, Docker images, volumes, and orphans. |

## Usage

To run a command, use:

Follow the on-screen instructions to play.

## Contributing

Contributions are welcome! Please open issues or submit pull requests for improvements.

## License

This project is licensed under the MIT License.