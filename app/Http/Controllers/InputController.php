<?php

namespace App\Http\Controllers;
use App\Models\Input;
use Illuminate\Http\Request;

class InputController extends Controller {
    public function store(Request $request) {
        $request->validate(['file' => 'required|image|max:5120']);
        
        $path = $request->file('file')->store('inputs', 'public');
        
        $input = Input::create([
            'image' => $path
        ]);

        return response()->json([
            'id' => $input->id,
            'image_path' => $path
        ]);
    }
}