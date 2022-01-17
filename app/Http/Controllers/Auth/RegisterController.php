<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(Request $request)
    {
        $input = $request->all();

        if($input['role'] === "admin") {
            $user = User::create([
                'name' => $input['login'],
                'password' => Hash::make($input['password']),
                'area_id' => $input['area'],
            ]);
        }
        else
        {
            $user = User::create([
                'name' => $input['login'],
                'password' => Hash::make($input['password']),
                'area_id' => $input['area'],
                'district_id' => $input['district'],
            ]);
        }
        $user->assignRole($input['role']);

        return back()->withInput();
    }

    protected function createSuperAdmin()
    {
        $user = User::create([
            'name' => 'SuperAdmin',
            'password' => Hash::make('SuperAdmin')
        ]);

        $user->assignRole('super-admin');

    }
}
