<?php

namespace App\Http\Controllers\admin\category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\admin\category\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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

    public function edit($categoryId)
    {
        $category  = Category::findOrFail($categoryId);
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request HTTP Request.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $inputs = $request->all();
            // Validate.
            $rules = array(
                'name_en'     => 'required|max:255'
            );

            $validator = Validator::make($inputs, $rules);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput($request->all);
            } else {
                // Starting database transaction.
                DB::beginTransaction();
                
                $category = Category::findorfail($inputs['id']);
                $category->update($inputs);

                // CACHE: Clear the FrontEnd Dashboard usage.
                Cache::forget("district_front_{$category->id}");

                // Commit all transactions.
                DB::commit();

                Toastr::success('Category Updated Successfully', 'Ecommerce', ["positionClass" => "toast-top-center"]);

                return back();
            }
        } catch (\Exception $e) {
            // Rollback all transaction if error occurred.
            DB::rollBack();

            return back()
                ->withErrors($e->getMessage())
                ->withInput($request->all);
        }
    }

}
