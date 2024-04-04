<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EditUserRecord extends Controller
{
    public function edit_rec(){
        return view('editprofile');
    }

    public function edit_user_rec(Request $request)
    {
        $userId = auth()->user()->id;
    
    $user = User::find($userId);
    
    if ($user) {
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        // Only update the password if a new one is provided
        // if ($request->filled('password')) {
        //     $user->password = bcrypt($request->input('password'));
        // }
        $user->phn_num = $request->input('phn_num');
        $user->address = $request->input('address');
        
        $user->save();

        // Redirect to a success page or return a response
        // For example:
        return redirect()->route('editprofile')->with('success', 'Profile updated successfully');
    } else {
        // Handle case where user is not found
        // For example:
        return redirect()->route('editprofile')->with('error', 'User not found');
    }
    }
}
