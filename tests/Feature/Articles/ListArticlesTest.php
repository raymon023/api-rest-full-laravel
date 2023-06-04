<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListArticlesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_can_fetch_a_single_artcile(): void
    {
        $article = Article::factory()->create();

        $response = $this->getJson(route('articles.show', $article));

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => $article->id,
                'attributes' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content
                ],
                'links' => [
                    'self' => route('articles.show', $article)
                ]
            ]
        ]);
    }

    public function test_can_fetch_all_artciles()
    {
        $this->withoutDeprecationHandling();

        $articles = Article::factory()->count(3)->create();


        $response = $this->getJson(route('articles.index'))->dump();

        $response->assertExactJson([
            'data' => [
                [
                    'type' => 'articles',
                    'id' => $articles[0]->id,
                    'attributes' => [
                        'title' => $articles[0]->title,
                        'slug' => $articles[0]->slug,
                        'content' => $articles[0]->content
                    ],
                    'links' => [
                        'self' => route('articles.show', $articles[0])
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => $articles[1]->id,
                    'attributes' => [
                        'title' => $articles[1]->title,
                        'slug' => $articles[1]->slug,
                        'content' => $articles[1]->content
                    ],
                    'links' => [
                        'self' => route('articles.show', $articles[1])
                    ]
                ],
                [
                    'type' => 'articles',
                    'id' => $articles[2]->id,
                    'attributes' => [
                        'title' => $articles[2]->title,
                        'slug' => $articles[2]->slug,
                        'content' => $articles[2]->content
                    ],
                    'links' => [
                        'self' => route('articles.show', $articles[2])
                    ]
                ]
            ],
            'links' => [
                'self' => route('articles.index')
            ]
        ]);
    }
}
