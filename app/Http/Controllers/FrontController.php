<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;
use App\Models\Author;
use App\Models\BannerAdvertisement;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index() {
        $categories = Category::all();
        $articles = ArticleNews::with(['category'])
            ->where('is_featured','not_featured')
            ->latest()
            ->take(3)
            ->get();


        $featured_articles = ArticleNews::with(['category'])
            ->where('is_featured','featured')
            ->inRandomOrder()
            ->latest()
            ->take(3)
            ->get();


        $bannerads = BannerAdvertisement::where('is_active','active')
        ->where('type','banner')
            ->inRandomOrder()
            ->first();


            $entertainment_articles = ArticleNews::whereHas('category', function ($query) {
                $query->where('name', 'Entertainment');
            })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();


            $bussiness_articles = ArticleNews::whereHas('category', function ($query) {
                $query->where('name', 'Bussiness');
            })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();


            $automotive_articles = ArticleNews::whereHas('category', function ($query) {
                $query->where('name','Automotive');
            })

            ->where('is_featured','not_featured')
            ->latest()
            ->take(6)
            ->get();


            $automotive_featured_articles = ArticleNews::whereHas('category', function($query){
                $query->where('name', 'Automotive');
            })

            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();


            $bussiness_featured_articles = ArticleNews::whereHas('category', function ($query) {
                $query->where('name', 'Bussiness');
            })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();


            $entertainment_featured_articles = ArticleNews::whereHas('category', function ($query) {
                $query->where('name', 'Entertainment');
            })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();


        $authors = Author::all();

        return view('front.index', compact('automotive_featured_articles','automotive_articles','bussiness_featured_articles','bussiness_articles','entertainment_featured_articles','entertainment_articles','categories','articles','authors',
        'featured_articles', 'bannerads',));
    }


    public function  category (Category $category){
        $categories = Category::all();
        $bannerads = BannerAdvertisement::where('is_active','active')
        ->where('type','banner')
            ->inRandomOrder()
            ->first();
        return view('front.category', compact('category','categories','bannerads'));
    }


    public function author (Author $author){
        $categories = Category::all();
        $bannerads = BannerAdvertisement::where('is_active','active')
        ->where('type','banner')
            ->inRandomOrder()
            ->first();
        return view('front.author', compact('categories','author','bannerads'));
    }

    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'keyword' => ['required', 'string', 'max:255'],
        ]);

        $categories = Category::all();

        $keyword = $validatedData['keyword'];

        $articles = ArticleNews::with(['category', 'author'])
            ->where('name', 'like', '%' . $keyword . '%')->paginate(6);

        return view('front.search', compact('categories', 'keyword', 'articles'));
    }

    public function details(ArticleNews $articleNews){
        return view ('front.details',compact('articleNews'));
    }

}
