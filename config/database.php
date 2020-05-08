<?php

return [
    /*
     * Database driver.
     * Currently supported drivers: mysql
     */
    'driver' => env('DATABASE_DRIVER', 'mysql'),

    /*
     * The name of the database to connect to.
     */
    'name' => env('DATABASE_NAME'),

    /*
     * The name of the database owner.
     */
    'username' => env('DATABASE_USERNAME'),

    /*
     * The password of the database owner.
     */
    'password' => env('DATABASE_PASSWORD'),

    /*
     * The database host name.
     */
    'hostname' => env('DATABASE_HOSTNAME')
];