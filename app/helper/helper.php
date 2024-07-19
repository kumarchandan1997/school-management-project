<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Intervention\Image\Facades\Image;



function video(Request $request){
    if ($request->hasFile('video')) {
        $file = $request->file('video');
        $extension = $file->getClientOriginalName();
        $ext_array = explode(".",$extension);
        $ext = end($ext_array);
        $filename = time() . '.' . $extension;
        $file->move('videos/', $filename);
        return $filename;
    }
}


function pdf(Request $request){
    if ($request->hasFile('pdf')) {
        $file = $request->file('pdf');
        $extension = $file->getClientOriginalName();
        $ext_array = explode(".",$extension);
        $ext = end($ext_array);
        $filename = time() . '.' . $extension;
        $file->move('documents', $filename);
        return $filename;
    }
}



// function uploadDocument(Request $request){
//     if ($request->hasFile('pdf')) {
//         $file = $request->file('pdf');
//         $extension = $file->getClientOriginalName();
//         $ext_array = explode(".", $extension);
//         $ext = end($ext_array);
//         $filename = time() . '.' . $extension;
//         $file->move('videos/', $filename); // Upload to the 'videos' directory
//         return $filename;
//     }
// }





    // function video($request)
    // {
    //     if ($request->hasFile('video')) {
    //         $file = $request->file('video');
    //         $extension = $file->getClientOriginalExtension();
    //         $filename = time() . '.' . $extension;
    //         $file->move('videos/', $filename); // Upload to the 'videos' directory
    //         return $filename;
    //     }
    //     return null; // Return null if no file is uploaded
    // }



    // function pdf($request)
    // {
    //     //DD('HELLO');
    //     // Check if the request contains a file input named 'pdf'
    //     if ($request->hasFile('pdf')) {
    //         // Retrieve the file
    //         $file = $request->file('pdf');
            
    //         // Get the file extension
    //         $extension = $file->getClientOriginalExtension();
            
    //         // Generate a unique filename based on the current timestamp and file extension
    //         $filename = time() . '.' . $extension;
            
    //         // Move the file to the 'documents' directory
    //         $file->move('documents/', $filename);
            
    //         // Return the filename
    //         return $filename;
    //     }
        
    //     // Return null if no file is uploaded
    //     return null;
    // }
    
