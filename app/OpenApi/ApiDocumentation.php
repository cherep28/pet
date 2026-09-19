<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'News API',
    description: 'Учебный API новостей. Все ответы в JSON, кроме пустого ответа 204. Отправляйте Accept: application/json. Авторизация пока не реализована.'
)]
#[OA\Server(url: '/', description: 'Текущий сервер')]
#[OA\Tag(name: 'News', description: 'Новости')]
class ApiDocumentation
{
}
