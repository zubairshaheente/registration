<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Notifications\WelcomeMailNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleEmail;
use Illuminate\Support\Str;


class EnterUserRecordController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function login(){
        return view('login');
    }

    public function post(){
        return view('post');
    }

    // public function indexsend(Request $request) {

    //     $validatedData = $request->validate([
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => 'required|email|lowercase|max:255|unique:'.User::class,
    //         'phn_num' => 'required',
    //         'address' => 'required',
    //         'password' => 'required',
    //     ]);
    
    //     $input = $request->all();
    
    //     $user = User::create([
    //         'first_name' => $input['first_name'],
    //         'last_name' => $input['last_name'],
    //         'email' => $input['email'],
    //         'phn_num' => $input['phn_num'],
    //         'address' => $input['address'],
    //         'password' => Hash::make($input['password']),
    //     ]);
    
    //     // Send email to the newly created user
    //     Mail::to($user->email)->send(new SampleEmail($user));
    
    //     return redirect()->route('login');
    // }


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
    
        // Generate a unique verification token
        $verification_token = Str::random(60);

        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phn_num' => $request->input('phn_num'),
            'address' => $request->input('address'),
            'password' => Hash::make($request->input('password')),
            'verification_token' => $verification_token,
        ]);

        // Send email to the user with verification link
        Mail::to($input['email'])->send(new SampleEmail($input, $verification_token));
        
        // Redirect back with success message
        return redirect()->back()->with('message', 'Please check your email to verify your account.');
    }
    
    public function verify(Request $request, $token) {
        $user = User::where('verification_token', $token)->first();

    if ($user) {
        // Update user with verified status and clear verification token
        $user->update([
            'email_verified_at' => now(), // Mark email as verified
            'verification_token' => null, // Clear verification token
        ]);

        // Redirect to login page or any other page as needed
        return redirect()->route('login')->with('success', 'Your account has been verified successfully. Please log in.');
        } else {
            // Redirect with error message if token is invalid or expired
            return redirect()->route('login')->with('error', 'Invalid verification token.');
        }       
    }

    public function loginsend(Request $request) {
        $validatedData = $request->validate([
            'email' => 'required|email|lowercase|max:255',
            'password' => 'required',
        ], [
            'password.required' => 'Your Password field is empty.',
        ]);
    
        // $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)) {
        //     return redirect()->route('index');
        // } else {
        //     return redirect()->back()->with('error', 'Invalid email or password');
        // }

        // Extract email and password from the request
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt($credentials)) {
            // Check if the user's email is verified
            if (auth()->user()->email_verified_at !== null) {
                // Redirect authenticated and verified user to the index page
                return redirect()->route('index');
            } else {
                // If email is not verified, log the user out and redirect back with an error message
                Auth::logout();
                return redirect()->back()->with('error', 'Your email address is not verified. Please verify your email to log in.');
            }
        } else {
            // If authentication attempt fails, redirect back with an error message
            return redirect()->back()->with('error', 'Invalid email or password. Please try again.');
        }

    }
    
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