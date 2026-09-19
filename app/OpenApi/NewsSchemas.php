<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'News', type: 'object', required: ['id', 'title', 'slug', 'summary', 'content', 'image_url', 'is_published', 'published_at'], properties: [
    new OA\Property(property: 'id', type: 'integer', example: 1),
    new OA\Property(property: 'title', type: 'string', example: 'Новости города'),
    new OA\Property(property: 'slug', description: 'Уникальный адрес; генерируется сервером из заголовка.', type: 'string', example: 'novosti-goroda'),
    new OA\Property(property: 'summary', type: 'string', maxLength: 500, nullable: true, example: 'Краткое описание новости'),
    new OA\Property(property: 'content', type: 'string', minLength: 10, example: 'В городе открылся новый большой парк.'),
    new OA\Property(property: 'image_url', type: 'string', format: 'uri', maxLength: 2048, nullable: true, example: 'https://example.com/news.jpg'),
    new OA\Property(property: 'is_published', type: 'boolean', example: true),
    new OA\Property(property: 'published_at', type: 'string', format: 'date-time', nullable: true, example: '2026-09-17T10:00:00+09:00')
])]
#[OA\Schema(schema: 'StoreNewsRequest', type: 'object', required: ['title', 'content', 'is_published'], properties: [
    new OA\Property(property: 'title', type: 'string', minLength: 3, maxLength: 255, example: 'Новости города'),
    new OA\Property(property: 'summary', type: 'string', maxLength: 500, nullable: true, example: 'Краткое описание новости'),
    new OA\Property(property: 'content', type: 'string', minLength: 10, example: 'В городе открылся новый большой парк.'),
    new OA\Property(property: 'image_url', type: 'string', format: 'uri', maxLength: 2048, nullable: true, example: 'https://example.com/news.jpg'),
    new OA\Property(property: 'is_published', type: 'boolean', example: true),
    new OA\Property(property: 'published_at', description: 'Дата, принимаемая правилом Laravel date; рекомендуется ISO 8601.', type: 'string', nullable: true, example: '2026-09-17T10:00:00+09:00')
])]
#[OA\Schema(schema: 'UpdateNewsRequest', type: 'object', description: 'Все поля необязательны. Непереданные поля сохраняются. При изменении title пересоздаётся slug. Nullable-поля можно очистить значением null.', properties: [
    new OA\Property(property: 'title', type: 'string', minLength: 3, maxLength: 255, example: 'Новости города'),
    new OA\Property(property: 'summary', type: 'string', maxLength: 500, nullable: true, example: 'Краткое описание новости'),
    new OA\Property(property: 'content', type: 'string', minLength: 10, example: 'В городе открылся новый большой парк.'),
    new OA\Property(property: 'image_url', type: 'string', format: 'uri', maxLength: 2048, nullable: true, example: 'https://example.com/news.jpg'),
    new OA\Property(property: 'is_published', type: 'boolean', example: true),
    new OA\Property(property: 'published_at', description: 'Дата, принимаемая правилом Laravel date; рекомендуется ISO 8601.', type: 'string', nullable: true, example: '2026-09-17T10:00:00+09:00')
])]
#[OA\Schema(schema: 'NewsResponse', type: 'object', required: ['data'], properties: [
    new OA\Property(property: 'data', ref: '#/components/schemas/News')
])]
#[OA\Schema(schema: 'NotFoundError', type: 'object', required: ['message'], properties: [
    new OA\Property(property: 'message', type: 'string', example: 'Такой новости нет')
])]
#[OA\Schema(schema: 'ValidationError', type: 'object', required: ['message', 'errors'], properties: [
    new OA\Property(property: 'message', type: 'string', example: 'Заголовок имени должен быть обязательным'),
    new OA\Property(property: 'errors', type: 'object', additionalProperties: new OA\AdditionalProperties(type: 'array', items: new OA\Items(type: 'string')), example: ['title' => ['Заголовок имени должен быть обязательным']])
])]
#[OA\Schema(schema: 'PaginationLinks', type: 'object', required: ['first', 'last', 'prev', 'next'], properties: [
    new OA\Property(property: 'first', type: 'string', format: 'uri', nullable: false, example: 'http://127.0.0.1:8000/api/news?page=1'),
    new OA\Property(property: 'last', type: 'string', format: 'uri', nullable: false, example: 'http://127.0.0.1:8000/api/news?page=1'),
    new OA\Property(property: 'prev', type: 'string', format: 'uri', nullable: true, example: 'http://127.0.0.1:8000/api/news?page=1'),
    new OA\Property(property: 'next', type: 'string', format: 'uri', nullable: true, example: 'http://127.0.0.1:8000/api/news?page=1')
])]
#[OA\Schema(schema: 'PaginationLink', type: 'object', required: ['url', 'label', 'page', 'active'], properties: [
    new OA\Property(property: 'url', type: 'string', format: 'uri', nullable: true),
    new OA\Property(property: 'label', type: 'string', example: '1'),
    new OA\Property(property: 'page', type: 'integer', nullable: true, example: 1),
    new OA\Property(property: 'active', type: 'boolean', example: true)
])]
#[OA\Schema(schema: 'PaginationMeta', type: 'object', required: ['current_page', 'from', 'last_page', 'links', 'path', 'per_page', 'to', 'total'], properties: [
    new OA\Property(property: 'current_page', type: 'integer', example: 1),
    new OA\Property(property: 'from', type: 'integer', nullable: true, example: 1),
    new OA\Property(property: 'last_page', type: 'integer', example: 3),
    new OA\Property(property: 'links', type: 'array', items: new OA\Items(ref: '#/components/schemas/PaginationLink')),
    new OA\Property(property: 'path', type: 'string', format: 'uri', example: 'http://127.0.0.1:8000/api/news'),
    new OA\Property(property: 'per_page', type: 'integer', example: 10),
    new OA\Property(property: 'to', type: 'integer', nullable: true, example: 10),
    new OA\Property(property: 'total', type: 'integer', example: 25)
])]
#[OA\Schema(schema: 'NewsCollection', type: 'object', required: ['data', 'links', 'meta'], properties: [
    new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/News')),
    new OA\Property(property: 'links', ref: '#/components/schemas/PaginationLinks'),
    new OA\Property(property: 'meta', ref: '#/components/schemas/PaginationMeta')
])]
class NewsSchemas
{
}
