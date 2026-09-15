<?php

namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsApiTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_news_can_be_stored(): void
    {
        $data = [
            'title'         => 'Новости города',
            'summary'       => 'Краткое описание новости',
            'content'       => 'В городе открылся новый большой парк.',
            'image_url'     => null,
            'is_published'  => true,
            'published_at'  => '2026-09-15 10:00:00',
        ];    

        $response = $this->postJson('/api/news', $data);

        $response->assertCreated();
        $response->assertJsonPath('data.title', $data['title']);
        $response->assertJsonPath('data.slug', 'novosti-goroda');
        $response->assertJsonPath('data.is_published', true);

        $this->assertDatabaseHas('news',[
            'id'            => $response->json('data.id'),
            'title'         => $data['title'],
            'slug'          => 'novosti-goroda',
            'content'       => $data['content'],
            'is_published'  => 1
        ]);
    }

    public function test_news_can_be_stored_error_422(): void{
        $data = [
            'title'         => '',
            'content'       => '123',
            'is_published'  => 'string',
        ];

        $response = $this->postJson('/api/news', $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'title',
            'content',
            'is_published',
        ]);

        $this->assertDatabaseCount('news', 0);
    }

    public function test_news_can_be_found_by_slug(): void{
        $news = News::factory()->create([
            'slug' => 'novosti-goroda'
        ]);

        $response = $this->getJson('/api/news/slug/novosti-goroda');

        $response->assertOk();
        $response->assertJsonPath('data.id', $news->id);
        $response->assertJsonPath('data.title', $news->title);
        $response->assertJsonPath('data.slug', $news->slug);
    }

    public function test_miss_found_news_by_slug(): void{
        News::factory()->create([
            'slug' => 'novosti-goroda'
        ]);

        $response = $this->getJson('/api/news/slug/novosti-garada');

        $response->assertNotFound();
        $response->assertJsonPath('message', 'Такой новости нет');
    }

    public function test_news_can_be_update(): void{
        $news = News::factory()->create([
                'title'     => 'Старый заголовок',
                'slug'      => 'staryi-zagolovok',
                'content'   => 'Этот текст должен остаться без изменений.',
        ]);

        $data = [
            'title' => 'Новости города',
        ];

        $response = $this->patchJson("/api/news/{$news->id}", $data);

        $response->assertOk();
        $response->assertJsonPath('data.id', $news->id);
        $response->assertJsonPath('data.title', $data['title']);
        $response->assertJsonPath('data.slug', 'novosti-goroda');
        $response->assertJsonPath('data.content', $news->content);

        $this->assertDatabaseHas('news',[
            'id'            => $news->id,
            'title'         => $data['title'],
            'slug'          => 'novosti-goroda',
            'content'       => $news->content,
        ]);
    }

    public function test_news_can_be_deleted(): void{
        $news = News::factory()->create([
                'title'     => 'Старый заголовок',
                'slug'      => 'staryi-zagolovok',
                'content'   => 'Этот текст должен остаться без изменений.',
        ]);

        $response = $this->deleteJson("/api/news/{$news->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('news',[
            'id' => $news->id
        ]);
    }

    public function test_news_list_is_paginated(): void{
        News::factory()->count(12)->create();

        $response = $this->getJson('/api/news?per_page=5&page=2');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
        $response->assertJsonPath('meta.current_page', 2);
        $response->assertJsonPath('meta.per_page', 5);
        $response->assertJsonPath('meta.total', 12);
        $response->assertJsonPath('meta.last_page', 3);
    }
    
    public function test_news_can_be_search_by_title(): void{
        $news = News::factory()->create([
            'title' => 'Новости города',
        ]);

        News::factory()->create([
            'title' => 'Затоплен поселок',
        ]);

        $response = $this->getJson('/api/news?' . http_build_query([
            'search' => 'новости',
        ]));

        $response->assertOk();

        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $news->id);
        $response->assertJsonPath('data.0.title', $news->title);
        $response->assertJsonPath('meta.total', 1);
    }

    public function test_invalid_update_doesnt_change_news(): void{
        $news = News::factory()->create([
            'title' => 'Новости города',
            'slug'  => 'novosti-goroda',
        ]);

        $data = [
            'title' => ''
        ];

        $response = $this->patchJson("/api/news/{$news->id}", $data);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['title']);

        $this->assertDatabaseHas('news',[
            'id'    => $news->id,
            'title' => $news->title,
            'slug'  => $news->slug
        ]);
    }
}
