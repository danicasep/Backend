<?PHP

namespace App\Helpers;

use DateTime;
use Ramsey\Uuid\Rfc4122\UuidV4;

class GeneralHelper
{
  public static $perPages = [10, 20, 50, 100];

  public static function preventMaxPerPage($perPage)
  {
    try {
      if ((int) $perPage > 100) return 100;
      return $perPage;
    } catch (\Throwable $th) {
      return 10;
    }
  }

  public static function toRupiah($number, $prefix = "Rp. ")
  {
    return "$prefix" . number_format($number, 2, ",", ".");
  }

  public static function slugify($text, $replace = "-")
  {
    $search = ['Ș', 'Ț', 'ş', 'ţ', 'Ş', 'Ţ', 'ș', 'ț', 'î', 'â', 'ă', 'Î', ' ', 'Ă', 'ë', 'Ë'];
    $replace = ['s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E'];
    $str = str_ireplace($search, $replace, strtolower(trim($text)));
    $str = preg_replace('/[^\w\d\-\ ]/', '', $str);
    $str = str_replace(' ', '-', $str);
    return preg_replace('/\-{2,}', $replace, $str);
  }

  public static function randomString($length = 10): string
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $_randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $_randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $_randomString;
  }

  public static function safeInput($value)
  {
    return preg_replace("/[^a-zA-Z0-9_\-\(\)\[\]\' ]+/", '', $value);
  }

  public static function randomToken()
  {
    static $max = 60466175; // ZZZZZZ in decimal
    return strtoupper(sprintf(
      "%05s-%05s-%05s-%05s",
      base_convert(random_int(0, $max), 10, 36),
      base_convert(random_int(0, $max), 10, 36),
      base_convert(random_int(0, $max), 10, 36),
      base_convert(random_int(0, $max), 10, 36)
    ));
  }

  /**
   * @return object :
   * 
   *    - startDate : null | string
   *    - endDate : null | string
   * 
   */
  public static function getDates($startDate, $endDate)
  {
    if (self::isValidDate($startDate) && self::isValidDate($endDate)) {
      $start = new DateTime($startDate);
      $end    = new DateTime($endDate);

      return (object) [
        "startDate" => $start->format("Y-m-d") . " 00:00:00",
        "endDate"   => $end->format("Y-m-d") . " 23:59:59"
      ];
    }

    return (object) [
      "startDate" => null,
      "endDate"   => null
    ];
  }

  public static function isValidDate($date): bool
  {
    $format = "Y-m-d";
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }

  public static function isValidDateTime($date): bool
  {
    $format = "Y-m-d H:i:s";
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }

  public static function fixPhoneNumber($phoneNumber): string
  {
    return preg_replace('/^62|^0/', '', $phoneNumber);
  }

  public static function isValidInteger($value): bool
  {
    return filter_var($value, FILTER_VALIDATE_INT);
  }

  public static function isValidAlphaNumeric($value): bool
  {
    return preg_match('/^[a-zA-Z0-9_-]+$/', $value);
  }

  public static function isValidName($value): bool
  {
    return preg_match("/^[a-zA-Z0-9_\-\(\)\[\]\' ]+$/", $value);
  }

  public static function isValidUsername($value): bool
  {
    return preg_match("/^[a-z0-9_\-\(\)\[\]\' ]+$/", $value);
  }

  public static function isValidFinanceCode($value): bool
  {
    return preg_match('/^\d+\.\d{2}\.\d{3}$/', $value);
  }

  public static function isValidArrayAlphaNumeric($values): bool
  {
    if (is_array($values) === false) return false;

    foreach ($values as $value) {
      if (!preg_match('/^[a-zA-Z0-9_-]+$/', $value)) {
        return false; // Jika ada elemen yang bukan alpha numeric
      }
    }
    return true; // Semua elemen value valid
  }

  public static function toBoolean($value): bool
  {
    return filter_var($value, FILTER_VALIDATE_BOOLEAN);
  }

  public static function isValidArrayFinanceCode($values): bool
  {
    if (is_array($values) === false) return false;

    foreach ($values as $value) {
      if (!preg_match('/^\d+\.\d{2}\.\d{3}$/', $value)) {
        return false; // Jika ada elemen yang bukan Kode Finance
      }
    }
    return true; // Semua elemen value valid
  }

  public static function isValidBoolean($value): bool
  {
    $acceptable = [true, false, 0, 1, '0', '1', "true", "false"];

    return in_array($value, $acceptable, true);
  }

  public static function isValidArrayUuidV4($values): bool
  {
    if (is_array($values) === false) return false;

    foreach ($values as $value) {
      if (!UuidV4::isValid($value)) {
        return false; // Jika ada elemen yang bukan UUID V4
      }
    }
    return true; // Semua elemen value valid
  }

  public static function isValidArrayInteger(array $values): bool
  {
    if (is_array($values) === false) return false;

    foreach ($values as $item) {
      if (!filter_var($item, FILTER_VALIDATE_INT)) {
        return false; // Jika ada elemen yang bukan integer
      }
    }
    return true; // Semua elemen adalah integer
  }

  public static function isValidCodeCRM($code): bool
  {
    return preg_match('/^\[[a-zA-Z0-9_]+\]$/', $code);
  }

  public static function isValidArrayCodeCRM($codes): bool
  {
    if (is_array($codes) === false) return false;

    foreach ($codes as $code) {
      if (!preg_match('/^\[[a-zA-Z0-9_]+\]$/', $code)) {
        return false; // Jika ada elemen yang bukan kode
      }
    }
    return true; // Semua elemen code valid
  }

  /**
   * Calculates the distance between two points, given their 
   * latitude and longitude, and returns an array of values 
   * of the most common distance units
   *
   * @param  {double} $latitude1 Latitude of the first point
   * @param  {double} $longitude1 Longitude of the first point
   * @param  {double} $latitude2 Latitude of the second point
   * @param  {double} $longitude2 Longitude of the second point
   * @return {object} {miles, feet, yards, kilometers, meters}
   */
  public static function getDistanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2)
  {
    $theta = $longitude1 - $longitude2;
    $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $feet  = $miles * 5280;
    $yards = $feet / 3;
    $kilometers = $miles * 1.609344;
    $meters = $kilometers * 1000;
    return (object) compact('miles', 'feet', 'yards', 'kilometers', 'meters');
  }

  public static function isJson($value): bool
  {
    try {
      json_decode($value, false, 512, JSON_THROW_ON_ERROR);
      return true;
    } catch (\JsonException $exception) {
      return false;
    }
  }

  public static function findByKey($key, $value, array $array)
  {
    $data = null;

    foreach ($array as $dt) {
      if (
        (!is_array($dt) && isset($dt->$key) && $dt->$key == $value) ||
        (is_array($dt) && isset($dt[$key]) && $dt[$key] == $value)
      ) {
        $data = $dt;
        break;
      }
    }

    return $data;
  }

  public static function formatNumber($value, $precision = 2)
  {
    // Membulatkan hasil ke 2 angka di belakang koma
    $roundedNumber = round($value, $precision);

    // Jika hasilnya adalah bilangan bulat, return tanpa desimal
    if ($roundedNumber == (int)$roundedNumber) {
      return (int)$roundedNumber;
    }

    // Jika tidak, kembalikan dengan 2 angka desimal
    return number_format($roundedNumber, $precision);
  }

  public static function generateVoucherCode($length = 10) {
    $characters =  'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $microTime = microtime(true);
    $seed = md5($microTime . uniqid(rand(), true));
    $randomString = '';
    for ($i=0; $i<$length; $i++) {
      $index = hexdec(substr($seed, $i, 1)) % strlen($characters);
      $randomString .= $characters[$index];
    }
    return $randomString;
  }

}
