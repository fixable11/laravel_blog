<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ArticleTest.
 */
class ArticleTest extends TestCase
{
    use RefreshDatabase, GenerateBearerTokenTrait;

    /**
     * @var string $token Jwt token.
     */
    private $token;

    /**
     * Set up fixtures.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->token = $this->generateBearerToken();
    }

    /**
     * Test that we can add new article.
     *
     * @return void
     */
    public function testThatWeCanAddArticle(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title',
            'description' => 'Description',
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'title' => 'Title',
                'description' => 'Description',
                'id' => 1,
            ]);
    }

    /**
     * Test that we can get all articles.
     *
     * @return void
     */
    public function testThatWeCanGetAllArticles(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title1',
            'description' => 'Description1',
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title2',
            'description' => 'Description2',
        ]);

        $response = $this->json('GET', '/api/v1/articles');

        $response->assertJsonCount(2);
    }

    /**
     * Test that we can specific article.
     *
     * @return void
     */
    public function testThatWeCanGetSpecificArticle(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title1',
            'description' => 'Description1',
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title2',
            'description' => 'Description2',
        ]);

        $response = $this->json('GET', '/api/v1/articles/1');

        $response->assertJson([
            'title' => 'Title1',
            'description' => 'Description1',
        ]);
    }

    /**
     * Test that we can edit only own article.
     *
     * @return void
     */
    public function testThatWeCanEditOnlyOwnArticle(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title',
            'description' => 'Description',
        ]);

        $response->assertStatus(201);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('PUT', '/api/v1/articles/1', [
            'title' => 'New title',
            'description' => 'New description',
        ]);

        $response->assertJson([
            'title' => 'New title',
            'description' => 'New description',
        ]);
    }

    /**
     * Test that we can't edit another's article.
     *
     * @return void
     */
    public function testThatWeCantEditAnothersArticle(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title',
            'description' => 'Description',
        ]);

        $response->assertStatus(201);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->generateBearerToken('test1@gmail.com')
        ])->json('PUT', '/api/v1/articles/1', [
            'title' => 'New title',
            'description' => 'New description',
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test that we can delete own article
     *
     * @return void
     */
    public function testThatWeCanDeleteOwnArticle()
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title',
            'description' => 'Description',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('DELETE', '/api/v1/articles/1');

        $response->assertStatus(204);
    }

    /**
     * Test that we can't delete another's article
     *
     * @return void
     */
    public function testThatWeCantDeleteAnothersArticle(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title',
            'description' => 'Description',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->generateBearerToken('test2@gmail.com')
        ])->json('DELETE', '/api/v1/articles/1');

        $response->assertStatus(403);
    }
}
