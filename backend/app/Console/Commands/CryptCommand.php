<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CryptCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'crypt-command {type} {value}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $type = $this->argument('type');
    $value = $this->argument('value');

    $this->info("bcrypt: " . bcrypt($value));
    if ($type === 'encrypt') {
      $encrypted = encrypt($value);
      $this->info("Encrypted: " . $encrypted);
    } elseif ($type === 'decrypt') {
      try {
        $decrypted = decrypt($value);
        $this->info("Decrypted: " . $decrypted);
      } catch (\Exception $e) {
        $this->error("Failed to decrypt value: " . $e->getMessage());
      }
    } else if($type == "hash") {
      $this->info(bcrypt($value));
    } else {
      $this->error("Invalid type. Use 'encrypt' or 'decrypt'.");
    } 

    return 0;
  }
}
