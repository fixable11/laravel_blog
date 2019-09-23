<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class CommentController.
 */
class CommentController extends Controller
{
    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Fetch all relevant replies.
     *
     * @param Article $article Article.
     *
     * @return mixed
     */
    public function index(Article $article)
    {
        return response($article->comments->toArray(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCommentRequest $request Request.
     * @param Article              $article Article.
     *
     * @return ResponseFactory|Response
     */
    public function store(CreateCommentRequest $request, Article $article)
    {
        /** @var Article $article */
        $article = $article->comments()->create($request->merge(['user_id' => auth()->id()])->toArray());

        return response($article->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article Article.
     * @param Comment $comment Comment to the article.
     *
     * @return Response
     */
    public function show(Article $article, Comment $comment)
    {
        return response($comment->toArray(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest $request Request.
     * @param Article              $article Article.
     * @param Comment              $comment Comment to the article.
     *
     * @return Response
     */
    public function update(UpdateCommentRequest $request, Article $article, Comment $comment)
    {
        $comment->update($request->toArray());

        return response($comment->toArray(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article Article.
     * @param Comment $comment Comment.
     *
     * @return Response
     *
     * @throws Exception Exception.
     */
    public function destroy(Article $article, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response([], 204);
    }
}
