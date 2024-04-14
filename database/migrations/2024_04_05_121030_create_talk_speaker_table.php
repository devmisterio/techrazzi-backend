<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('talk_speaker', function (Blueprint $table) {
            $table->unsignedBigInteger('talk_id');
            $table->unsignedBigInteger('speaker_id');
            $table->foreign('talk_id')->references('id')->on('talks')->onDelete('cascade');
            $table->foreign('speaker_id')->references('id')->on('speakers')->onDelete('cascade');
            $table->primary(['talk_id', 'speaker_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talk_speaker');
    }
};
