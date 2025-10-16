<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cctv extends Model
{
  use SoftDeletes;

  protected $table = "cctv";

  protected $guarded = [];

  public function category()
  {
    return $this->belongsTo(CctvCategory::class, "cctvCategoryId", "id");
  }
}
