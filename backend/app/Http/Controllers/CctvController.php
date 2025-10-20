<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Cctv;
use App\Models\CctvCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    $cctv = Cctv::with(["category.serviceUnit"])->where("isActive", true)->where("id", $id)->first();

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

  function detailPagination(Request $request, $id)
  {
    if (!GeneralHelper::isValidInteger($id)) {
      return response()->json([
        "status"  => false,
        "message" => "Invalid CCTV ID"
      ], 400);
    }

    $cctv = DB::selectOne(<<<EOF
      SELECT(
        SELECT c2.id FROM cctv AS c2
        WHERE c2.isActive = 1 AND c2.id < c1.id
        AND c1.cctvCategoryId = c2.cctvCategoryId
        ORDER BY c2.id DESC
        LIMIT 1
      ) as previousId,
      c1.id as currentId,
      (
        SELECT c3.id FROM cctv AS c3
        WHERE c3.isActive = 1 AND c3.id > c1.id
        AND c1.cctvCategoryId = c3.cctvCategoryId
        ORDER BY c3.id ASC
        LIMIT 1
      ) as nextId
      FROM cctv c1
      WHERE c1.id = ? AND c1.isActive = 1
    EOF, [$id]);

    return response()->json([
      "status"  => true,
      "record"  => $cctv
    ]);
  }
}
