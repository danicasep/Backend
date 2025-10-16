<?PHP

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class CompressImage {
  
  /**
   * @var string
   */
  protected $fileImage;

  /**
   * @var double
   */
  protected $maxSizeInKB;

  /**
   * @var string
   */
  public $fileName;

  function __construct(string $fileImage, $maxSizeInKB = 200)
  {
    $this->fileImage   = $fileImage;
    $this->maxSizeInKB = $maxSizeInKB / 1000;
  }

  function run()
  {
    $fileSize = File::size(public_path($this->fileImage));
    
    $explode = explode("/", $this->fileImage);

    $this->fileName = end($explode);

    if(($fileSize / 1000) >= $this->maxSizeInKB) {

      $image = Image::read(public_path($this->fileImage));

      $image->scale(width: 1000, height: null)
            ->save(public_path($this->fileImage));
    }
  }
}