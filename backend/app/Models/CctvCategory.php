<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CctvCategory extends Model
{
  use SoftDeletes;
  /**
   * The name of the "created at" column.
   *
   * @var string|null
   */
  const CREATED_AT = 'createdAt';

  /**
   * The name of the "updated at" column.
   *
   * @var string|null
   */
  const UPDATED_AT = 'updatedAt';
  protected $table = "cctv_categories";

  protected $guarded = [];

  function cctvs()
  {
    return $this->hasMany(Cctv::class, "cctvCategoryId", "id");
  }
}
