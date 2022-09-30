<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // testsテーブルが存在しないときに実行
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('image');
                $table->text('body');
                $table->foreignId('user_id')
                    ->constrained()//foreignIdとセット
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
                $table->foreignId('category_id')
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
