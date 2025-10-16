<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CctvCategory extends Model
{
  use SoftDeletes;

  protected $table = "cctv_categories";

  protected $guarded = [];

  function cctvs()
  {
    return $this->hasMany(Cctv::class, "cctvCategoryId", "id");
  }
}
