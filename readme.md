Scheduler Application
=====================
A simple scheduler CLI application with a mini-framework written in clean PHP.


Requirements
------------
- PHP >= 7.4.0
- Composer
- PHP Extension - JSON
- PHP Extension - PDO

How to install
---------------

In order to install the application,

make sure you have all the requirements installed and then:

1. Run the following commands:

        # Clone the repository
        $ git clone https://github.com/dannydamsky/Scheduler-PHP-App.git
            
        # Make sure the autoloader is generated.
        $ composer update
    
        # Copy over the .env.sample file to .env
        $ cp .env.sample .env 

2. Edit the .env file to match your server configurations.

3. Edit your crontab configuration to include:

        * * * * * php YOUR_PROJECT_DIR/cli cron:run 2>&1 >> YOUR_PROJECT_DIR/cron.log

Usage
------

In order to use the CLI application you can run (from inside the project folder):

        $ php cli
        
This will give you a list of all commands that are available to you. Like so:

        $ php cli
        
                Available commands:
                        migrate
                        cron:run
                        operation:execute
                        schedule:random-data:create
                        schedule:random-data:update
                        schedule:random-data:delete
                        

Commands
---------

1. migrate - Run the database migrations located in the database/migrations folder.
2. cron:run - Run any crons that are scheduled up to the current date and didn't run yet.
3. operation:execute - Execute pending create/update/delete operations.
4. schedule:random-data:create - Create an operation that's scheduled to create a random data row.
5. schedule:random-data:update - Create an operation that's scheduled to update a random data row.
6. schedule:random-data:delete - Create an operation that's scheduled to delete a random data row.

Directories
-----------

1. app/ - Application code directory
2. base/ - Framework code directory
3. config/ - Configurations directory
4. database/ - Database directory
5. database/migrations - Database migrations directory.

Developer
---------
Danny Damsky <dannydamsky99@gmail.com>