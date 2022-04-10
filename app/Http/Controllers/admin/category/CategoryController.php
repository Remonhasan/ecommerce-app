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

        $itemsPerPage = itemsPerPage();

        $categoryModel = new Category();
        $data['categoryModel'] = $categoryModel;

        $args = array(
            'items_per_page' => $itemsPerPage,
            'paginate'       => true
        );

        // Push Filter/Search Parameters.
        $args = filterParams(
            $args,
            array(
                'name'        => 'name',
                'is_active'   => 'is_active',
            )
        );

        $data['allCategories'] = $categoryModel->getCategories($args);

        return view('admin.category.list', compact('itemsPerPage'))->with($data);
    }

    public function create()
    {
        return view('admin.category.create');
    }
    public function store(Request $request)
    {
        $inputs = $request->all();
        Category::create($inputs);

        Toastr::success('Category Saved Successfully', 'Ecommerce', ["positionClass" => "toast-top-center"]);
        return redirect()->back();
    }
}
