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

      $response = $this->getJson('/api/v1/articles'. $article->getRouteKey());

      $response->assertSee($article->title);

    }
}
