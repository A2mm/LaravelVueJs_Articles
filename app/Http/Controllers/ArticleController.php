<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    public function index()
    {
        // Get articles
        $articles = Article::orderBy('created_at', 'desc')->paginate(6);

        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
    }

    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');

        if($article->save()) {
            return new ArticleResource($article);
        }
        
    }

    public function show($id)
    {
        // Get article
        $article = Article::findOrFail($id);

        // Return single article as a resource
        return new ArticleResource($article);
    }

    public function destroy($id)
    {
        // Get article
        $article = Article::findOrFail($id);

        if($article->delete()) {
            return new ArticleResource($article);
        }    
    }
}