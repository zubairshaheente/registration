<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class EnterUserRecordController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function login(){
        return view('login');
    }

    // public function loginview_page(){
    //     return view('loginview');
    // }

    public function post(){
        return view('post');
    }

    public function indexsend(Request $request) {

        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|lowercase|max:255|unique:'.User::class,
            'phn_num' => 'required',
            'address' => 'required',
            'password' => 'required',
        ]);

        $input = $request->all();
        // dd($input['password']);
        User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'phn_num' => $input['phn_num'],
            'address' => $input['address'],
            'password' => Hash::make($input['password']),
        ]);
        return redirect()->route('login');
    }

    public function loginsend(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email|lowercase|max:255',
            'password' => 'required',
        ], [
            'password.required' => 'Your Password field is empty.',
        ]);
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('index');
        } else {
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    }

    // public funtion loginsend(Request $request){
        
    // }
    
// Google Login
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleHandle()
    {   
        try {
            $user = Socialite::driver('google')->user();
            // dd($user);
    
            $findUser = User::where('email', $user->email)->first();
    
            if (!$findUser) {
                $newUser = User::create([
                'first_name' => $user->getName(), 
                'last_name' => $user->getName(), 
                'phn_num' => $user->getName(), 
                'address' => $user->getName(), 
                'email' => $user->getEmail(),
                'password' => bcrypt("Zub@1234"),
        ]);

            // dd($newUser);

            $newUser->save();
    
            session()->put('id', $newUser->id);
            } else {
                session()->put('id', $findUser->id);
            }
            return redirect()->route('index');
            } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function signout(){
        Auth::logout();
        Session::flash('message', 'You have been signed out successfully.');
        return redirect()->route('login');
    }
// fb login
    public function facebookpage(){
        return Socialite::driver('facebook')->redirect();
    }
    
    public function facebookredirect(){
        try {
            // dd('null');
            $user = Socialite::driver('facebook')->user();
    
            $findUser = User::where('email', $user->email)->first();
    
            if (!$findUser) {
            $newUser = User::create([
            'first_name' => $user->getName(), 
            'email' => $user->getEmail(),
            'password' => bcrypt("Zub@1234"),
        ]);

            $newUser->save();
    
            session()->put('id', $newUser->id);
            } else {
            session()->put('id', $findUser->id);
            }
    
            return redirect('post');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}