<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);
        $perPage = max(1, min($perPage, 50));

        $search = trim((string) $request->string('search'));

        $query = News::query()
            ->where('is_published', true)
            ->where('published_at', '<=', now());

        if ($search !== '') {
            $lowerFunction = 'LOWER';

            if ($query->getConnection()->getDriverName() === 'sqlite') {
                $query->getConnection()->getReadPdo()->sqliteCreateFunction(
                    'unicode_lower',
                    static fn (string $value): string => mb_strtolower($value, 'UTF-8'),
                    1
                );

                $lowerFunction = 'unicode_lower';
            }

            $query->whereRaw(
                "{$lowerFunction}(title) LIKE ?",
                ['%' . mb_strtolower($search, 'UTF-8') . '%']
            );
        }

        $news = $query
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return NewsResource::collection($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $data = $request->validated();

        $baseSlug = Str::slug($data['title'], '-', 'ru') ?: 'news';

        $slug = $baseSlug;
        $number = 1;

        while(News::where('slug', $slug)->exists()){
            $slug = $baseSlug . '-' . $number;
            $number++;
        }

        $data['slug'] = $slug;
        $news = News::create($data);

        return (new NewsResource($news))->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   
        $news = News::find($id);

        if (!$news){
            return response()->json([
                'message' => 'Такой новости нет'
            ], 404);
        }

        return new NewsResource($news);
    }

        /**
     * Display the specified resource.
     */
    public function showBySlug(string $slug)
    {   
        $news = News::where('slug', $slug)->first();

        if (!$news){
            return response()->json([
                'message' => 'Такой новости нет'
            ], 404);
        }

        return new NewsResource($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, string $id)
    {
        $news = News::find($id);

        if (!$news){
            return response()->json([
                'message' => 'Такой новости нет'
            ],404);
        }

        $data = $request->validated();

        if (isset($data['title']) && $data['title'] !== $news->title){
            $baseSlug = Str::slug($data['title'], '-', 'ru') ?: 'news';

            $slug = $baseSlug;
            $number = 1;

            while(News::where('slug', $slug)
                    ->where('id','!=', $news->id)
                    ->exists())
            {
                $slug = $baseSlug . '-' . $number;
                $number++;
            }

            $data['slug'] = $slug;
        }

        $news->update($data);

        return new NewsResource($news);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::find($id);

        if (!$news){
            return response()->json([
                'message' => 'Такой новости нет'
            ],404);
        }

        $news->delete();

        return response()->noContent();
    }
}
