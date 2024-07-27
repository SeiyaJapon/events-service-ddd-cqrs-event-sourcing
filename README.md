# Events Service

## Description

This project involves developing a microservice that integrates events from an external provider into a marketplace. The objective is to create an API that adheres to the provided Open API specification, is resource and time-efficient, and maintains high performance even under heavy load.

## Project Structure

The project is structured following the principles of Domain-Driven Design (DDD), Command Query Responsibility Segregation (CQRS), and event sourcing. This ensures a scalable, maintainable, and easily evolvable solution.

### Domain-Driven Design (DDD)

DDD helps us maintain a clear and organized structure in our code, separating responsibilities and ensuring that each part of the system focuses on its own business logic.

- **Domain**: Contains entities, aggregates, value objects, and domain services.
- **Application**: Contains use cases and commands/queries that interact with the domain.
- **Infrastructure**: Contains the implementation of repositories, external services, and any other technical details.

### Command Query Responsibility Segregation (CQRS)

CQRS allows us to separate read and write operations, improving the scalability and performance of the system.

- **Commands**: Used for write operations and modifying the state.
- **Queries**: Used for read operations and querying the state.

### Events and Queues
The use of events and queues allows for asynchronous processing and better handling of high volumes of operations. This improves the system's scalability and resilience.

- Events: Captured and processed to trigger actions within the system.
- Queues: Used to manage and process events asynchronously, reducing load and improving response times.

## Integration with the External Provider

The external provider offers an endpoint that returns a list of events in XML format. Our task was to develop a microservice that fetches these events, normalizes the data, and exposes an endpoint following the provided Open API specification.

### Key Features

- **Fetching and Caching Events**: We fetch events from the external provider and cache them to improve performance and ensure availability even if the external service is down.
- **Filtering by Date Range**: The exposed endpoint allows filtering events by a specified date range.
- **Efficient Data Handling**: The service is designed to handle large volumes of events efficiently.

## Scalability and Performance

To ensure scalability and performance, the following considerations have been made:

- **Domain-Driven Design (DDD) and CQRS**: These patterns help in organizing the codebase, making it easier to scale and maintain.
- **Event Sourcing**: Provides a reliable way to store and reconstruct events, ensuring data integrity and facilitating auditing.
- **Caching**: Events are cached to reduce load on the external provider and improve response times.
- **Testing**: Comprehensive unit tests and integration tests ensure the reliability of the system.

## Running the Application

A `Makefile` is included to simplify running the application.

### Prerequisites

- PHP 7.4 or higher
- Composer
- Laravel

# Makefile Commands for Installation and Working with the Container and Project

## Installation
1. **Clone the repository:**
   ```sh
   git clone https://github.com/SeiyaJapon/events-service-ddd-cqrs-event-sourcing.git
   cd events-service-ddd-cqrs-event-sourcing
    ```
2. **Install dependencies:**

## Working with the Container and Project

**Build the Docker container:** 
   ```sh
   make build
   ```
**Run the Docker container:** 
   ```sh
   make run
   ```
**Stop the Docker container:** 
   ```sh
   make stop
   ```
**Restart the Docker container:** 
   ```sh
   make restart
   ```
**Rebuild all Docker containers:** 
   ```sh
   make rebuild-all
   ```
**Remove the Docker container:** 
   ```sh
   make down
   ```
**Destroy the Docker container:** 
   ```sh
   make destroy
   ```
**Install Laravel components:** 
   ```sh
   make install-components
   ```
**Prepare Laravel:** 
   ```sh
   make laravel-prepare
   ```
**Create a new Laravel project:** 
   ```sh
   make create-project
   ```
**Run the Laravel queue:** 
   ```sh
   make events-queue
   ```
**Dump autoload:** 
   ```sh
   make dumpauto
   ```
**Run fresh migrations with seed:** 
   ```sh
   make fresh
   ```
**Clear all caches:** 
   ```sh
   make clear-all
   ```
**Tail the Symfony dev log:** 
   ```sh
   make logs
   ```
**Enter the backend container:**
   ```sh
   make enter
   ``` 