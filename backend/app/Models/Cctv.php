<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cctv extends Model
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
  protected $table = "cctv";

  protected $guarded = [];

  public function category()
  {
    return $this->belongsTo(CctvCategory::class, "cctvCategoryId", "id");
  }
}
