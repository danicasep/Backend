<?php

namespace Database\Seeders;

use App\Models\CctvServiceUnit;
use Illuminate\Database\Seeder;

class CctvUnitSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    CctvServiceUnit::insert([
      ["name" => "Terminal",  "description" => "CCTV di Terminal",  "createdAt" => now(), "updatedAt" => now()],
      ["name" => "UPPKB",     "description" => "CCTV di UPPKB",     "createdAt" => now(), "updatedAt" => now()],
      ["name" => "Pelabuhan", "description" => "CCTV di Pelabuhan", "createdAt" => now(), "updatedAt" => now()],
    ]);
  }
}
