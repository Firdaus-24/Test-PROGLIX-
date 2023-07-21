<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TweetRequest;
use App\Models\Tweet;
use App\Models\User;

class TweetController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'content' => 'required|max:200',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $uploadFolder = public_path('files');
        $tweet = Tweet::create([
            'content' => $request->content,
        ]);
        $tweet->content = $request->content;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('files', 'public');
            $tweet->image = $imagePath;
            $img = $tweet->image;
            $request->file('image')->move($uploadFolder, $tweet->image);
            $tweet->save();
        }

        // if ($request->hasFile('image')) {
        //     $tweet = Tweet::create([
        //         'content' => $request->content,
        //         'image' => $request->file('image'),
        //     ]);

        //     $request->file('amprah_req')->move($uploadFolder, $request->file('image'));
        // } else {
        //     $tweet = Tweet::create([
        //         'content' => $request->content,
        //     ]);
        // }

        return response()->json([
            'message' => 'Tweet berhasil diunggah',
            'content' => $tweet
        ], 201);
    }

    public function show()
    {
        $data = Tweet::all();

        return response()->json([
            'message' => 'Tweet berhasil diunggah',
            'payload' => $data
        ]);
    }

    public function delete($id)
    {
        $tweet = Tweet::find($id);
        $delete = $tweet->delete();
        return response()->json([
            'status' => true,
            'content' => $tweet
        ]);
    }
}
