<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

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
  /**
   * The attributes that should be hidden for serialization.
   *
   * @var list<string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function setPasswordAttribute($value)
  {
    if (!empty($value)) {
      $this->attributes['password']     = Hash::make($value);
      $this->attributes['tmpPassword'] = Crypt::encrypt($value);
    }
  }
}
