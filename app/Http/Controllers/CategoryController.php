<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = \App\Models\Category::paginate(5);
        return view('pages.category.index', compact('categories'));
    }
}