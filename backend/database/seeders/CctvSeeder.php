<?php

namespace Database\Seeders;

use App\Models\Cctv;
use App\Models\CctvCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CctvSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      [
        'name'        => 'Outdoor',
        'createdAt'  => now(),
        'updatedAt'  => now(),
      ],
      [
        'name'        => 'Indoor',
        'createdAt'  => now(),
        'updatedAt'  => now(),
      ],
      [
        'name'        => 'Parking Lot',
        'createdAt'  => now(),
        'updatedAt'  => now(),
      ],
      [
        'name'        => 'Lobby',
        'createdAt'  => now(),
        'updatedAt'  => now(),
      ],
    ];

    CctvCategory::insert($categories);
    /**
     * rtsp://adminkemang:kemang123@141.11.241.9:554/cam/realmonitor?channel=7&subtype=0
     * rtsp://adminkemang:kemang123@141.11.241.9:554/cam/realmonitor?channel=1&subtype=0
     * rtsp://adminkemang:kemang123@141.11.241.9:554/cam/realmonitor?channel=6&subtype=0
     * rtsp://adminkemang:kemang123@141.11.241.9:554/cam/realmonitor?channel=3&subtype=0
     */
    $cctvs = [
      [
        'name'            => 'CCTV 1',
        'description'     => 'Entrance',
        'rtspUrl'         => 'rtsp://adminkemang:kemang123@141.11.241.9:554/cam/realmonitor?channel=7&subtype=0',
        "cctvCategoryId"  => 1,
        'isActive'        => true,
        'createdAt'      => now(),
        'updatedAt'      => now(),
      ],
      [
        'name'            => 'CCTV 2',
        'description'     => 'Entrance',
        'rtspUrl'         => 'rtsp://adminkemang:kemang123@141.11.241.9:554/cam/realmonitor?channel=1&subtype=0',
        "cctvCategoryId"  => 1,
        'isActive'        => true,
        'createdAt'      => now(),
        'updatedAt'      => now(),
      ],
      [
        'name'            => 'CCTV 3',
        'description'     => 'Entrance',
        'rtspUrl'         => 'rtsp://adminkemang:kemang123@141.11.241.9:554/cam/realmonitor?channel=6&subtype=0',
        "cctvCategoryId"  => 2,
        'isActive'        => true,
        'createdAt'      => now(),
        'updatedAt'      => now(),
      ],
      [
        'name'            => 'CCTV 4',
        'description'     => 'Entrance',
        'rtspUrl'         => 'rtsp://adminkemang:kemang123@141.11.241.9:554/cam/realmonitor?channel=3&subtype=0',
        "cctvCategoryId"  => 2,
        'isActive'        => true,
        'createdAt'      => now(),
        'updatedAt'      => now(),
      ],
    ];

    Cctv::insert($cctvs);
  }
}
