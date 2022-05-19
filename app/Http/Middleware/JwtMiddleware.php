<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
 /**
  * Handle an incoming request.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
  * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
  */
 public function handle(Request $request, Closure $next)
 {
  try {
   $user = JWTAuth::parseToken()->authenticate();
  } catch (TokenExpiredException $e) {
   return response()->json(['error' => 'Token Expired'], 401);
  } catch (TokenInvalidException $e) {
   return response()->json(['error' => 'Token Invalid'], 401);
  } catch (JWTException $e) {
   return response()->json(['error' => 'Token Absent'], 401);
  } catch (Exception $e) {
   return response()->json(['error' => $e->getMessage(), 500]);
  }
  return $next($request);
 }
}