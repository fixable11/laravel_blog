<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class CommentTest.
 */
class CommentTest extends TestCase
{
    use RefreshDatabase, GenerateBearerTokenTrait;

    /**
     * @var string $token Jwt token.
     */
    private $token;

    /**
     * Setting up fixtures.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->token = $this->generateBearerToken();

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles', [
            'title' => 'Title',
            'description' => 'Description',
        ]);
    }

    /**
     * Test that we can add comment to the article.
     *
     * @return void
     */
    public function testThatWeCanAddCommentToTheArticle(): void
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles/1/comments', [
            'description' => 'Comment description',
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'description' => 'Comment description',
                'id' => 1,
            ]);
    }

    /**
     * Test that we can get all article's comments.
     *
     * @return void
     */
    public function testThatWeCanGetAllArticlesComments(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles/1/comments', [
            'description' => 'Comment description1',
        ]);

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles/1/comments', [
            'description' => 'Comment description2',
        ]);

        $response = $this->json('GET', '/api/v1/articles/1/comments');

        $response
            ->assertStatus(200)
            ->assertJsonCount(2);
    }

    /**
     * Test that we can get specific comment.
     *
     * @return void.
     */
    public function testThatWeCanGetSpecificComment(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles/1/comments', [
            'description' => 'Comment description1',
        ]);

        $response = $this->json('GET', '/api/v1/articles/1/comments/1');

        $response
            ->assertStatus(200)
            ->assertJson([
                'description' => 'Comment description1'
            ]);
    }

    /**
     * Test that we can edit only own comment.
     *
     * @return void
     */
    public function testThatWeCanEditOnlyOwnComment(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles/1/comments', [
            'description' => 'Comment description',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('PUT', '/api/v1/articles/1/comments/1', [
            'description' => 'New comment description',
        ]);

        $response->assertJson([
            'description' => 'New comment description',
        ]);
    }

    /**
     * Test that we can't edit only another's comment.
     *
     * @return void
     */
    public function testThatWeCantEditAnothersComments(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles/1/comments', [
            'description' => 'Comment description',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->generateBearerToken('test1@gmail.com')
        ])->json('PUT', '/api/v1/articles/1/comments/1', [
            'description' => 'New comment description',
        ]);

        $response->assertStatus(403);
    }

    /**
     * Test that we can delete own comments.
     *
     * @return void
     */
    public function testThatWeCanDeleteOwnComments(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles/1/comments', [
            'description' => 'Comment description',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('DELETE', '/api/v1/articles/1/comments/1');

        $response->assertStatus(204);
    }

    /**
     * Test that we can't delete another's comments.
     *
     * @return void
     */
    public function testThatWeCantDeleteAnothersComments(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token
        ])->json('POST', '/api/v1/articles/1/comments', [
            'description' => 'Comment description',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->generateBearerToken('test1@gmail.com')
        ])->json('DELETE', '/api/v1/articles/1/comments/1');

        $response->assertStatus(403);
    }
}
