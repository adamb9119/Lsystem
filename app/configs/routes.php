<?php

return [
    'config.routes' => [
    	[
            'name' => 'home',
            'pattern' => '/',
            'controller' => 'Lsystems\Controllers\IndexController::indexAction',
            'method' => 'get'
        ],
        [
            'name' => 'create',
            'pattern' => '/create/',
            'controller' => 'Lsystems\Controllers\IndexController::createAction',
            'method' => 'post'
        ]
    ],
];