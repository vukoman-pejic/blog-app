<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project

Requirements:
1. **User Registration and Authentication**:

- Use Laravel’s built-in authentication system (php artisan make:auth or Laravel Breeze).

- Implement registration, login, and logout functionalities.

2. **Database Setup**:

- Create migration files for the following tables:

        users (id, name, email, password)

        posts (id, user_id, title, content, created_at)

        comments (id, post_id, user_id, comment, created_at)

- Use Eloquent relationships to link:

        User to Posts (one-to-many).

        Post to Comments (one-to-many).

3. **CRUD for Blog Posts**:

- Implement the following routes:

        GET /posts: List all posts.

        GET /posts/create: Show the form to create a new post (authenticated users only).

        POST /posts: Store the post (authenticated users only).

        GET /posts/{id}: View a single post along with comments.

        GET /posts/{id}/edit: Edit the post (only the owner of the post).

        PUT /posts/{id}: Update the post (only the owner of the post).

        DELETE /posts/{id}: Delete the post (only the owner of the post).

    Add input validation for post creation and updating (e.g., required fields for title and content).

4. **Comments**:

- Users can leave comments on posts.

- Implement the following routes:

        POST /posts/{id}/comments: Add a comment (for authenticated users and guests).

        DELETE /comments/{id}: Delete a comment (only the comment owner or post owner).

    Display all comments under the corresponding post.

5. **Authorization & Middleware**:

- Use Laravel’s authorization (e.g., Gate or Policies) to allow only the post/comment owner to edit/delete their content.

- Create middleware to protect routes that require authentication.

6. **Frontend**:

- Use Tailwind CSS for styling.

- Implement simple views for listing posts, creating/editing posts, and viewing comments.

7. **Bonus**:

- Write unit and feature tests using Laravel’s testing framework (php artisan make:test).

## Prerequisites

1. **PHP**: Ensure you have PHP installed (preferably version 8.0 or higher). You can check your PHP version by running:
    ```console
    php -v
    ```
2. **Composer**: Laravel uses Composer for dependency management. You can check if Composer is installed by running:
    ```console
    composer -v
    ```
3. **Database**: Make sure you have a database server running (MySQL, PostgreSQL, SQLite, etc.). You'll need to create a database for your Laravel application.
4. **Docker**
5. **Docker Compose**


## Set up the project

1. **Clone the Project Repository**: Clone your Laravel project repository from GitHub using the following command:
    ```console
    git clone https://github.com/yourusername/your-repo-name.git
    ```
2. **Navigate to the Project Directory**: Change into the project directory:
    ```console
    cd your-repo-name
    ```
3. **Install Composer Dependencies**:  Run the following command to install the required PHP packages using Composer:
    ```console
    composer install
    ```
4. **Copy the Environment File**: Copy the .env.example file to a new file named .env:
    ```console
    cp .env.example .env
    ```
5. **Generate Application Key**: Generate the application key by running the following command. This will set the APP_KEY value in your .env file:
    ```console
    php artisan key:generate
    ```
6. **Configure Your Database**: Open the .env file in a text editor and configure your database connection settings:
    ```console
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password
    ```
7. **Run Migrations**: Run migrations to create the database schema:
    ```console
    php artisan migrate
    ```
8. **Seed the Database**: To populate your database with initial data, run the following command:
    ```console
    php artisan db:seed
    ```
9. **Serve Your Application**: You can start a local development server using the built-in PHP server:
    ```console
    php artisan serve
    ```
    Your application should now be accessible at http://localhost:8000.

10. **Running Tests**: If you want to run the tests to ensure everything is set up correctly, you can use:
    ```console
    php artisan test
    ```
11. **Running Docker**: If you want to run the docker-compose you need to set your connection settings:
    ```console
    MYSQL_ROOT_PASSWORD: YOUR_ROOT_PASSWORD
    MYSQL_DATABASE: YOUR_DATABASE
    MYSQL_USER: YOUR_USERNAME
    MYSQL_PASSWORD: YOUR_PASSWORD
    ```
    and then run the following commands: 
    ```console
    docker-compose build
    docker-compose up
    ```
Once all the containers are up, the application should be available at http://localhost. You can visit it in your browser.
