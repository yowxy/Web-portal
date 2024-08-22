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
            // ->take(1)
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

        return view('front.index', compact('bussiness_featured_articles','bussiness_articles','entertainment_featured_articles','entertainment_articles','categories','articles','authors',
        'featured_articles', 'bannerads',));
    }
}
