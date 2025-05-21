<?php

use App\Exceptions\PhoneNotFoundException;
use App\Exceptions\SubscriberNotFoundException;
use App\Exceptions\InvalidPhoneException;

return [
    [
        'exceptions' => [
            PhoneNotFoundException::class,
            SubscriberNotFoundException::class
        ],
        'status'  => 404,
        'message' => 'Ресурс не найден',
        'code'    => 'RESOURCE_NOT_FOUND'
    ],
    [
        'exceptions' => [
            InvalidPhoneException::class
        ],
        'status'  => 400,
        'message' => 'Неверный формат телефона',
        'code'    => 'INVALID_PHONE'
    ]
];
