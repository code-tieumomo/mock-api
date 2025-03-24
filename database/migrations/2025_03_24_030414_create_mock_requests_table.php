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
        Schema::create('mock_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_api_id')->constrained('mock_apis')->onDelete('cascade');
            $table->string('method');
            $table->string('endpoint');
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->integer('status')->default(200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_requests');
    }
};
