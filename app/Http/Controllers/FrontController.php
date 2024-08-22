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


        $authors = Author::all();

        return view('front.index', compact('categories','articles','authors', 'featured_articles', 'bannerads'));
    }
}
