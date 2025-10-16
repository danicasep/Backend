<?PHP

namespace App\Modules\Helpers;

use App\Modules\Exceptions\PreventMultipleSubmitException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class PreventMultipleSubmit {
  
  /**
   * @var Request
   */
  protected $request;

  /**
   * @var string
   */
  protected $key;

  /**
   * @var int
   */
  protected $minutes;

  /**
   * @var int
   */
  protected $maxAttemps;

  /**
   * @var string
   */
  protected $joinKey;

  function __construct($request, string $key, int $maxAttemps, int $minutes)
  {
    $this->key        = $key;
    $this->request    = $request;
    $this->maxAttemps = $maxAttemps;
    $this->minutes    = $minutes;

    $this->joinKey    = $this->key . "-" . $this->request->ip();
  }

  function run() : bool
  {
    $isSuccess = RateLimiter::attempt($this->joinKey, $this->maxAttemps, function () {

    }, ($this->minutes * 60));

    if($isSuccess === FALSE) throw new PreventMultipleSubmitException("Max Attempt(s) is {$this->maxAttemps}");

    return $isSuccess;
  }

  function clear()
  {
    RateLimiter::clear($this->joinKey);
  }
}