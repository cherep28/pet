<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'News',
    type: 'object',
    required: ['id', 'title', 'slug','summary','content','image_url','published_at'],
    properties: [
        new OA\Property(property: 'id'          , type: 'integer'   , example: 1),
        new OA\Property(property: 'title'       , type: 'string'    , maxLength: 255    , example: 'Весь день дождь'),
        new OA\Property(property: 'slug'        , type: 'string'    , nullable: true    , uniqueItems: true, example: 'all-day-raining'),
        new OA\Property(property: 'summary'     , type: 'text'      , nullable: true    , example: 'На сегодня весь день обещают дождь'),
        new OA\Property(property: 'content'     , type: 'longText'  , example: 'На сегодня весь день обещают дождь предпологают сильный ветер'),
        new OA\Property(property: 'image_url'   , type: 'string'    , nullable: true    , example: '/upload/picture.png'),
        new OA\Property(property: 'is_published', type: 'boolean'   , example: true),
        new OA\Property(property: 'published_at', type: 'timestamps', nullable: true    , example: '2026-08-16T10:00:00Z'),
    ]
)]
class NewsSchemas
{
}
