<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function home()
    {
        $products = Product::with('category')->latest()->take(8)->get();

        return view('home', compact('products'));
    }

    public function index(Request $request)
    {
        $query = Product::with('category')->latest();
        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhereHas('category', function ($builder) use ($keyword) {
                    $builder->where('name', 'like', "%{$keyword}%");
                });
        }

        $products = $query->paginate(12)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
