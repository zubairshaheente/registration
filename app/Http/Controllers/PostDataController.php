<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post_data;

class PostDataController extends Controller
{
    // public function show($id){
    //     $upload = post_data::findOrFail($id);
    //     return view('show', compact('upload'));
    // }

    public function post(){
        $postsa=post_data::all();
        return view('post')->with(['abc' => $postsa]);
    }

    // public function post_fun(Request $request) {
    //     $request->validate([
    //         'post_text' => 'required|string',
    //         'post_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $imageName = null;    
    //     if ($request->hasFile('post_img')) {
    //         $imageName = time().'.'.$request->file('post_img')->extension();     
    //         $request->file('post_img')->move(public_path('upload'), $imageName);  
    //     }

    //     $post_data = post_data::create([
    //         'post_text' => $request->post_text,
    //         'post_img' => $imageName, 
    //     ]);
    //     if($post_data){
    //     return redirect()->back()->with('success', 'Data Uploaded');
    //         }else{
    //         return redirect()->back()->with('error', 'Data not uploaded');
    //     }
    // }

    public function post_fun(Request $request, $userId) {
        $request->validate([
            'post_text' => 'required|string',
            'post_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imageName = null;    
        if ($request->hasFile('post_img')) {
            $imageName = time().'.'.$request->file('post_img')->extension();     
            $request->file('post_img')->move(public_path('upload'), $imageName);  
        }
    
        $post_data = post_data::create([
            'user_id' => $userId,
            'post_text' => $request->post_text,
            'post_img' => $imageName, 
        ]);
        
        if($post_data) {
            return redirect()->back()->with('success', 'Data Uploaded');
        } else {
            return redirect()->back()->with('error', 'Data not uploaded');
        }
    }
    
}
