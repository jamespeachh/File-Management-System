<?php

namespace App\Http\Controllers\books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index()
    {
        return view('import');
    }

    public function showUploadForm()
    {
        return view('import');
    }

    public function processUpload(Request $request)
    {
        return redirect()->route('upload.form')->with('success', 'Files uploaded successfully.');
    }
//    {
//        $uploadedFiles = $request->file('files');
//        $folderName = $request->input('folder-name"');
//        $dirName = public_path('Book/' . $folderName);
//
//        if (!File::exists($dirName)) {
//            File::makeDirectory($dirName, 0775, true); // Create the directory recursively
//            $this->info("Directory '$dirName' created successfully.");
//        }
//
//        foreach ($uploadedFiles as $file) {
//            $filename = $file->getClientOriginalName();
//            $file->storeAs('Book/', $filename);
//        }
//
//
//        return redirect()->route('upload.form')->with('success', 'Files uploaded successfully.');
//    }

}
