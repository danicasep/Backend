<?PHP

namespace App\Helpers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ValidationHelper
{
  /**
   * @var Request
   */
  protected $request;

  /**
   * @var array
   */
  protected $rules = [];

  /**
   * @var array
   */
  protected $errors = [];

  protected $messages = [
    "id" => [
      'accepted'        => ':attribute harus diterima.',
      'accepted_if'     => ':attribute harus diterima jika :other adalah :value.',
      'active_url'      => ':attribute bukan URL yang valid.',
      'after'           => ':attribute harus tanggal setelah :date.',
      'after_or_equal'  => ':attribute harus tanggal setelah atau sama dengan :date.',
      'alpha'           => ':attribute hanya boleh mengandung huruf.',
      'alpha_dash'      => ':attribute hanya boleh mengandung huruf, angka, tanda hubung, dan garis bawah.',
      'alpha_num'       => ':attribute hanya boleh mengandung huruf dan angka.',
      'array'           => ':attribute harus berupa larik.',
      'before'          => ':attribute harus tanggal sebelum :date.',
      'before_or_equal' => ':attribute harus tanggal sebelum atau sama dengan :date.',
      'between' => [
        'array'   => ':attribute harus memiliki antara :min dan :max item.',
        'file'    => ':attribute harus memiliki antara :min dan :max kilobita.',
        'numeric' => ':attribute harus memiliki nilai antara :min dan :max.',
        'string'  => ':attribute harus memiliki panjang antara :min dan :max karakter.',
      ],
      'boolean'           => ':attribute harus benar atau salah.',
      'confirmed'         => 'Konfirmasi :attribute tidak cocok.',
      'current_password'  => 'Kata sandi salah.',
      'date'              => ':attribute bukan tanggal yang valid.',
      'date_equals'       => ':attribute harus tanggal yang sama dengan :date.',
      'date_format'       => ':attribute tidak cocok dengan format :format.',
      'declined'          => ':attribute harus ditolak.',
      'declined_if'       => ':attribute harus ditolak jika :other adalah :value.',
      'different'         => ':attribute dan :other harus berbeda.',
      'digits'            => ':attribute harus terdiri dari :digits digit.',
      'digits_between'    => ':attribute harus terdiri dari antara :min dan :max digit.',
      'dimensions'        => ':attribute memiliki dimensi gambar yang tidak valid.',
      'distinct'          => ':attribute memiliki nilai duplikat.',
      'doesnt_end_with'   => ':attribute tidak boleh diakhiri dengan salah satu dari berikut: :values.',
      'doesnt_start_with' => ':attribute tidak boleh diawali dengan salah satu dari berikut: :values.',
      'email'             => ':attribute harus berupa alamat email yang valid.',
      'ends_with'         => ':attribute harus diakhiri dengan salah satu dari berikut: :values.',
      'enum'              => ':attribute yang dipilih tidak valid.',
      'exists'            => ':attribute yang dipilih tidak valid.',
      'file'              => ':attribute harus berupa file.',
      'filled'            => ':attribute harus memiliki nilai.',
      'gt' => [
        'array'   => ':attribute harus memiliki lebih dari :value item.',
        'file'    => ':attribute harus lebih besar dari :value kilobita.',
        'numeric' => ':attribute harus lebih besar dari :value.',
        'string'  => ':attribute harus lebih panjang dari :value karakter.',
      ],
      'gte' => [
        'array'   => ':attribute harus memiliki :value item atau lebih.',
        'file'    => ':attribute harus lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => ':attribute harus lebih besar dari atau sama dengan :value.',
        'string'  => ':attribute harus lebih panjang dari atau sama dengan :value karakter.',
      ],
      'image'     => ':attribute harus berupa gambar.',
      'in'        => ':attribute yang dipilih tidak valid.',
      'in_array'  => ':attribute tidak ada dalam :other.',
      'integer'   => ':attribute harus berupa bilangan bulat.',
      'ip'        => ':attribute harus berupa alamat IP yang valid.',
      'ipv4'      => ':attribute harus berupa alamat IPv4 yang valid.',
      'ipv6'      => ':attribute harus berupa alamat IPv6 yang valid.',
      'json'      => ':attribute harus berupa string JSON yang valid.',
      'lt' => [
        'array'   => ':attribute harus memiliki kurang dari :value item.',
        'file'    => ':attribute harus kurang dari :value kilobita.',
        'numeric' => ':attribute harus kurang dari :value.',
        'string'  => ':attribute harus lebih pendek dari :value karakter.',
      ],
      'lte' => [
        'array'   => ':attribute tidak boleh memiliki lebih dari :value item.',
        'file'    => ':attribute harus kurang dari atau sama dengan :value kilobita.',
        'numeric' => ':attribute harus kurang dari atau sama dengan :value.',
        'string'  => ':attribute harus lebih pendek dari atau sama dengan :value karakter.',
      ],
      'mac_address' => ':attribute harus berupa alamat MAC yang valid.',
      'max' => [
        'array'   => ':attribute tidak boleh memiliki lebih dari :max item.',
        'file'    => ':attribute tidak boleh lebih besar dari :max kilobita.',
        'numeric' => ':attribute tidak boleh lebih besar dari :max.',
        'string'  => ':attribute tidak boleh lebih panjang dari :max karakter.',
      ],
      'max_digits'  => ':attribute tidak boleh memiliki lebih dari :max digit.',
      'mimes'       => ':attribute harus berupa file dengan tipe: :values.',
      'mimetypes'   => ':attribute harus berupa file dengan tipe: :values.',
      'min' => [
        'array'   => ':attribute harus memiliki setidaknya :min item.',
        'file'    => ':attribute harus memiliki setidaknya :min kilobita.',
        'numeric' => ':attribute harus setidaknya :min.',
        'string'  => ':attribute harus setidaknya :min karakter.',
      ],
      'min_digits'  => ':attribute harus memiliki setidaknya :min digit.',
      'multiple_of' => ':attribute harus merupakan kelipatan dari :value.',
      'not_in'      => ':attribute yang dipilih tidak valid.',
      'not_regex'   => 'Format :attribute tidak valid.',
      'numeric'     => ':attribute harus berupa angka.',
      'password' => [
        'letters' => ':attribute harus mengandung setidaknya satu huruf.',
        'mixed'   => ':attribute harus mengandung setidaknya satu huruf kapital dan satu huruf kecil.',
        'numbers' => ':attribute harus mengandung setidaknya satu angka.',
        'symbols' => ':attribute harus mengandung setidaknya satu simbol.',
      ],
      'present'               => ':attribute harus ada.',
      'prohibited'            => ':attribute dilarang.',
      'prohibited_if'         => ':attribute dilarang jika :other adalah :value.',
      'prohibited_unless'     => ':attribute dilarang kecuali :other berada dalam :values.',
      'regex'                 => 'Format :attribute tidak valid.',
      'relatable'             => ':attribute ini mungkin tidak terkait dengan sumber daya ini.',
      'required'              => ':attribute wajib diisi.',
      'required_if'           => ':attribute wajib diisi ketika :other adalah :value.',
      'required_unless'       => ':attribute wajib diisi kecuali :other berada dalam :values.',
      'required_with'         => ':attribute wajib diisi ketika :values ada.',
      'required_with_all'     => ':attribute wajib diisi ketika :values ada.',
      'required_without'      => ':attribute wajib diisi ketika :values tidak ada.',
      'required_without_all'  => ':attribute wajib diisi ketika tidak ada :values yang ada.',
      'same'                  => ':attribute dan :other harus sama.',
      'size' => [
        'array'   => ':attribute harus mengandung :size item.',
        'file'    => ':attribute harus berukuran :size kilobita.',
        'numeric' => ':attribute harus berukuran :size.',
        'string'  => ':attribute harus berukuran :size karakter.',
      ],
      'starts_with' => ':attribute harus diawali dengan salah satu dari berikut: :values.',
      'string'      => ':attribute harus berupa string.',
      'timezone'    => ':attribute harus berupa zona waktu yang valid.',
      'unique'      => ':attribute sudah ada sebelumnya.',
      'uploaded'    => ':attribute gagal diunggah.',
      'url'         => 'Format :attribute tidak valid.',
      'uuid'        => ':attribute harus merupakan UUID yang valid.'
    ],
    "en" => [
      'accepted'        => ':attribute must be accepted.',
      'accepted_if'     => ':attribute must be accepted if :other is :value.',
      'active_url'      => ':attribute is not a valid URL.',
      'after'           => ':attribute must be a date after :date.',
      'after_or_equal'  => ':attribute must be a date after or equal to :date.',
      'alpha'           => ':attribute may only contain letters.',
      'alpha_dash'      => ':attribute may only contain letters, numbers, dashes, and underscores.',
      'alpha_num'       => ':attribute may only contain letters and numbers.',
      'array'           => ':attribute must be an array.',
      'before'          => ':attribute must be a date before :date.',
      'before_or_equal' => ':attribute must be a date before or equal to :date.',
      'between' => [
        'array'   => ':attribute must have between :min and :max items.',
        'file'    => ':attribute must be between :min and :max kilobytes.',
        'numeric' => ':attribute must be between :min and :max.',
        'string'  => ':attribute must be between :min and :max characters.',
      ],
      'boolean'           => ':attribute must be true or false.',
      'confirmed'         => ':attribute confirmation does not match.',
      'current_password'  => 'The password is incorrect.',
      'date'              => ':attribute is not a valid date.',
      'date_equals'       => ':attribute must be a date equal to :date.',
      'date_format'       => ':attribute does not match the format :format.',
      'declined'          => ':attribute must be declined.',
      'declined_if'       => ':attribute must be declined if :other is :value.',
      'different'         => ':attribute and :other must be different.',
      'digits'            => ':attribute must be :digits digits.',
      'digits_between'    => ':attribute must be between :min and :max digits.',
      'dimensions'        => ':attribute has invalid image dimensions.',
      'distinct'          => ':attribute has a duplicate value.',
      'doesnt_end_with'   => ':attribute may not end with one of the following: :values.',
      'doesnt_start_with' => ':attribute may not start with one of the following: :values.',
      'email'             => ':attribute must be a valid email address.',
      'ends_with'         => ':attribute must end with one of the following: :values.',
      'enum'              => 'The selected :attribute is invalid.',
      'exists'            => 'The selected :attribute is invalid.',
      'file'              => ':attribute must be a file.',
      'filled'            => ':attribute must have a value.',
      'gt' => [
        'array'   => ':attribute must have more than :value items.',
        'file'    => ':attribute must be greater than :value kilobytes.',
        'numeric' => ':attribute must be greater than :value.',
        'string'  => ':attribute must be greater than :value characters.',
      ],
      'gte' => [
        'array'   => ':attribute must have :value items or more.',
        'file'    => ':attribute must be greater than or equal to :value kilobytes.',
        'numeric' => ':attribute must be greater than or equal to :value.',
        'string'  => ':attribute must be greater than or equal to :value characters.',
      ],
      'image'     => ':attribute must be an image.',
      'in'        => 'The selected :attribute is invalid.',
      'in_array'  => ':attribute does not exist in :other.',
      'integer'   => ':attribute must be an integer.',
      'ip'        => ':attribute must be a valid IP address.',
      'ipv4'      => ':attribute must be a valid IPv4 address.',
      'ipv6'      => ':attribute must be a valid IPv6 address.',
      'json'      => ':attribute must be a valid JSON string.',
      'lt' => [
        'array'   => ':attribute must have less than :value items.',
        'file'    => ':attribute must be less than :value kilobytes.',
        'numeric' => ':attribute must be less than :value.',
        'string'  => ':attribute must be shorter than :value characters.',
      ],
      'lte' => [
        'array'   => ':attribute must not have more than :value items.',
        'file'    => ':attribute must be less than or equal to :value kilobytes.',
        'numeric' => ':attribute must be less than or equal to :value.',
        'string'  => ':attribute must be shorter than or equal to :value characters.',
      ],
      'mac_address' => ':attribute must be a valid MAC address.',
      'max' => [
        'array'   => ':attribute may not have more than :max items.',
        'file'    => ':attribute may not be greater than :max kilobytes.',
        'numeric' => ':attribute may not be greater than :max.',
        'string'  => ':attribute may not be greater than :max characters.',
      ],
      'max_digits'  => ':attribute may not have more than :max digits.',
      'mimes'       => ':attribute must be a file of type: :values.',
      'mimetypes'   => ':attribute must be a file of type: :values.',
      'min' => [
        'array'   => ':attribute must have at least :min items.',
        'file'    => ':attribute must be at least :min kilobytes.',
        'numeric' => ':attribute must be at least :min.',
        'string'  => ':attribute must be at least :min characters.',
      ],
      'min_digits'  => ':attribute must have at least :min digits.',
      'multiple_of' => ':attribute must be a multiple of :value.',
      'not_in'      => 'The selected :attribute is invalid.',
      'not_regex'   => 'The :attribute format is invalid.',
      'numeric'     => ':attribute must be a number.',
      'password' => [
        'letters' => ':attribute must contain at least one letter.',
        'mixed'   => ':attribute must contain at least one uppercase and one lowercase letter.',
        'numbers' => ':attribute must contain at least one number.',
        'symbols' => ':attribute must contain at least one symbol.',
      ],
      'present'               => ':attribute must be present.',
      'prohibited'            => ':attribute is prohibited.',
      'prohibited_if'         => ':attribute is prohibited if :other is :value.',
      'prohibited_unless'     => ':attribute is prohibited unless :other is in :values.',
      'regex'                 => 'The :attribute format is invalid.',
      'relatable'             => 'This :attribute may not be associated with this resource.',
      'required'              => ':attribute is required.',
      'required_if'           => ':attribute is required when :other is :value.',
      'required_unless'       => ':attribute is required unless :other is in :values.',
      'required_with'         => ':attribute is required when :values is present.',
      'required_with_all'     => ':attribute is required when :values is present.',
      'required_without'      => ':attribute is required when :values is not present.',
      'required_without_all'  => ':attribute is required when none of :values are present.',
      'same'                  => ':attribute and :other must match.',
      'size' => [
        'array'   => ':attribute must contain :size items.',
        'file'    => ':attribute must be :size kilobytes.',
        'numeric' => ':attribute must be :size.',
        'string'  => ':attribute must be :size characters.',
      ],
      'starts_with' => ':attribute must start with one of the following: :values.',
      'string'      => ':attribute must be a string.',
      'timezone'    => ':attribute must be a valid zone.',
      'unique'      => ':attribute has already been taken.',
      'uploaded'    => ':attribute failed to upload.',
      'url'         => 'The :attribute format is invalid.',
      'uuid'        => ':attribute must be a valid UUID.'
    ]
  ];

  protected $language = "id";

  /**
   * @var string $language id | en
   */
  function __construct($language = "id")
  {
    $this->language = $language;
    $this->request  = request();
  }

  public function setRules($name, $label, $rules)
  {
    $this->rules[] = (object) [
      "name"  => $name,
      "label" => $label,
      "rules" => $rules
    ];
    return $this;
  }

  public function run()
  {
    $rules = [];
    $labels = [];
    $errors = [];

    foreach ($this->rules as $rule) {
      $rules[$rule->name]  = $rule->rules;
      $labels[$rule->name] = $rule->label;
      $errors[$rule->name] = null;
    }

    $validator = Validator::make($this->request->all(), $rules, $this->messages[$this->language], $labels);

    if ($validator->fails()) {
      foreach ($validator->errors()->messages() as $name => $messages) {
        $errors[$name] = $messages[0] ?? null;
      }
      $this->errors = $errors;
    }
    return $this;
  }

  public function fails(): bool
  {
    return count($this->errors) > 0;
  }

  public function errors(): array
  {
    return $this->errors;
  }

  public function errorMessages(): string
  {
    return json_encode($this->errors);
  }
}
