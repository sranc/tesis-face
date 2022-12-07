<?php

namespace Database\Seeders;

use App\Models\Register;
use Illuminate\Database\Seeder;

class RegisterSeeder extends Seeder
{
 /**
  * Run the database seeds.
  *
  * @return void
  */
 public function run()
 {
  //table cleaned
  Register::truncate();
  //Filling the table
  Register::create([
   'name'       => 'Juan Jose Orellana',
   'id_convict' => 1500,
   'camera'     => 'camera-1',
  ]);

 }
}