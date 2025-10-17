<?php

namespace Database\Seeders;

use App\Models\Cctv;
use App\Models\CctvCategory;
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
        "name" => "Terminal Harjamukti Cirebon",
        "cctvs" => [
          [
            "name" => "Area Tunggu Penumpang",
            "rtspUrl" => "rtsp://agus:ABC123def@141.11.241.126:554/unicast/c7/s0/live",
            "description" => "CCTV yang mengawasi area tunggu penumpang di Terminal Harjamukti Cirebon."
          ],
          [
            "name" => "Area Keberangkatan",
            "rtspUrl" => "rtsp://agus:ABC123def@141.11.241.126:554/unicast/c9/s0/live",
            "description" => "CCTV yang mengawasi area keberangkatan di Terminal Harjamukti Cirebon."
          ],
          [
            "name" => "Area Parkir",
            "rtspUrl" => "rtsp://agus:ABC123def@141.11.241.126:554/unicast/c10/s0/live",
            "description" => "CCTV yang mengawasi area parkir di Terminal Harjamukti Cirebon."
          ],
          [
            "name" => "Area Kedatangan",
            "rtspUrl" => "rtsp://agus:ABC123def@141.11.241.126:554/unicast/c11/s0/live",
            "description" => "CCTV yang mengawasi area kedatangan di Terminal Harjamukti Cirebon."
          ],
          [
            "name" => "Area Parkir BUS",
            "rtspUrl" => "rtsp://agus:ABC123def@141.11.241.126:554/unicast/c12/s0/live",
            "description" => "CCTV yang mengawasi area parkir bus di Terminal Harjamukti Cirebon."
          ]
        ]
      ],
      [
        "name" => "Terminal Ciakar Sumedang",
        "cctvs" => [
          [
            "name" => "Area Keberangkatan",
            "rtspUrl" => "rtsp://admin:ciakar125@141.11.241.128:554/cam/realmonitor?channel=10&subtype=0",
            "description" => "CCTV yang mengawasi area keberangkatan di Terminal Ciakar Sumedang."
          ],
          [
            "name" => "Area Kedatangan",
            "rtspUrl" => "rtsp://admin:ciakar125@141.11.241.128:554/cam/realmonitor?channel=13&subtype=0",
            "description" => "CCTV yang mengawasi area kedatangan di Terminal Ciakar Sumedang."
          ],
          [
            "name" => "Area Tunggu Penumpang",
            "rtspUrl" => "rtsp://admin:ciakar125@141.11.241.128:554/cam/realmonitor?channel=6&subtype=0",
            "description" => "CCTV yang mengawasi area tunggu penumpang di Terminal Ciakar Sumedang."
          ],
          [
            "name" => "Masuk BIS",
            "rtspUrl" => "rtsp://setting:setting123@141.11.241.125:554/cam/realmonitor?channel=1&subtype=1",
            "description" => "CCTV yang mengawasi area masuk bis di Terminal Ciakar Sumedang."
          ]
        ]
      ],
      [
        "name" => "Terminal Leuwipanjang",
        "cctvs" => [
          [
            "name" => "Powerhouse",
            "rtspUrl" => "rtsp://setting:setting123@141.11.241.125:554/cam/realmonitor?channel=2&subtype=1",
            "description" => "CCTV yang mengawasi area powerhouse di Terminal Leuwipanjang."
          ],
          [
            "name" => "Sky Bridge 1",
            "rtspUrl" => "rtsp://setting:setting123@141.11.241.125:554/cam/realmonitor?channel=4&subtype=1",
            "description" => "CCTV yang mengawasi sky bridge 1 di Terminal Leuwipanjang."
          ],
          [
            "name" => "Sky Bridge 2",
            "rtspUrl" => "rtsp://setting:setting123@141.11.241.125:554/cam/realmonitor?channel=5&subtype=1",
            "description" => "CCTV yang mengawasi sky bridge 2 di Terminal Leuwipanjang."
          ]
        ]
      ],
      [
        "name" => "Terminal Sukabumi",
        "cctvs" => [
          [
            "name" => "Area Pengeteman",
            "rtspUrl" => "rtsp://admin:sukabumi:sukabumi123@141.11.241.6:554/cam/realmonitor?channel=1&subtype=0",
            "description" => "CCTV yang mengawasi area pengeteman di Terminal Sukabumi."
          ],
          [
            "name" => "Area Pintu Masuk Kendaraan",
            "rtspUrl" => "rtsp://admin:sukabumi:sukabumi123@141.11.241.6:554/cam/realmonitor?channel=2&subtype=0",
            "description" => "CCTV yang mengawasi area pintu masuk kendaraan di Terminal Sukabumi."
          ],
          [
            "name" => "Area Parkir Motor",
            "rtspUrl" => "rtsp://admin:sukabumi:sukabumi123@141.11.241.6:554/cam/realmonitor?channel=3&subtype=0",
            "description" => "CCTV yang mengawasi area parkir motor di Terminal Sukabumi."
          ],
          [
            "name" => "Area Pintu Keluar",
            "rtspUrl" => "rtsp://admin:sukabumi:sukabumi123@141.11.241.6:554/cam/realmonitor?channel=6&subtype=0",
            "description" => "CCTV yang mengawasi area pintu keluar di Terminal Sukabumi."
          ],
          [
            "name" => "Area Keberangkatan",
            "rtspUrl" => "rtsp://guntur:garut2025@45.158.10.108 :554/cam/realmonitor?channel=9&subtype=1",
            "description" => "CCTV yang mengawasi area keberangkatan di Terminal Sukabumi."
          ]
        ]
      ],
      [
        "name" => "Terminal Guntur Garut",
        "cctvs" => [
          [
            "name" => "Area Drop Off 1",
            "rtspUrl" => "rtsp://guntur:garut2025@45.158.10.108 :554/cam/realmonitor?channel=2&subtype=1",
            "description" => "CCTV yang mengawasi area drop off 1 di Terminal Guntur Garut."
          ],
          [
            "name" => "Area Tunggu Penumpang",
            "rtspUrl" => "rtsp://guntur:garut2025@45.158.10.108 :554/cam/realmonitor?channel=5&subtype=0",
            "description" => "CCTV yang mengawasi area tunggu penumpang di Terminal Guntur Garut."
          ],
          [
            "name" => "Area Parkir",
            "rtspUrl" => "rtsp://guntur:garut2025@45.158.10.108 :554/cam/realmonitor?channel=6&subtype=1",
            "description" => "CCTV yang mengawasi area parkir di Terminal Guntur Garut."
          ],
          [
            "name" => "Area Keberangkatan",
            "rtspUrl" => "rtsp://guntur:garut2025@45.158.10.108 :554/cam/realmonitor?channel=8&subtype=1",
            "description" => "CCTV yang mengawasi area keberangkatan di Terminal Guntur Garut."
          ]
        ]
      ],
      [
        "name" => "Terminal Banjar",
        "cctvs" => [
          [
            "name" => "Area Drop Off",
            "rtspUrl" => "rtsp://admin:Ttabanjar1@45.158.10.107:558/LiveChannel/01/media.smp",
            "description" => "CCTV yang mengawasi area drop off di Terminal Banjar."
          ],
          [
            "name" => "Area Kedatangan",
            "rtspUrl" => "rtsp://admin:Ttabanjar1@45.158.10.107:558/LiveChannel/04/media.smp",
            "description" => "CCTV yang mengawasi area kedatangan di Terminal Banjar."
          ],
          [
            "name" => "Area Keberangkatan",
            "rtspUrl" => "rtsp://admin:Ttabanjar1@45.158.10.107:558/LiveChannel/09/media.smp",
            "description" => "CCTV yang mengawasi area keberangkatan di Terminal Banjar."
          ],
          [
            "name" => "Area Tunggu Penumpang",
            "rtspUrl" => "rtsp://admin:Ttabanjar1@45.158.10.107:558/LiveChannel/09/media.smp",
            "description" => "CCTV yang mengawasi area tunggu penumpang di Terminal Banjar."
          ],
          [
            "name" => "Area Parkir Kendaraan",
            "rtspUrl" => "rtsp://admin:Ttabanjar1@45.158.10.107:558/LiveChannel/10/media.smp",
            "description" => "CCTV yang mengawasi area parkir kendaraan di Terminal Banjar."
          ]
        ]
      ],
      [
        "name" => "Terminal Subang",
        "cctvs" => [
          [
            "name" => "Area Keberangkatan",
            "rtspUrl" => "rtsp://admin:subang_99@141.11.241.130:554/Streaming/Channels/101",
            "description" => "CCTV yang mengawasi area keberangkatan di Terminal Subang."
          ],
          [
            "name" => "Area Parkir",
            "rtspUrl" => "rtsp://admin:subang_99@141.11.241.130:554/Streaming/Channels/301",
            "description" => "CCTV yang mengawasi area parkir di Terminal Subang."
          ],
          [
            "name" => "Ruang Tunggu Penumpang",
            "rtspUrl" => "rtsp://admin:subang_99@141.11.241.130:554/Streaming/Channels/401",
            "description" => "CCTV yang mengawasi ruang tunggu penumpang di Terminal Subang."
          ],
          [
            "name" => "Gerbang Masuk",
            "rtspUrl" => "rtsp://admin:subang_99@141.11.241.130:554/Streaming/Channels/501",
            "description" => "CCTV yang mengawasi gerbang masuk di Terminal Subang."
          ],
          [
            "name" => "Gerbang Keluar",
            "rtspUrl" => "rtsp://admin:subang_99@141.11.241.130:554/Streaming/Channels/701",
            "description" => "CCTV yang mengawasi gerbang keluar di Terminal Subang."
          ]
        ]
      ],
      [
        "name" => "Terminal Indihiang Tasik",
        "cctvs" => [
          [
            "name" => "Area Keberangkatan",
            "rtspUrl" => "rtsp://admin:bandung123@45.158.10.106:554/cam/realmonitor?channel=2&subtype=0",
            "description" => "CCTV yang mengawasi area keberangkatan di Terminal Indihiang Tasik."
          ],
          [
            "name" => "Area Kedatangan",
            "rtspUrl" => "rtsp://admin:bandung123@45.158.10.106:554/cam/realmonitor?channel=3&subtype=0",
            "description" => "CCTV yang mengawasi area kedatangan di Terminal Indihiang Tasik."
          ],
          [
            "name" => "Area Parkir BUS",
            "rtspUrl" => "rtsp://admin:bandung123@45.158.10.106:554/cam/realmonitor?channel=4&subtype=0",
            "description" => "CCTV yang mengawasi area parkir bus di Terminal Indihiang Tasik."
          ],
          [
            "name" => "Area Tunggu Penumpang",
            "rtspUrl" => "rtsp://admin:bandung123@45.158.10.106:554/cam/realmonitor?channel=5&subtype=0",
            "description" => "CCTV yang mengawasi area tunggu penumpang di Terminal Indihiang Tasik."
          ],
          [
            "name" => "Area Parkir",
            "rtspUrl" => "rtsp://admin:bandung123@45.158.10.106:554/cam/realmonitor?channel=7&subtype=0",
            "description" => "CCTV yang mengawasi area parkir di Terminal Indihiang Tasik."
          ]
        ]
      ],
      [
        "name" => "Terminal Kuningan",
        "cctvs" => [
          [
            "name" => "Jalur Masuk 1",
            "rtspUrl" => "rtsp://admin:kuningan2025@45.158.10.112:554/Streaming/Channels/1101",
            "description" => "CCTV yang mengawasi jalur masuk 1 di Terminal Kuningan."
          ],
          [
            "name" => "Gerbang Masuk 2",
            "rtspUrl" => "rtsp://admin:kuningan2025@45.158.10.112:554/Streaming/Channels/101",
            "description" => "CCTV yang mengawasi gerbang masuk 2 di Terminal Kuningan."
          ],
          [
            "name" => "Area Penumpang 1",
            "rtspUrl" => "rtsp://admin:kuningan2025@45.158.10.112:554/Streaming/Channels/1001",
            "description" => "CCTV yang mengawasi area penumpang 1 di Terminal Kuningan."
          ],
          [
            "name" => "Jalur Keluar 1",
            "rtspUrl" => "rtsp://admin:kuningan2025@45.158.10.112:554/Streaming/Channels/1401",
            "description" => "CCTV yang mengawasi jalur keluar 1 di Terminal Kuningan."
          ],
          [
            "name" => "Pintu Masuk Kendaraan",
            "rtspUrl" => "rtsp://klari:tpkjabar2025@45.158.10.123:554/Streaming/Channels/301",
            "description" => "CCTV yang mengawasi pintu masuk kendaraan di Terminal Kuningan."
          ],
          [
            "name" => "Pintu Keluar Kendaraan",
            "rtspUrl" => "rtsp://klari:tpkjabar2025@45.158.10.123:554/Streaming/Channels/701",
            "description" => "CCTV yang mengawasi pintu keluar kendaraan di Terminal Kuningan."
          ]
        ]
      ],
      [
        "name" => "Terminal Klari",
        "cctvs" => [
          [
            "name" => "Lintasan 1",
            "rtspUrl" => "rtsp://klari:tpkjabar2025@45.158.10.123:554/Streaming/Channels/901",
            "description" => "CCTV yang mengawasi lintasan 1 di Terminal Klari."
          ],
          [
            "name" => "Ruang Tunggu 1",
            "rtspUrl" => "rtsp://klari:tpkjabar2025@45.158.10.123:554/Streaming/Channels/901",
            "description" => "CCTV yang mengawasi ruang tunggu 1 di Terminal Klari."
          ]
        ]
      ]
    ];

    foreach ($categories as $dataCategory) {
      $createData = [
        "name" => $dataCategory["name"]
      ];
      $category = CctvCategory::create($createData);

      $insertCctvs = [];

      foreach ($dataCategory["cctvs"] as $cctv) {
        $insertCctvs[] = [
          "name"            => $cctv["name"],
          "rtspUrl"         => $cctv["rtspUrl"],
          "isActive"        => true,
          "description"     => $cctv["description"],
          "cctvCategoryId"  => $category->id,
          "updatedAt"       => now(),
          "createdAt"       => now()
        ];
      }

      Cctv::insert($insertCctvs);
    }
  }
}
