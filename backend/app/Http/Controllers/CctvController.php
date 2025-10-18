<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use App\Models\CctvCategory;
use Illuminate\Http\Request;

class CctvController extends Controller
{
  function category(Request $request, $unitId)
  {
    $categories = CctvCategory::where("serviceUnitId", $unitId)->orderBy("name", "ASC")->get();

    return response()->json([
      "status"  => true,
      "record"  => $categories
    ]);
  }

  function index(Request $request, $categoryId)
  {
    $cctv = Cctv::with(["category"])->where("isActive", true)->where("cctvCategoryId", $categoryId);

    $cctv = $cctv->orderBy("name", "ASC")->get();

    return response()->json([
      "status"  => true,
      "record"  => $cctv->map(function ($item) {
        unset($item->rtspUrl);
        return $item;
      })
    ]);
  }

  function show(Request $request, $id = null)
  {
    $cctv = Cctv::with(["category"])->where("isActive", true);

    if ($id) {
      $cctv = $cctv->where("id", $id);
    }

    $cctv = $cctv->first();

    if (!$cctv) {
      return response()->json([
        "status"  => false,
        "message" => "CCTV not found"
      ], 404);
    }

    unset($cctv->rtspUrl);
    return response()->json([
      "status"  => true,
      "record"  => $cctv
    ]);
  }
}
