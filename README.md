# refactor-legacy-code

This project is designed using the hexagonal pattern, which involves restructuring the classic Symfony directory structure.

Inside the `src` directory, we have different layers of the application:

1. `Domain`: In this layer, we have the entities and fixture generation for the different entities.
2. `Application`: In this layer, we have the different use cases, DTOs, and data transformers. All business logic is in this layer.
3. `Infrastructure`: In this layer, we have different API endpoints with autogenerated documentation. Each endpoint calls a use case from the `Application` layer. This layer is also responsible for communicating with the `Domain` layer, getting and setting data.

## Installation:

To install this project, follow these steps:

1. Clone the repository.
2. Run `composer install`.
3. Configure the database.
4. Create the database with the command `php bin/console doctrine:database:create`.
5. Run the migrations with the command `php bin/console doctrine:migrations:migrate -n`.

## Task:

The principal task of this project is refactor this legacy code:

```php
class UserController {
        public function __construct() {
        $this->connection = mysql_connect("localhost", "user", "password");
        mysql_select_db("ProductionDatabase", $this->connection);
        }
        /**
        * registers the user (if it doesn't exist) and returns the database id
        */
        public function register_and_Notify() {
        $user_exists = mysql_query("SELECT * from users where email = '". $_POST['email'] .
        "'", $this->connection);
        if($user_exists) {
        return mysql_fetch_assoc($user_exists)['id'];
        } else {
        // insert into database
        mysql_query("INSERT INTO users(name, email) values('" . $_POST['name'] . "', '" .
        $_POST['email'] . "')", $this->connection);
        // send welcome email
        mail($_POST['email'], 'Welcome to Leadtech', "Hello {$_POST['name']}, thanks for
        registering on our site. <br>Regards, Leadtech Team");
        // return user id
        return mysql_insert_id();
        }
    }
}
```

This "code" is legacy, bad structured and the ``mysql_`` functions are obsoleted in PHP 5.* and erased in php 7.*.

In my approximation, I use a hexagonal patron and behat for testing. This project is a skill refactor test. 
