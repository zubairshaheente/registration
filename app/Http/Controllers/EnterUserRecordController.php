<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\enter_user_record;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class EnterUserRecordController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function login(){
        return view('login');
    }

    public function loginview_page(){
        return view('loginview');
    }

    public function post(){
        return view('post');
    }

    public function indexsend(Request $request) {

        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|lowercase|max:255|unique:'.enter_user_record::class,
            'phn_num' => 'required',
            'address' => 'required',
            'password' => 'required',
        ]);

        $input = $request->all();
        // dd($input['password']);
        enter_user_record::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'phn_num' => $input['phn_num'],
            'address' => $input['address'],
            'password' => Hash::make($input['password']),
        ]);

        return redirect()->route('login_page_view');
    }

    public function loginsend(Request $request) {

        $validatedData = $request->validate([
            'email' => 'required|email|lowercase|max:255',
            'password' => 'required',
        ]);

        // dd($request);
        $input = $request->all();
        $password =$input['password'];
        // dd($password);
        $login_user = enter_user_record::where('email', $request->email)->first();
        if($login_user && Hash::check($password,  $login_user->password)){
            return redirect()->route('post_page');
        }
        else {
            // return redirect()->back();
        }
    }

    // public function loginsend(Request $request) {
    //     $validatedData = $request->validate([
    //         'email' => 'required|email|lowercase|max:255',
    //         'password' => 'required',
    //     ]);
    
    //     $input = $request->all();
    //     $password = $input['password'];
    
    //     $login_user = enter_user_record::where('email', $request->email)->first();
        
    //     if($login_user && Hash::check($password,  $login_user->password)){
    //         return redirect()->route('post_fun', ['userId' => $login_user->id]);
    //     } else {
    //         return redirect()->back();
    //     }
    // }
    

    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleHandle()
    {   
        try {
            $user = Socialite::driver('google')->user();
            // dd($user);
    
            $findUser = enter_user_record::where('email', $user->email)->first();
    
            if (!$findUser) {
                $newUser = enter_user_record::create([
                    'first_name' => $user->getName(), 
                    'email' => $user->getEmail(),
                    'password' => bcrypt("Zub@1234"),
        ]);

            // dd($newUser);

            $newUser->save();
    
            session()->put('id', $newUser->id);
            } else {
                session()->put('id', $findUser->id);
            }
    
            return redirect('/post');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}