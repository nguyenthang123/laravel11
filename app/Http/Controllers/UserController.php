<?php

namespace App\Http\Controllers;

use App\Events\UserRegister;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class Mailer {
    public function send($message) {
        echo "Sending email: $message";
    }
}



class UserController extends Controller
{

    protected $mailer;
    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public function notifyUser() {
        $this->mailer->send("Welcome to Laravel!");
    }

    public function showLoginForm(){
         return view('auth.user-login');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        echo "đây là trang dashboard user";
        Cache::put('thang', '2222', $seconds = 600);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = "thang";
        $email = "thang@gmail.com";
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => 'abcd'
        ];
        User::create($data);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json(['message' => 'User registered successfully!'], 201);
    }

    public function logout(){
        Auth::guard('web')->logout();
    }

    public function getMoney(){
        return "3";
    }

    public function dashboard(){
        return "2";
    }

    public function get(Request $request){
         return view('user.home');
    }

    public function event(){
        $user = User::find(1);
        log::debug('event1');
        event(new UserRegister($user));
    }
    
    

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:8',
        ]);
        
        

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
