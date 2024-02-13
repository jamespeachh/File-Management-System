<?php

namespace App\Http\Controllers;

use App\Models\book;
use App\Models\BookBody;
use App\Models\User;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
//        dd(BookBody::query()->count('book_int'));
//        dd(shell_exec('sh '.env('LOCAL_PATH_TO_PROJECT').'pull.sh'));
        return view('test');
    }
    public function submit(Request $request)
    {
        $BookBodies = $request->input('book_bodies');
        $pull = $request->input('pull');
        $bookTitle = $request->input('bookTitle');
        $finalCheck = $request->input('add_book_final_check');
        if($finalCheck == 'on')
        {
            if ($request->hasFile('full_book'))
            {
                $fullBook = $request->file('full_book');
                $fullBookContent = file_get_contents($fullBook->path());
            }

            if ($request->hasFile('sub_title_file'))
            {
                $subTitleFile = $request->file('sub_title_file');
                $subTitleContent = file_get_contents($subTitleFile->path());
            }

            if ($request->hasFile('sub_title_file') && $request->hasFile('full_book') && $bookTitle != Null)
            {
                $this->convertBook($bookTitle, $subTitleContent, $fullBookContent);
            }
        }

    }

    public function convertBook($bookTitle, $subTitleContent, $fullBookContent)
    {
        dump(Storage::disk('books')->delete($bookTitle.'/'));
        dump(Storage::disk('books')->delete('defa/'));
        $pattern = "/\n{1}(.*?)(?=\n{1}|$)/s";
        $subtitleArray = [];
        if (preg_match_all($pattern, $subTitleContent, $matches)) {
            foreach ($matches[1] as $index => $section) {
                $subtitleArray[$index+1] = $section;
            }
        } else {
            dump("No matches found\n");
        }
        dump($subtitleArray);

        Storage::disk('books')->makeDirectory('defa');
        $pattern = "/\n{5}(.*?)(?=\n{5}I\n)/s";

        if (preg_match_all($pattern, $fullBookContent, $matches)) {
            foreach ($matches[1] as $index => $section) {
                $filename = $index+1;
                Storage::disk('books')->put('defa/'.$filename,"\n\n\n\n\n". $section);
                dump("seperation $filename created for $subtitleArray[$filename]");


            }
        } else {
            ERROR_LOG("No matches found\n");
        }

        $pattern = "/\n{5}(.*?)(?=\n{5}|$)/s";
        Storage::disk('books')->makeDirectory($bookTitle);
        $j = 0;
        for ($i = 1; $i <= count($subtitleArray); $i++) {
            $addition = $j;
            $fileContent = Storage::disk('books')->get("defa/$i");
            $prefix = $subtitleArray[$i];

            if (preg_match_all($pattern, $fileContent, $matches)) {
                // Loop through each match
                foreach ($matches[1] as $index => $section) {
                    // Generate a filename for the section (you can adjust this as needed)
                    $filename = $bookTitle.'/'.$bookTitle.'_'.($index+1+$addition).'.txt';
                    Storage::disk('books')->makeDirectory($bookTitle);
                    Storage::disk('books')->put($filename, ($prefix ."\n\n". $section));

                    dump("Section saved to $filename\n");
                    ERROR_LOG( "Section saved to $filename\n");
                    $j++;
                }
            } else {
                echo "No matches found\n";
            }
        }
        dump(Storage::disk('books')->delete('defa/'));
    }
}
