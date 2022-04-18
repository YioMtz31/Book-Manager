# Library Manager

This repository contains the code for the library manager challenge. It is a Laravel app serving a Vue JS
frontend with bootstrap css.


## Technology

-   Laravel
-   VueJS

Make sure to have `Composer` and `NPM` setup corectly in your system

## Recommended web server
Laragon provides you a modern & powerful development environment that countless people love to use every day.
https://laragon.org/download/
 Or you can user the web server of your preference (XAMP, MAMP etc)
 
## Initial Setup
In your local webserver www or http directory create a folder for the project
In laragon its as simple as going to menu->quick app->blank then just add a name for your site, this will be user to access the app in the browser by typing 
yousitename.test

1. Open a terminal in the project directory.
2. clone this repo `git clone https://github.com/YioMtz31/Book-Manager.git .`
3. Install dependencies:
    - `composer install`
    - `npm install`
4. In your loval server create a new MySql database
5. Create a fresh environment file:
    - for windows `copy .env.example .env`
    - for linux `cp .env.example .env`
5. Edit the `.env` file to run it locally add your database connection variables:
    - DB_HOST=localhost
    - DB_PORT=3306
    - DB_DATABASE=your_database_name
    - DB_USERNAME=your_database_user
    - DB_PASSWORD=your_database_password
6. Run in terminal `php artisan project:init` to migrate and seed your database
7. Run in terminal `npm run dev` to build the frontend code
8. visit your page at 'yoursitename.test'

If the site does not load make sure you have the correct value for the site ROOT directory in your werserver host or vhost file.
in laragon open menu->apache->site-enabled and select the file that corresponds to your site.
Add or edit  the first line in my case its `define ROOT "C:/laragon/www/book-manager/public"` make sure yours has `\public` at the end of the line

## Default admin user
user1@email.com
password: password
## Default non admin user
user2@email.com
password: password

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
