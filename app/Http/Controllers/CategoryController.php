<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $query = Product::query();

        if ($slug === 'solar-panels') {
            $query->where('name', 'LIKE', '%solar%')
                  ->orWhere('name', 'LIKE', '%panel%');
        }

        elseif ($slug === 'inverters') {
            $query->where('name', 'LIKE', '%inverter%');
        }

        elseif ($slug === 'batteries') {
            $query->where('name', 'LIKE', '%battery%');
        }

        elseif ($slug === 'iot') {
            $query->where('name', 'LIKE', '%iot%')
                  ->orWhere('name', 'LIKE', '%smart%');
        }

        elseif ($slug === 'smart-home') {
            $query->where('name', 'LIKE', '%smart%')
                  ->orWhere('name', 'LIKE', '%home%');
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        return view('category.show', compact('products', 'slug'));
    }
}