# PetStore Application

## Overview
The PetStore Application is a Laravel-based project that interacts with the PetStore API. It provides functionalities for managing pets, including creating, updating, fetching, and deleting pet information. This application uses Laravel services, controllers, enums, and custom exceptions to achieve a clean and modular structure.

---

## Features

- **Pet Management:** Create, update, view, and delete pets.
- **Pet Status Filtering:** Filter pets based on their status (Available, Pending, Sold).
- **Custom Exception Handling:** Provides meaningful error messages using custom exceptions.
- **API Integration:** Interacts with the [Swagger PetStore API](https://petstore.swagger.io/v2).
- **Unit and Feature Tests:** Comprehensive testing for services and controllers.

---

## Installation

### Prerequisites

- PHP >= 8.0
- Composer
- Laravel 10
- Node.js and npm (for front-end assets)
- MySQL or another supported database

### Steps

1. Clone the repository:
    ```bash
    git clone <repository-url>
    cd <repository-folder>
    ```

2. Install PHP dependencies:
    ```bash
    composer install
    ```

3. Install front-end dependencies:
    ```bash
    npm install && npm run dev
    ```

4. Configure environment variables:
    ```bash
    cp .env.example .env
    ```
    Update the `.env` file with your database and PetStore API details.

5. Generate the application key:
    ```bash
    php artisan key:generate
    ```

6. Run migrations:
    ```bash
    php artisan migrate
    ```

---

## Configuration

The API base URL is configured in the `config/services.php` file. Ensure the `PETSTORE_API_URL` environment variable is set correctly:

```php
'petstore' => [
    'api_url' => env('PETSTORE_API_URL', 'https://petstore.swagger.io/v2'),
],
```

---

## Usage

### Routes

- **GET `/pets`** - List pets by status.
- **POST `/pets`** - Create a new pet.
- **GET `/pets/{id}`** - View details of a specific pet.
- **PUT `/pets/{id}`** - Update pet details.
- **DELETE `/pets/{id}`** - Delete a pet.

### Commands

- **Start the server:**
    ```bash
    php artisan serve
    ```

- **Run tests:**
    ```bash
    php artisan test
    ```

---

## Testing

### Feature Tests

- Verifies controller logic and user interactions.
- Example: Fetching pets, creating new pets, handling exceptions.

### Unit Tests

- Focuses on service logic and API interactions.
- Example: Testing `PetService` methods for fetching, creating, updating, and deleting pets.

Run all tests:
```bash
php artisan test
```

---

## Directory Structure

- **`app/Services/PetService.php`** - Handles API interactions for pet operations.
- **`app/Http/Controllers/PetController.php`** - Manages pet-related HTTP requests.
- **`app/Http/Requests`** - Contains validation logic for creating and updating pets.
- **`app/Enums/PetStatus.php`** - Enum class for pet statuses.
- **`app/Exceptions`** - Custom exception classes for handling errors.
- **`resources/views`** - Blade templates for rendering the user interface.

---

## Custom Exceptions

- **`InvalidIdException`**: Thrown when an invalid ID is supplied.
- **`PetNotFoundException`**: Thrown when a pet is not found.
- **`ValidationException`**: Thrown when a validation error occurs.

---

## Frontend

This application uses Blade templates for rendering the user interface. Key views:

- **`layouts/app.blade.php`** - Main layout template.
- **`pets/index.blade.php`** - Displays a list of pets.
- **`pets/form.blade.php`** - Form for creating or editing a pet.
- **`pets/show.blade.php`** - Displays details of a specific pet.

---

## API Integration

The application interacts with the Swagger PetStore API. Key endpoints:

- **GET `/pet/findByStatus`** - Fetch pets by status.
- **GET `/pet/{id}`** - Fetch pet by ID.
- **POST `/pet`** - Create a new pet.
- **PUT `/pet`** - Update an existing pet.
- **DELETE `/pet/{id}`** - Delete a pet.

---

## Testing APIs

Use tools like Postman or cURL to test the API endpoints.

Example cURL request to fetch pets by status:
```bash
curl -X GET "https://petstore.swagger.io/v2/pet/findByStatus?status=available"
```

---

## Troubleshooting

- **Invalid ID error:** Ensure the ID is an integer and exists in the PetStore API.
- **Validation error:** Check that the payload matches the expected format.
- **Pet not found:** Confirm the pet ID exists in the API.

---

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/your-feature`).
3. Commit your changes (`git commit -m 'Add your feature'`).
4. Push to the branch (`git push origin feature/your-feature`).
5. Open a pull request.

---

## License

This project is licensed under the MIT License.

---

## Credits

Developed by Marek Stankiewicz
