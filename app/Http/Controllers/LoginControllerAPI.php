<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

define('YOUR_SERVER_URL', 'http://prj.dad');
// Check "oauth_clients" table for next 2 values:
define('CLIENT_ID', '2');
define('CLIENT_SECRET','SOnUGjapt1RBJMVHVkvwIldqRyx6We21Ru9sAV5f');

class LoginControllerAPI extends Controller
{
    public function login(Request $request)
    {
        
         // Check if a user with the specified email exists
         $user = User::whereEmail(request('email'))->first();
         if (!$user) {
             $user=User::where('username', $request->get('email'))->get()->first();
             if (!$user) {
                 return response()->json([
                     'message' => 'Wrong username/email or password',
                     'status' => 422
                 ], 422);
             }
             
         }
 
         // If a user with the email was found - check if the specified password
         // belongs to this user
         if (!Hash::check($request->get('password'), $user->password)) {
             return response()->json([
                 'message' => 'Wrong email or password',
                 'status' => 422
             ], 422);
         }
         
         if($user->email_verified_at==null){
            return response()->json([
                'message' => 'Email not verified',
                 'status' => 422
             ], 422);
             
         }
 
         // Send an internal API request to get an access token
         $client = DB::table('oauth_clients')
             ->where('password_client', true)
             ->first();
 
         // Make sure a Password Client exists in the DB
         if (!$client) {
             return response()->json([
                 'message' => 'Laravel Passport is not setup properly.',
                 'status' => 500
             ], 500);
         }
 
         $data = [
             'grant_type' => 'password',
             'client_id' => $client->id,
             'client_secret' => $client->secret,
             'username' => $user->email,
             'password' => $request->get('password'),
         ];
 
         $request = Request::create('/oauth/token', 'POST', $data);
 
         $response = app()->handle($request);
 
         // Check if the request was successful
         if ($response->getStatusCode() != 200) {
             return response()->json([
                 'message' => 'Response Wrong email or password',
                 'status' => 422
             ], 422);
         }
 
         // Get the data from the response
         $data = json_decode($response->getContent());
 
         // Format the final response in a desirable format
         return response()->json([
             'token' => $data,
             'user' => $user,
             'status' => 200
         ]);
    }/*
    public function login(Request $request)
    {
        $http = new \GuzzleHttp\Client;
        $response = $http->post(YOUR_SERVER_URL.'/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => CLIENT_ID,
                'client_secret' => CLIENT_SECRET,
                'username' => $request->email,
                'password' => $request->password,
                'scope' => ''
            ],
            'exceptions' => false,
        ]);
        $errorCode= $response->getStatusCode();
        if ($errorCode=='200') {
            return json_decode((string) $response->getBody(), true);
        } else {
            return response()->json(['msg'=>'User credentials are invalid'], $errorCode);
        }
    }*/

    public function logout()
    {
        \Auth::guard('api')->user()->token()->revoke();
        \Auth::guard('api')->user()->token()->delete();
        return response()->json(['msg'=>'Token revoked'], 200);
    }
}
