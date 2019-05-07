<?php
return [
	 /*
    |--------------------------------------------------------------------------
    | Thumbnails and storage and show paths for uploaded files and images
    |--------------------------------------------------------------------------
    |
    | List of image thumbnails used in site
    | small - 80x80
    |
    */

    'thumbnails' => [
    	'small' => ['width' => 80, 'height' => 80]
    ],

    'upload' => [
    	'images' =>[
	    	'users' => [
	    		'show' => '/storage/images/users/',
	    		'storage' => 'images/users/'
	    	],
	    	'companies' => [
	    		'show' => '/storage/images/companies/',
	    		'storage' => 'images/companies/'
	    	]
    	]
    ]

];