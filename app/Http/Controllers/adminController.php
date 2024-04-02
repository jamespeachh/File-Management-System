<?php

namespace App\Http\Controllers;

use App\Models\BookBody;
use App\Models\passwords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
        $this->insertOrReplace(61, 'dune_vol_1', 7);
    }

    public function insertOrReplace($pages, $bookTitle, $bookID)
    {
//        for($i=1; $i<=$pages; $i++)
//        {
//            $curBook = Storage::disk('books')
//                ->get($bookTitle.'/'.$bookTitle.'_'.$i.'.txt');
//
//            dd("do not have wipe yet, just wait or change this");
//            BookBody::query()->insert([
//                'book_id'=>$bookID,
//                'page_number'=>$i,
//                'body_text'=>$curBook
//            ]);
//        }
    }

    public function pullChanges()
    {
        dump('sh '.env('LOCAL_PATH_TO_PROJECT').'pull.sh');
        dump(env('LOCAL_PATH_TO_PROJECT'));
        dump(shell_exec('sh '.env('LOCAL_PATH_TO_PROJECT').'pull.sh'));
    }

    public function submit(Request $request)
    {
        $BookBodies = $request->input('book_bodies');
        $pull = $request->input('pull');

        if($BookBodies == 'on') $this->buildAllBooksFromSFTP();
        if($pull == 'on') $this->pullChanges();

        $bookTitle = $request->input('bookTitle');
        $finalCheck = $request->input('add_book_final_check');

        if($request->input('create_link') == 'on')
        {
            $passwordIDLinkGen = $request->input('passwordID');
            $userIDLinkGen = $request->input('userID');

            $url = URL::temporarySignedRoute(
                'sendPassword', now()->addMinutes(30), [
                        'userID' => $userIDLinkGen,
                        'passwordID' => $passwordIDLinkGen
                    ]
            );
            dump($url);
        }


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

    public function addPassword(Request $request)
    {
        $p = new passwords();
        if ($request->has('password'))
        {
            $password = $request->input('password');
        }
        if ($request->has('username'))
        {
            $username = $request->input('username');
        }
        if ($request->has('website'))
        {
            $website = $request->input('website');
        }
        if($password != null && $username != null && $website != null)
        {
            $final = $p->addPassword($password, $username, $website);
            dd($final);
        } else dd('password not submitted');
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

    public function sendPassword($passwordID, $userID)
    {
        if(Auth::id() == $userID)
        {
            $passwords = new passwords();
            $results = $passwords->getPasswordByID($passwordID);

            echo "website";
            dump($results['website']);
            echo "username";
            dump($results['username']);
            echo "password";
            dump($results['password']);
        }else abort(401);
    }
}
