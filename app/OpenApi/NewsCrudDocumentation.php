<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: '/api/news', operationId: 'listNews', tags: ['News'],
    summary: 'Список новостей',
    description: 'Сортировка по ID от новых к старым. Поиск по части заголовка без учёта регистра, включая кириллицу в SQLite. Пустой поиск возвращает весь список. При отсутствии совпадений возвращается 200 и пустой data. Параметры сохраняются в ссылках пагинации. Возвращаются и опубликованные новости, и черновики.',
    parameters: [
        new OA\Parameter(name: 'search', in: 'query', description: 'Поиск по title. Пробелы по краям удаляются. Символы % и _ работают как шаблоны SQL LIKE.', schema: new OA\Schema(type: 'string'), example: 'новости'),
        new OA\Parameter(name: 'page', in: 'query', schema: new OA\Schema(type: 'integer', minimum: 1, default: 1)),
        new OA\Parameter(name: 'per_page', in: 'query', description: 'Размер страницы; значения вне диапазона приводятся к 1–50.', schema: new OA\Schema(type: 'integer', minimum: 1, maximum: 50, default: 10)),
    ],
    responses: [new OA\Response(response: 200, description: 'Страница новостей', content: new OA\JsonContent(ref: '#/components/schemas/NewsCollection'))]
)]
#[OA\Get(path: '/api/news/{news}', operationId: 'showNews', tags: ['News'], summary: 'Новость по ID', parameters: [new OA\Parameter(name: 'news', in: 'path', required: true, description: 'ID новости', schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)], responses: [new OA\Response(response: 200, description: 'Новость найдена', content: new OA\JsonContent(ref: '#/components/schemas/NewsResponse')), new OA\Response(response: 404, description: 'Новость не найдена', content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError'))])]
#[OA\Get(path: '/api/news/slug/{slug}', operationId: 'showNewsBySlug', tags: ['News'], summary: 'Новость по slug', parameters: [new OA\Parameter(name: 'slug', in: 'path', required: true, schema: new OA\Schema(type: 'string'), example: 'novosti-goroda')], responses: [new OA\Response(response: 200, description: 'Новость найдена', content: new OA\JsonContent(ref: '#/components/schemas/NewsResponse')), new OA\Response(response: 404, description: 'Новость не найдена', content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError'))])]
#[OA\Post(path: '/api/news', operationId: 'storeNews', tags: ['News'], summary: 'Создать новость', description: 'Slug создаётся сервером из title. При совпадении добавляется числовой суффикс. ID и slug передавать не нужно.', requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/StoreNewsRequest')), responses: [new OA\Response(response: 201, description: 'Новость создана', content: new OA\JsonContent(ref: '#/components/schemas/NewsResponse')), new OA\Response(response: 422, description: 'Ошибка валидации', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError'))])]
#[OA\Patch(path: '/api/news/{news}', operationId: 'updateNews', tags: ['News'], summary: 'Частично обновить новость', description: 'Меняются только переданные поля. Изменение заголовка меняет slug; прежняя ссылка может перестать работать. Пустой объект допустим. Валидация выполняется до поиска записи.', parameters: [new OA\Parameter(name: 'news', in: 'path', required: true, description: 'ID новости', schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/UpdateNewsRequest')), responses: [new OA\Response(response: 200, description: 'Новость обновлена', content: new OA\JsonContent(ref: '#/components/schemas/NewsResponse')), new OA\Response(response: 404, description: 'Новость не найдена', content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError')), new OA\Response(response: 422, description: 'Ошибка валидации', content: new OA\JsonContent(ref: '#/components/schemas/ValidationError'))])]
#[OA\Delete(path: '/api/news/{news}', operationId: 'deleteNews', tags: ['News'], summary: 'Удалить новость', parameters: [new OA\Parameter(name: 'news', in: 'path', required: true, description: 'ID новости', schema: new OA\Schema(type: 'integer', minimum: 1), example: 1)], responses: [new OA\Response(response: 204, description: 'Новость удалена. Тело ответа отсутствует.'), new OA\Response(response: 404, description: 'Новость не найдена', content: new OA\JsonContent(ref: '#/components/schemas/NotFoundError'))])]
class NewsCrudDocumentation
{
}
