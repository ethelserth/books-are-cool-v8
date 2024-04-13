<?php

Use App\Models\User;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // $table->foreignIdFor(User::class);
            
            //vissibles
            $table->string('title');
            $table->string('author');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('image')->nullable();

            //seo
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            
            //dates
            $table->timestamp('published_at')->nullable();
            
            //utils
            $table->boolean('enabled')->default(true);
            $table->boolean('featured')->default(false);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
