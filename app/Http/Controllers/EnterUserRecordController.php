<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleEmail;
use Illuminate\Support\Str;
use Twilio\Rest\Client;


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

    public function verify_email(){
        return view('resend_verify_email');
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
        // dd('Twilio');
        // Validate incoming request data
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|lowercase|max:255|unique:users,email',
            'phn_num' => 'required',
            'address' => 'required',
            'password' => 'required',
        ]);

        // Generate a random verification token
        $verification_token = Str::random(60);

        // Create a new user record
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phn_num' => $request->input('phn_num'),
            'address' => $request->input('address'),
            'password' => Hash::make($request->input('password')),
            'verification_token' => $verification_token,
        ]);

        // Send verification SMS using Twilio
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        $twilio->messages->create(
            $request->input('phn_num'),
            [
                'from' => env('TWILIO_PHONE_NUMBER'),
                'body' => 'Your verification code is: ' . $verification_token
            ]
        );

        // Prepare data for email verification
        // $user_email = $request->input('email');

        // Send email verification
        // Mail::to($user_email)->send(new SampleEmail($request->all(), $verification_token));

        // Redirect the user to a view with a message
        return view('resend_verify_email', compact('user_email'))->with('message', 'Please check your email to verify your account.');
    }

    public function verify(Request $request, $token) {
        $user = User::where('verification_token', $token)->first();

    if ($user) {
        $user->update([
            'email_verified_at' => now(),
            'verification_token' => null,
        ]);

        return redirect()->route('login')->with('success', 'Your account has been verified successfully. Please log in.');
        } else {
        return redirect()->route('login')->with('error', 'Invalid verification token.');
        }
    }

    public function resend_verification_email(Request $request) {
        $user = User::where('email', $request->input('email'))->first();
        // dd($user);
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found']);
        }
        if ($user->email_verified_at !== null) {
            return redirect()->back()->withErrors(['email' => 'User already verified']);
        }

        $user_email = $request->input('email');

        $verification_token = Str::random(60);
        $user->update([
            'verification_token' => $verification_token,
        ]);

        Mail::to($user->email)->send(new SampleEmail($user, $verification_token));
        return view('resend_verify_email',compact('user_email'))->with('message', 'Verification email resent successfully.');
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

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->email_verified_at !== null) {
                return redirect()->route('index');
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Your email address is not verified. Please verify your email to log in.');
            }
        } else {
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
