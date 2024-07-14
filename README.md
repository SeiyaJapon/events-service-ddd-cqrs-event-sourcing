# Auth Service (DDD + CQRS)

## Description

This project is developed with a focus on Domain-Driven Design (DDD) and Command Query Responsibility Segregation (CQRS) principles, ensuring a robust and scalable architecture. It utilizes a combination of technologies including PHP, Composer, SQL. The backend is powered by Laravel, with a custom-built CQRS system on top of the League/Tactician package for handling business operations efficiently.

## Getting Started

### Dependencies

- Docker
- PHP 8.2 or higher
- Composer for managing PHP dependencies
- NPM for managing JavaScript packages
- Python 3.8 or higher
- Laravel Framework
- MySQL or a compatible SQL database for data storage
- League/Tactician for the CQRS command bus

### Installation and Setup

1. **Clone the repository** to your local machine.
2. **Navigate to the project directory** and use the provided `Makefile` commands to simplify the setup process.

### Makefile Commands

The `Makefile` includes several commands to help with project setup and development:

- `make build`: First run / installation will call this target, setting up the Docker environment and starting the services.
- `make up`: Starts the Docker environment.
- `make stop`: Stops the Docker containers.
- `make restart`: Restarts the Docker containers.
- `make prepare`: Prepares the backend environment, including dependency installation.
- `make install-components`: Runs Laravel migrations, installs Passport for OAuth, and seeds the database.
- `make fresh`: Resets the database and seeds it with initial data.
- `make clear-all`: Clears and caches configurations and routes.
- `make enter`: Accesses the backend container for direct command execution.
