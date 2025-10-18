<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ValidationHelper;
use App\Http\Controllers\Controller;
use App\Models\CctvCategory;
use Illuminate\Http\Request;

class CctvCategoryController extends Controller
{
  function unit()
  {
    $units = \App\Models\CctvServiceUnit::orderBy("name", "ASC")->get();

    return response()->json([
      "status"  => true,
      "record"  => $units
    ]);
  }

  function index(Request $request)
  {
    $categories = \App\Models\CctvCategory::withCount("cctvs")->with(["serviceUnit"])->orderBy("name", "ASC")->get();

    return response()->json([
      "status"  => true,
      "record"  => $categories
    ]);
  }

  function show(Request $request, $id)
  {
    $category = CctvCategory::withCount("cctvs")->with(["serviceUnit"])->where("id", $id)->first();

    if (!$category) {
      return response()->json([
        "status"  => false,
        "message" => "Category not found"
      ], 404);
    }

    return response()->json([
      "status"  => true,
      "record"  => $category
    ]);
  }

  function form(Request $request, $id = null)
  {
    $validation = new ValidationHelper;
    $validation->setRules("name",           "Name",         "required|string|max:255");
    $validation->setRules("serviceUnitId",  "Service Unit", "required|exists:cctv_service_units,id");
    $validation->run();

    if ($validation->fails()) {
      return response()->json([
        "status" => false,
        "message" => null,
        "errors" => $validation->errors()
      ], 422);
    }

    $category = $id ? CctvCategory::find($id) : new CctvCategory;

    if ($id && !$category) {
      return response()->json([
        "status"  => false,
        "message" => "Category not found"
      ], 404);
    }

    $category->name           = $request->name;
    $category->serviceUnitId  = $request->serviceUnitId;
    $category->save();

    return response()->json([
      "status"  => true,
      "message" => $id ? "Category updated successfully" : "Category created successfully",
      "record"  => $category
    ]);
  }

  function delete(Request $request, $id)
  {
    $category = CctvCategory::find($id);

    if (!$category) {
      return response()->json([
        "status"  => false,
        "message" => "Category not found"
      ], 404);
    }

    $category->delete();

    return response()->json([
      "status"  => true,
      "message" => "Category deleted successfully"
    ]);
  }
}
