<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends Controller
{
 // authentication function, returns token
 public function authenticate(Request $request)
 {
  $credentials = $request->only('email', 'password');
  try {
   if (!$token = JWTAuth::attempt($credentials)) {
    return response()->json(['error' => 'invalid_credentials'], 400);
   }
   $user  = User::where('email', '=', $request->only('email'))->select('id', 'email', 'name')->get();
   $state = User::where('email', '=', $request->only('email'))->select('state')->get();
   $state = array_map('intval', explode('.', $state[0]['state']));
   $roles = User::where('email', '=', $request->only('email'))->select('role')->get();
   $roles = array_map('intval', explode('.', $roles[0]['role']));

  } catch (JWTException $e) {
   return response()->json(['error' => 'could_not_create_token'], 500);
  }
  if ($state[0]) {
   return response()->json(compact('roles', 'user', 'token'), 200);
   # code...
  } else {
   # code...
   return response()->json(['error' => true, 'msg' => 'User not found']);
  }

 }
//  Register function, returns user data and token
 public function register(Request $request)
 {
  $validator = Validator::make($request->all(), [
   'name'     => 'required|string|max:255',
   'email'    => 'required|string|email|max:255|unique:users',
   'password' => 'required|string|min:6|confirmed',
   'role'     => 'required',
  ]);
  if ($validator->fails()) {
   return response()->json($validator->errors()->toJson(), 400);
  }
  $user = User::create([
   'name'     => $request->get('name'),
   'email'    => $request->get('email'),
   'password' => Hash::make($request->get('password')),
   'role'     => $request->get('role'),
  ]);
//   Enable if the registration is without token validation
// and add the token with the response
//   $token = JWTAuth::fromUser($user);
  return response()->json(compact('user'), 201);
 }
//  Get authenticated user function, returns authenticated user data
 public function getAuthenticatedUser()
 {
  try {
   if (!$user = JWTAuth::parseToken()->authenticate()) {
    return response()->json(['user_not_found'], 404);
   }
  } catch (TokenExpiredException $e) {
   return response()->json(['token_expired'], $e->getStatusCode());
  } catch (TokenInvalidException $e) {
   return response()->json(['token_invalid'], $e->getStatusCode());
  } catch (JWTException $e) {
   return response()->json(['token_absent'], $e->getStatusCode());
  }
  return response()->json(compact('user'));
 }
 public function refreshToken()
 {
  $token = JWTAuth::parseToken()->refresh();
  return response()->json(compact('token'), 200);
 }
 public function logout()
 {
  try {
   JWTAuth::parseToken()->invalidate();
  } catch (JWTException $e) {
   throw $e;
  }
  return response()->json(['Message' => 'User Logged Out Successfully', 'val' => true]);
 }

 public function index()
 {
//   return User::all();
  return User::where('state', '=', '1')->select('created_at', 'email', 'id', 'name', 'role', 'updated_at')->get();
 }
 public function update(Request $request, User $user)
 {
  $pass = $request->get('password');
  if (!$pass) {

   $user->update($request->all());
  } else {
   $user->update([
    'name'     => $request->get('name'),
    'email'    => $request->get('email'),
    'password' => Hash::make($request->get('password')),
    'role'     => $request->get('role'),
   ]);

  }
  return response()->json($user, 200);
 }
 public function delete(User $user)
 {
  $user->update([
   'state' => "0",
  ]);
  return response()->json(["deleted"], 204);
 }
}