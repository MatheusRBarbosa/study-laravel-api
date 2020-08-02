<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        error_log("ROTA CHAMADA");
        // Here the request is validated. The validator method is located
        // inside the RegisterController, and makes sure the name, email
        // password and password_confirmation fields are required.
        //$this->validator($request->all())->validate();
        error_log("ROTA CHAMADA2");

        // A Registered event is created and will trigger any relevant
        // observers, such as sending a confirmation email or any 
        // code that needs to be run as soon as the user is created.
        event(new Registered($user = $this->create($request->all())));
        error_log("ROTA CHAMADA3");

        // After the user is created, he's logged in.
        $this->guard()->login($user);
        error_log("ROTA CHAMADA4");

        // And finally this is the hook that we want. If there is no
        // registered() method or it returns null, redirect him to
        // some other URL. In our case, we just need to implement
        // that method to return the correct response.
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }
    
    protected function registered(Request $request, $user)
    {
        $user->generateToken();

        return response()->json(['data' => $user->toArray()], 201);
    }
}