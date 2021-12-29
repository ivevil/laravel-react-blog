# Frontend: React || Backend: PHP/Laravel

This blog is created on Blade templates as a frontend running on Laravel framework. 
For backend we created custom cms specially created for this blog. There are several widgets used for inputing data for frontend.
An idea was to create fully custom CMS for various frontends showing data pulled from CMS. 
Currently we are working on improving API which is going to be used for frontend running on React.

## Using the app
- Make a copy of this repository in your own github account (do not fork unless you really want to be public).
- Create a personal repository in github.
- Make changes, commit them, and push them in your own repository.

## Start the app
- Clone the repository
> git clone git@github.com:ivevil/laravel-react-blog.git

- Switch to the repo folder
> cd laravel-blog

- Install all the dependencies using composer
> composer install

- Create .env file and fill it up with your name of app, database etc.
> cp .env

- Generate a new application key
> php artisan key:generate

- Run the database migrations (Set the database connection in .env before migrating)
> php artisan migrate

- Start the local development server
> php artisan serve

- You can now access the server at http://127.0.0.1:8000

## Testing API
- Run the laravel development server
> php artisan serve

- The api can now be accessed at http://127.0.0.1:8000/api
