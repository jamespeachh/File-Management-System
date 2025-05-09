<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('epub_migrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('old_book_id');
            $table->string('epub_filename');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'failed']);
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index('old_book_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('epub_migrations');
    }
}; 