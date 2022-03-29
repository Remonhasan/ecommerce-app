<?php

namespace App\Http\Controllers\admin\category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\admin\category\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $data = [];
        $data['allCategories'] = Category::all();
        return view('admin.category.list')->with($data);
    }
    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        $inputs = $request->all();
        Category::create($inputs);

        Toastr::success('Category Saved Successfully', 'Title', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }
}
