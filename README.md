# Calendar Services API

This API is designed to handle calendar services in an application built with technologies such as Laravel, Domain-Driven Design (DDD), and Docker. It provides essential functionalities for creating, modifying, and querying services related to events.

## Key Features

- **Laravel**: The API has been developed using the Laravel framework, leveraging its robustness and efficiency in handling HTTP requests, databases, and other fundamental aspects.

- **Domain-Driven Design (DDD)**: A DDD-based architecture has been followed to organize and structure the code in a clear and coherent manner, facilitating development, maintenance, and scalability.

- **Docker**: The application is containerized with Docker, ensuring a consistent and easily deployable execution environment in various setups.

## Highlighted Functionalities

1. **Event Services Creation**: Efficiently allows the creation of services linked to events, providing necessary data for their configuration.

2. **Service Modification**: Offers endpoints to update information for existing services, enabling adjustments and changes as needed.

3. **Service Querying**: Facilitates the retrieval of detailed information about event services, with filtering and sorting options for a personalized experience.

4. **Collision Validation**: Implements collision validation to ensure that scheduled events do not overlap, preventing conflicts in the scheduling of services.


## Usage

To get started with the API, refer to the provided documentation outlining available endpoints, required parameters, and expected responses.

Before using the `make run-attached` command, edit the Makefile and replace `<absolute_path_to_your_project>` with the absolute path to your project.

Enjoy utilizing the Events Services API in your application built with Laravel, DDD, and Docker!

## Docker Commands with Makefile

To simplify Docker-related tasks, a Makefile has been provided with the following commands:

- `make build`: Builds the Docker containers for the API.
- `make run`: Runs the Docker containers in the background.
- `make run-attached`: Runs the Docker containers in attached mode for debugging and real-time logs. Note: Edit the Makefile and replace `<absolute_path_to_your_project>` with the absolute path to your project before using this command.

