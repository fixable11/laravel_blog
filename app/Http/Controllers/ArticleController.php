<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\CreateArticleRequest as CreateArticleRequestAlias;
use App\Http\Requests\UpdateArticleRequest;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ArticleController.
 */
class ArticleController extends Controller
{
    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = Article::all();

        return response($articles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateArticleRequestAlias $request Request.
     *
     *
     * @return ResponseFactory|Response
     */
    public function store(CreateArticleRequestAlias $request)
    {
        /** @var Article $article */
        $article = auth()->user()->articles()->create($request->toArray());

        return response($article->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article Article.
     *
     * @return Response
     */
    public function show(Article $article)
    {
        return response($article->toArray(), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request Request.
     * @param Article              $article Article.
     *
     * @return Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ]);

        return response($article->toArray(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article Article.
     *
     * @return Response
     *
     * @throws Exception Exception.
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        return response([], 204);
    }
}
