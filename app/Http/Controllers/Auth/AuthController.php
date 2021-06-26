<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request) {
        $credentials = $request->only(['email', 'password']); //u $credentials smo stavili email i password koji user salje pri logovanju
        $token = auth()->attempt($credentials); //generisemo token za email i password koji smo dobili pri logovanju

        //ako nema tokena
        if(!$token) {
            return response()->json([
                'message' => 'You are not authorized!' //vrati poruku da korisnik nije autorizovan
            ], 401); //401 je greska kao drugi parametar(not authorized)
        }

        return response()->json([
            'token' => $token,
            'type' => 'bearer', //tip tokena
            'expires_in' => auth()->factory()->getTTL() * 60, //kad token istice
            'user' => auth()->user(), //vracamo autentifikovanog usera
        ]);
    }

    public function register(RegisterRequest $request) {
        $user = new User(); //pravimo novog usera(instanciramo User.php model)
        $user->first_name = $request->input('first_name'); //preko $request-a iz input polja uzimamo ono sto je user uneo
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save(); //usera moramo obavezno da sacuvamo

        return $this->login($request); //vrati ulogovanog usera
    }
}
