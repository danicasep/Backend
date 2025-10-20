<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CctvHelper;
use App\Helpers\ValidationHelper;
use App\Http\Controllers\Controller;
use App\Models\Cctv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CctvController extends Controller
{
  function index(Request $request)
  {
    $cctvs = Cctv::with(["category"])->orderBy("name", "ASC")->paginate($request->get("perPage", 10), "*", "page", $request->get("page", 1));

    return response()->json([
      "status"  => true,
      "record"  => [
        "data"  => $cctvs->items(),
        "total" => $cctvs->total(),
      ]
    ]);
  }

  function show(Request $request, $id)
  {
    $cctv = Cctv::with(["category"])->where("id", $id)->first();

    if (!$cctv) {
      return response()->json([
        "status"  => false,
        "message" => "CCTV not found"
      ], 404);
    }

    return response()->json([
      "status"  => true,
      "record"  => $cctv
    ]);
  }

  function form(Request $request, $id = null)
  {
    $validation = new ValidationHelper;
    $validation->setRules("cctvCategoryId",     "Category",     "required|exists:cctv_categories,id");
    $validation->setRules("name",               "Name",         "required|string|max:255");
    $validation->setRules("description",        "Description",  "nullable|string|max:1000");
    $validation->setRules("rtspUrl",            "RTSP URL",     "required|string|max:1000");
    $validation->run();

    if ($validation->fails()) {
      return response()->json([
        "status"  => false,
        "message" => null,
        "errors"  => $validation->errors()
      ], 422);
    }

    $cctv = $id ? Cctv::find($id) : new Cctv;

    if ($id && !$cctv) {
      return response()->json([
        "status"  => false,
        "message" => "CCTV not found"
      ], 404);
    }

    $cctvHelper = new CctvHelper();

    try {
      DB::beginTransaction();

      $cctv->cctvCategoryId     = $request->cctvCategoryId;
      $cctv->name               = $request->name;
      $cctv->description        = $request->description;
      $cctv->rtspUrl            = $request->rtspUrl;
      $cctv->save();

      DB::commit();
      if ($id) $cctvHelper->stopCamera($id);
      $cctvHelper->startCamera($cctv->id);

      return response()->json([
        "status"  => true,
        "message" => $id ? "CCTV updated successfully" : "CCTV created successfully",
        "record"  => $cctv
      ]);
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        "status"  => false,
        "message" => "An error occurred: " . $th->getMessage()
      ], 500);
    }
  }

  function updateStatus(Request $request, $id)
  {
    $cctv = Cctv::find($id);

    if (!$cctv) {
      return response()->json([
        "status"  => false,
        "message" => "CCTV not found"
      ], 404);
    }

    $cctvHelper = new CctvHelper();

    if (!$cctv->isActive == true) {
      $cctvHelper->startCamera($id);
    } else {
      $cctvHelper->stopCamera($id);
    }

    $cctv->isActive = !$cctv->isActive;
    $cctv->save();

    return response()->json([
      "status"  => true,
      "message" => "CCTV status updated successfully",
      "record"  => $cctv
    ]);
  }

  function delete(Request $request, $id)
  {
    $cctv = Cctv::find($id);

    if (!$cctv) {
      return response()->json([
        "status"  => false,
        "message" => "CCTV not found"
      ], 404);
    }

    $cctvHelper = new CctvHelper();
    $cctvHelper->stopCamera($id);

    $cctv->delete();

    return response()->json([
      "status"  => true,
      "message" => "CCTV deleted successfully"
    ]);
  }

  function restartAllCctvs(Request $request)
  {
    $cctvHelper = new CctvHelper();
    $cctvHelper->restartAllCctvs();

    return response()->json([
      "status"  => true,
      "message" => "All CCTV streams have been restarted successfully"
    ]);
  }
}
