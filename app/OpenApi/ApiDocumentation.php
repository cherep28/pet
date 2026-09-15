<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'API',
    description: 'API для взаимодействия Laravel с фронтендом'
)]
class ApiDocumentation
{
}
