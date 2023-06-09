<?php

namespace App\Http\Resources\Article;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'articles',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'slug' => $this->slug,
                'content' => $this->content
            ],
            'links' => [
                'self' => route('articles.show', $this->resource)
            ]
        ];
    }

    public function toResponse($request){
        return parent::toResponse($request)->withHeaders([
            'Location' => route('articles.show',$this->resource)
        ]);
    }
}
