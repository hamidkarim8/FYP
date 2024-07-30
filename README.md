# Laravel Project Setup

## Prerequisites

Ensure you have the following installed on your local development environment:

- PHP >= 7.3
- Composer
- MySQL or any other supported database
- Node.js and npm

## Getting Started

### Clone the Repository

Clone the repository to your local machine using the following command:

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

# Install Dependencies
# Install the PHP dependencies using Composer:
composer install

#Install the JavaScript dependencies using npm:

npm install

### Environment Setup

# Copy the example environment file to create a new .env file:

cp .env.example .env

# Open the newly created .env file and replace the placeholder values with your actual settings


### Generate Application Key

php artisan key:generate


### Migrate and Seed the Database

php artisan migrate
php artisan db:seed --class=CategorySeeder

### Serve the Application

php artisan serve

# The application will be accessible at http://localhost:8000.

### Compile Assets

npm run dev

