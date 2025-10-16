<?PHP
namespace App\Helpers;

use DateTime;

class FormatDate 
{
    protected $date;

    protected $result;

    public $days        = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

    public $shortDays   = [ "Min", "Sen", "Sel", "Rab", "kam", "Jum", "Sab"];

    public $months      = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    public $shortMonths = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];

    function __construct($date, $format = "l, Y-m-d H:i:s")
    {
        $newDate    = [];
        
        $time       = strtotime($date);

        if(strpos($format, "l") !== FALSE) 
        {
            $newDate['l']   = date('w', $time);
            $format         = str_replace("l", "{1}", $format);
        }

        if(strpos($format, "D") !== FALSE)
        {
            $newDate['D']   = date('w', $time);
            $format         = str_replace("D", "{2}", $format);
        }

        if(strpos($format, "F") !== FALSE)
        {
            $newDate['F']   = date('n', $time) - 1;
            $format         = str_replace("F", "{3}", $format);
        }

        if(strpos($format, "M") !== FALSE)
        {
            $newDate['M']   = date('n', $time) - 1;
            $format         = str_replace("M", "{4}", $format);
        }

        $dateTime = new DateTime();

        $this->date = $dateTime->setTimestamp($time);

        $newFormat = $this->date->format($format);
        
        if(isset($newDate['l'])) $newFormat = str_replace('{1}', $this->days[$newDate['l']], $newFormat);
        if(isset($newDate['D'])) $newFormat = str_replace('{2}', $this->shortDays[$newDate['D']], $newFormat);
        if(isset($newDate['F'])) $newFormat = str_replace('{3}', $this->months[$newDate['F']], $newFormat);
        if(isset($newDate['M'])) $newFormat = str_replace('{4}', $this->shortMonths[$newDate['M']], $newFormat);

        $this->result = $newFormat;
    }

    function __toString()
    {
        return $this->result;
    }
}