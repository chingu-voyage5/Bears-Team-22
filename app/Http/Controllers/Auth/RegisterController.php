<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Invite;
use App\Roles;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegister(Request $request)
    {
        $email = null;
        $invite = null;
        $message = null;

        if($request->get('ref')) {
            $invite = Invite::where('token',$request->get('ref'))->first();
            $email = isset($invite)? $invite->email : null;

            if ($invite && $invite->accepted_at) {
                $email = null;
                $message = "Registration token has expired";
            }
        }

        return view('auth.register')->with('email',$email)->with('message', $message);

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        //@TODO: Refactor this, and split it up
        if (isset($data['_ref'])) {
            // we don't have valid token i db
            if (!$invite = Invite::where('token', $data['_ref'])->where('accepted_at', null)->first()) {
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);
            }

            // check what role new user should have
            if (User::where('id', $invite->user_id)->first()->role->name === "trainer") {
                $role_id = Roles::where('name', 'client')->first()->id;
            }
            if (User::where('id', $invite->user_id)->first()->role->name === "owner") {
                $role_id = Roles::where('name', 'trainer')->first()->id;
            }

            $invite->accepted_at = Carbon::now();

            $invite->save();

            return User::create([
                'name' => $data['name'],
                'email' => $invite->email,
                'password' => Hash::make($data['password']),
                'role_id' => $role_id,
            ]);
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
