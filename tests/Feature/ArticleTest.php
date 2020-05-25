<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Article;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testArticleListedCorrectly()
    {
        $this->json('GET', '/api/articles')
        ->assertStatus(200)
        ->assertJsonStructure([
            '*' => ['id', 'body', 'title', 'created_at', 'updated_at'],
        ]);
    }
        
    
    public function testArticleGetOneCorrectly()
    {
        $this->json('GET', '/api/articles/50')
        ->assertStatus(200);
    }
    

    public function testArticleCreatedCorrectly()
    {
        $payload = [
            'title' => 'Titulo',
            'body' => 'Corpo'
        ];
        
        $this->json('POST', 'api/articles', $payload)
        ->assertStatus(201)
        ->assertJson(['id' => 51, 'title' => 'Titulo', 'body' => 'Corpo']);
    }

    public function testArticleUpdateCorrectly()
    {

        $article = factory(Article::class)->create([
            'title' => 'First Article',
            'body' => 'First Body',
        ]);

        $payload = [
            'title' => 'AGORA',
            'body' => 'FUNCIONA',
        ];

        $this->json('PUT', '/api/articles/'.$article->id, $payload)
            ->assertStatus(200)
            ->assertJson([ 
                'id' => 51, 
                'title' => 'AGORA', 
                'body' => 'FUNCIONA' 
            ]);
    }

    public function testArticleDeletedCorrectly()
    {
        $article = factory(Article::class)->create([
            'title' => 'First Article',
            'body' => 'First Body',
        ]);

        $this->json('DELETE', '/api/articles/' . $article->id, [])
            ->assertStatus(204);
    }
}
