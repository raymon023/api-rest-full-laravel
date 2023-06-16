<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_can_create_articles(): void
    {   
        $this->withoutExceptionHandling();
        $response =  $this->postJson(route('articles.create'), [
            'data' => [
                'type' => 'articles',
                'attributes' => [
                    'title' => 'new article',
                    'slug' => 'new-slug',
                    'content' => 'new content'
                ]
            ]
        ]);

        $response->assertCreated();

        $article = Article::first();

        $response->assertHeader(
            'Location',
            route('articles.show', $article)
        );

        $response->assertExactJson([

            'data' => [
                'type' => 'articles',
                'id' => $article->getRouteKey(),
                'attributes' => [
                    'title' => 'new article',
                    'slug' => 'new-slug',
                    'content' => 'new content'
                ],
                'links' => [
                    'self' => route('articles.show', $article)
                ]
            ]
        ]);

    }
}
