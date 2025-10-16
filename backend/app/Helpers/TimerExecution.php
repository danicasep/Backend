<?PHP

namespace App\Helpers;

class TimerExecution {
  protected $startTime = 0;

  function start()
  {
    $this->startTime = microtime(true);
    return $this;
  }

  function calculated()
  {
    $endTime = microtime(true);
    
    $duration = $endTime - $this->startTime;
    $hours = (int)($duration/60/60);
    $minutes = (int)($duration/60)-$hours*60;
    $seconds = $duration-$hours*60*60-$minutes*60;
    return (float) number_format((float)$seconds, 4, '.', '');
  }

}