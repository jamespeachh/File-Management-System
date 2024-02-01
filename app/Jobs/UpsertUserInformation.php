<?php

namespace App\Jobs;

use App\Models\UserBookMapping;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UpsertUserInformation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var mixed
     */
    protected $bookID;
    protected $pageNumber;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($bookID, $pageNumber)
    {
        $this->bookID = $bookID;
        $this->pageNumber = $pageNumber;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->userMappingExists($this->bookID))
            $this->updatePage($this->bookID, $this->pageNumber);
        else
            $this->insertPage($this->bookID, $this->pageNumber);
    }

    private function userMappingExists($bookID): bool {
        $id = Auth::id();
        $data = UserBookMapping::query()
            ->select()
            ->where(['book_id'=>$bookID])
            ->where(['user_id'=>$id])
            ->count();
        if ($data >= 1)
            return true;
        else
            return false;
    }


    public function updatePage($bookID, $pageNumber) {
        $id = Auth::id();
        UserBookMapping::query()
            ->where(['book_id'=>$bookID])
            ->where(['user_id'=>$id])
            ->update(['page_number' => intval($pageNumber)]);
    }


    public function insertPage($bookID, $pageNumber) {
        $id = Auth::id();
        UserBookMapping::query()->insert([
            'book_id' => intval($bookID),
            'user_id' => intval($id),
            'page_number' => intval($pageNumber)
        ]);
    }
}
