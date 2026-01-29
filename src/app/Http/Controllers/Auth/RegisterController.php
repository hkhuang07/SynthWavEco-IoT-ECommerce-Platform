<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;


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
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'unique:users,username', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            'phone' => ['nullable', 'string', 'max:20'],
            'id_card' => ['nullable', 'string', 'max:20', 'unique:users,id_card'],
        ]);

        /*return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'unique:users,username', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // Thêm validation cho các field từ form
            'phone' => ['nullable', 'string', 'max:20'],
            'id_card' => ['nullable', 'string', 'max:20', 'unique:users,id_card'],
            'address' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'string', 'max:255'],

            // Validation cho privacy checkbox
            'privacy' => ['required', 'accepted'],
            'remember' => ['nullable', 'accepted'],
        ], [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already in use.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'privacy.required' => 'Please agree to the privacy policy.',
            'privacy.accepted' => 'Please agree to the privacy policy.',
            'username.unique' => 'This username is already in use.',
            'id_card.unique' => 'This ID card number is already in use.',
        ]);*/
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    /*protected function create(array $data)
    {
        $defaultRole = '2';

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'] ?? Str::before($data['email'], '@'),
            'phone' => $data['phone'] ?? null,
            'id_card' => $data['id_card'] ?? null,
            'roles' => $defaultRole,
            'is_active' => true,
        ]);
    }*/

     protected function create(array $data)
    {
        // Lấy default role từ database (thay vì hardcode)
        $defaultRole = \App\Models\Role::where('name', 'customer')->value('id') ?? '2';
        
        // Tạo username nếu không có
        $username = $data['username'] ?? Str::before($data['email'], '@');
        
        // Đảm bảo username unique
        $originalUsername = $username;
        $counter = 1;
        while (\App\Models\User::where('username', $username)->exists()) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $username,
            'phone' => $data['phone'] ?? null,
            'id_card' => $data['id_card'] ?? null,
            'address' => $data['address'] ?? null,
            'avatar' => $data['avatar'] ?? null,
            'roles' => $defaultRole, 
            'is_active' => true,
            'email_verified_at' => now(), // Tự động verify email
        ]);
    }

    protected function redirectTo()
    {
        return route('frontend.home');
    }
    
}
