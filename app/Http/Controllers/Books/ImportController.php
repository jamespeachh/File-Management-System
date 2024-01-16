<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Services\BookListAppendService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

    public function submitForm(Request $request)
    {
        $BLCache = new BookListAppendService();
        $BLData = $BLCache->getBookList();

        // Get New book information from the form
        $bookName = $request->input('bookName');
        $password = $request->input('password');
        $cover = $request->input('cover_img');

        if ($password == env('JSON_UPDATE_PASSWORD')) {
            $data = json_decode($BLData, true);

            // Get ready all the new data for addition
            $data['books'][$bookName] = [
                "url" => $request->input('url'),
                "title" => $request->input('title_formatted'),
                "unformatted" => $bookName,
                "pages" => $request->input('pages'),
                "img" => [
                    "src" => $request->input('img_src'),
                    "alt" => $request->input('img_alt')
                ]
            ];

            // Encode the modified data back to json
            $newJsonContents = json_encode($data, JSON_PRETTY_PRINT);

            Storage::disk('books')->delete('bookList.json');
            Storage::disk('books')->put('bookList.json', $newJsonContents);
            Cache::forget('bookList');

            $allowed = array('gif', 'png', 'jpg', 'jpeg');
            $ext = pathinfo($cover, PATHINFO_EXTENSION);
            if (in_array($ext, $allowed)) {
                File::put(public_path('BookCover/' . $cover), $cover);
            }

        }

        return redirect(route('directory'))->with('success', 'Files uploaded successfully.');

    }
}
