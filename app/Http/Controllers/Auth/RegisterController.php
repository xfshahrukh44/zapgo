<?php

namespace App\Http\Controllers\Auth;

use App\Profile;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Session;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
            // 'zip'   => 'required|integer|max:11',
            // 'terms' => 'required',
            // 'company_name' => 'required|string|max:255',
            // 'license_state' => 'required|string|max:255',
            // 'license_no'    => 'required|string|max:255',
            // 'city'  =>  'required',
            // 'state' => 'required',
            // 'age' => 'required|in:Yes,No'
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // dd($request->all());
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator, 'registerForm');
        }
        $previousUrl = url()->previous();
        session()->put('previousUrl', $previousUrl);

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        Session::flash('message', 'New Account Created Successfully');
        Session::flash('alert-class', 'alert-success');
        return $this->registered($request, $user)
            ?: redirect($previousUrl);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['f_name'] . ' ' . $data['l_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'company_name' => $data['company_name'],
            'terms' => $data['terms'],
            'age' =>  $data['age'],
            'license_state' => $data['license_state'],
            'license_no' => $data['license_no'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip'   => $data['zip']

        ]);
    }

    protected function registered(Request $request, $user)
    {
        if ($user->profile == null) {
            $profile = new Profile();
            $profile->user_id = $user->id;
            $profile->localisation = $request->localisation;
            $profile->dob = $request->dob;
            $profile->save();
        }
        activity($user->name)
            ->performedOn($user)
            ->causedBy($user)
            ->log('Registered');
        $user->assignRole('user');
    }
}
