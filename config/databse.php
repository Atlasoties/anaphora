<?php

return [
	'connections' => [
	    'mysql' => [
	        'driver' => 'mysql',
	        'host' => env('DB_HOST', '127.0.0.1'),
	        'port' => env('DB_PORT', '3306'),
	        'database' => env('DB_DATABASE', 'your_test_database'),
	        'username' => env('DB_USERNAME', 'your_database_user'),
	        'password' => env('DB_PASSWORD', 'your_database_password'),
	        // ...
    	],
    	// ...
	],
];