<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostDataController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $posts = Post::where('user_id', $userId)->get();
        return view('post')->with('abc', $posts);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'post_text' => 'required|string',
            'post_img' => 'nullable|image|max:2048',
        ]);

        $post = new Post();
        $post->user_id = auth()->id(); 
        $post->post_text = $validatedData['post_text'];

        if ($request->hasFile('post_img')) {
            $image = $request->file('post_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/uploads', $imageName);
            $post->post_img = $imageName;
        }
        $post->save();

        return redirect()->route('index')->with('success', 'Post created successfully');
    }

}