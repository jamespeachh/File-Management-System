<?php

namespace App\Http\Controllers;

use App\Models\BookBody;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class adminController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        if($id == 1){
            return view('admin');
        }
        return view('home');
    }
    private function buildAllBooksFromSFTP()
    {
        $this->insertOrReplace(23, '1984', 1);
        $this->insertOrReplace(79, '1Q84', 2);
        $this->insertOrReplace(60, 'ADarkerShadeOfMagic', 3);
        $this->insertOrReplace(31, 'BalladOfSongbirdsAndSnakes', 4);
        $this->insertOrReplace(28, 'circe', 5);
        $this->insertOrReplace(11, 'thestranger', 6);
    }

    public function insertOrReplace($pages, $bookTitle, $bookID)
    {
        for($i=1; $i<=$pages; $i++)
        {
            $curBook = Storage::disk('books')
                ->get($bookTitle.'/'.$bookTitle.'_'.$i.'.txt');

            dd("do not have wipe yet, just wait or change this");
            BookBody::query()->insert([
                'book_id'=>$bookID,
                'page_number'=>$i,
                'body_text'=>$curBook
            ]);
        }
    }

    public function pullChanges()
    {
        dump('sh '.env('LOCAL_PATH_TO_PROJECT').'pull.sh');
        dump(shell_exec('sh '.env('LOCAL_PATH_TO_PROJECT').'pull.sh'));
    }

    public function submit(Request $request)
    {
        $cover = $request->input('cover_img');
        $BookBodies = $request->input('book_bodies');
        $pull = $request->input('pull');

        if($BookBodies == 'on') $this->buildAllBooksFromSFTP();
        if($pull == 'on') $this->pullChanges();

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
                $allowed = array('gif', 'png', 'jpg', 'jpeg');
                $ext = pathinfo($cover, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    File::put(public_path('BookCover/' . $cover), $cover);
                }
                dd('EXTENSION: ',$ext, "COVER: $cover", pathinfo($cover, PATHINFO_EXTENSION));


                $this->convertBook($bookTitle, $subTitleContent, $fullBookContent);


            }else dd('failed');
        }
    }

    public function convertBook($bookTitle, $subTitleContent, $fullBookContent, $cover)
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
        $numberInArray = [];
        for ($i = 1; $i <= count($subtitleArray); $i++) {
            $numberInArray[$i] = 0;
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
                    if (!$numberInArray[$i]) $numberInArray[$subtitleArray[$i]] = 0;
                    $numberInArray[$i]++;
                    dump("Section saved to $filename\n From: $subtitleArray[$i]");
                    ERROR_LOG( "Section saved to $filename\n");
                    $j++;
                }
            } else {
                echo "No matches found\n";
            }
        }
        dump($numberInArray);
        dump(Storage::disk('books')->delete('defa/'));
    }
}
