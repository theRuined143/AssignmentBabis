<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\User;
use App\Http\Models\Book;
//the guzzle import for the client
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {
        //make sure these fields are filled server-side
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password) //hashed password in our db
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
       
        if (auth()->attempt($data)) {

            $request->request->add([
                'grant_type'    => 'password',
                'client_id'     => 4,
                'client_secret' => env('CLIENT_SECRET'),
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => ''
            ]);
            $request = Request::create('localhost:8000/oauth/token', 'POST');
            $response = json_decode(Route::dispatch($request)->getContent());
            return response()->json(['response' => $response], 200);

        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {

            $request->request->add([
                'grant_type'    => 'password',
                'client_id'     => 4,
                'client_secret' => env('CLIENT_SECRET'),
                'username' => $data['email'],
                'password' => $data['password'],
                'scope' => ''
            ]);
            $request = Request::create('localhost:8000/oauth/token', 'POST');
            $response = json_decode(Route::dispatch($request)->getContent());
            return response()->json(['response' => $response], 200);

        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }   

    public function logout(Request $request)
    {
        $user = auth()->user()->token();
        $user->revoke();
        return 'You are logged out';
    }   
}