# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

// go to C:drive >xampp>htdocs> 
In this htdocs folder you can run this command using git bash
Clone the repository

    git clone https://github.com/safiul0073/task-0073.git

Switch to the repo folder

    cd task-0073

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

 

    npm install && npm run dev

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone https://github.com/safiul0073/task-0073.git
    cd task-0073
    composer install
    cp .env.example .env
    php artisan key:generate

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users. This can help you to quickly start testing  couple a frontend and start using it with ready content.**

Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    
***Admim Mail & Password*** :
    mail: admin@gmail.com
    password: '12345678'

    This project is uses referrar system so that why this user is a root user 


*** Services *** :
    Mail & Stripe 

    you need to setup env for those services
# task-0073


