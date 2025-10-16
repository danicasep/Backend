<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $users = [
      [
        "name"         => "Admin",
        "username"     => "admin",
        "email"        => "",
        "password"     => Hash::make("admin123"),
        "tmpPassword"  => encrypt("admin123"),
        "isActive"     => true,
        "createdAt"   => now(),
        "updatedAt"   => now(),
      ],
      [
        "name"         => "tamVan",
        "username"     => "tamvan",
        "email"        => "",
        "password"     => Hash::make("admin123"),
        "tmpPassword"  => encrypt("admin123"),
        "isActive"     => true,
        "createdAt"   => now(),
        "updatedAt"   => now(),
      ],
      [
        "name"         => "Admin2",
        "username"     => "admin2",
        "email"        => "",
        "password"     => Hash::make("admin123"),
        "tmpPassword"  => encrypt("admin123"),
        "isActive"     => true,
        "createdAt"   => now(),
        "updatedAt"   => now(),
      ]
    ];

    User::insert($users);
  }
}
