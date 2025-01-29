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
        Schema::create('field', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained('forms')->onDelete('no action');
            $table->string('label');
            $table->string('key');
            $table->json('options')->nullable();
            $table->string('placeholder')->nullable();
            $table->boolean('required')->default(false);
            $table->foreignId('field_type_id')->constrained('field_type')->onDelete('no action');
            $table->integer('sequence')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field');
    }
};
