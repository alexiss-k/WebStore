<?php
return [
    'admin' => [
        'type' => 2,
        'description' => 'Админ панель',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'ruleName' => 'userRole',
    ],
    'administrator' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'userRole',
        'children' => [
            'user',
            'admin',
        ],
    ],
];
