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
         Schema::create('article_summaries', function (Blueprint $table) {
             $table->id();
             // article_id column references id column of articles table
             $table->foreignId('article_id')
                 ->constrained('articles')
                 ->cascadeOnDelete()
                 ->unique();
             // Cascade on delete ensures removal when Article models are deleted

             $table->text('summary');
             $table->string('model')->nullable();
             $table->timestamps();
         });
     }

     /**
      * Reverse the migrations.
      */
     public function down(): void
     {
         Schema::dropIfExists('article_summaries');
     }
 };
