### BACK-END part of renginiai

## Product name 

Renginių apps`as

## How to run project?

- Download [XAMPP](https://www.apachefriends.org/index.html) and install it.
- Clone or download git repository https://github.com/LukasC0D/renginiai_be.git 
- Add repository to htdocs. The folder is located in the C drive (C:/xampp/htdocs).
- Or clone repository directly to htdocs. In htdocs directory right mouse click Git Bash Here. Type in:
```sh
git clone https://github.com/LukasC0D/renginiai_be.git
```
- Open cloned repository with VS Code.
- Rename .env.example to .env
- Install composer (installation instructions: [Composer](https://getcomposer.org/download)).
- if composer is installed locally in console type: php 'path to composer.phar file'/composer.phar install.
- if composer is installed on your system globally in console type: composer install.
- Run XAMPP. In the C drive run (C:/xampp/xampp-control.exe) and start the Apache server.
- To run project in terminal type in these commands:

```sh
    php <path-to-composer.phar>/composer.phar install           Installs dependencies
    php artisan migrate                                         Creates all the nessesary tables and columns.
    php artisan db:seed                                         Adds the dummy data.
    php artisan key:generate                                    Generates app key in .env file
    php artisan serve                                           Runs live server.
```

-   Open your browser and in the searchbar type in:

```sh
http://127.0.0.1:8000/
```

-   Or press this link => [Localhost:8000](http://127.0.0.1:8000/)

## What technologies I used?

Laravel 9
