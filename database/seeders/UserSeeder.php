<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //cleaning table
    User::truncate();
    //filling data
    User::create([
      'name'     => 'sranc',
      'email'    => 'sranc0607@gmail.com',
      'password' => Hash::make('123456'),
      'role'     => '0',
    ]);
  }
}