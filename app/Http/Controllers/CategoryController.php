<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Validator;



class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('categories');
        return $categories->get();
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:categories|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
            ]);
        } else {
            Category::create($request->all());
            return response()->json([
                "success" => true,
            ]);
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:categories|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "req" => $request->all(),
            ]);
        } else {
            Category::where('id', $request->id)->update($request->all());

            return response()->json([
                "success" => true,
                "req" => $request->all(),
            ]);
        }
    }
    public function destroy(Request $request)
    {
        $category = Category::where('id', $request->id)->delete();
        if (!Category::where('id', $request->id)->exists()) {
            return response()->json([
                "success" => true,
                "id" => $request->id,
            ]);
        }
    }
}
