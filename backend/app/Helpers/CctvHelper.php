<?PHP

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CctvHelper
{
  private  $url = null;

  function __construct()
  {
    $this->url = env("CCTV_NODE_URL", "http://localhost:3333");
  }

  public function startCamera($id)
  {
    Log::info("Starting camera with ID: " . $id);
    Log::info("CCTV Node URL: " . $this->url . "/api/update-camera/play/{$id}");
    $response = Http::withHeaders([
      'Token' => env("NODE_TOKEN"),
    ])->get($this->url . "/api/update-camera/play/{$id}")->throw();
    return $response->json();
  }

  public function stopCamera($id)
  {
    Log::info("Stopping camera with ID: " . $id);
    Log::info("CCTV Node URL: " . $this->url . "/api/update-camera/stop/{$id}");
    $response = Http::withHeaders([
      'Token' => env("NODE_TOKEN"),
    ])->get($this->url . "/api/update-camera/stop/{$id}")->throw();
    return $response->json();
  }

  public function restartAllCctvs()
  {
    $response = Http::withHeaders([
      'Token' => env("NODE_TOKEN"),
    ])->get($this->url . "/api/camera/restart")->throw();
    return $response->json();
  }
}
