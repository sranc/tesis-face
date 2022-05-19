<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
 //
 public function index()
 {
  return Register::all();
 }
 public function show(Register $register)
 {
  return $register;
 }
 public function store(Request $request)
 {
  $register = Register::create($request->all());
  return response()->json($register, 201);
 }
 public function update(Request $request, Register $register)
 {
  $register->update($request->all());
  return response()->json($register, 200);
 }
 public function delete(Request $request, Register $register)
 {
  $register->delete();
  return response()->json(null, 204);
 }
}