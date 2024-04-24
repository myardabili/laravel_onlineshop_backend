<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = \App\Models\Category::paginate(5);
        return view('pages.category.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.category.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:100',
        ]);

        $category = \App\Models\Category::create($validate);

        return redirect()->route('category.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        return view('pages.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // $validate = $request->validate([
        //     'name' => 'required|max:100',
        // ]);

        // $category = \App\Models\Category::findOrFail($id);
        // $category->update($validate);

        // return redirect()->route('category.index')->with('success', 'Category updated successfully');

        // $category = \App\Models\Category::findOrFail($id);
        // if ($request->image) {
        //     $filename = time() . '' . $request->image->extension();
        //     $request->image->storeAs('public/categories', $filename);
        //     $category->image = $filename;
        // }

        // $category->update($request->all());

        // return redirect()->route('category.index')->with('success', 'Category updated successfully');
        $category = \App\Models\Category::findOrFail($id);

        if ($request->hasFile('image')) { // Periksa apakah file diunggah
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/categories', $filename);
            $category->image = $filename;
        }

        $category->update($request->all());

        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }
}
