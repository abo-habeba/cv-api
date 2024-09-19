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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->string('path'); // مسار الصورة
            $table->string('type')->nullable();
            $table->string('imageable_type'); // نوع العلاقة polymorphic
            $table->unsignedBigInteger('imageable_id'); // id الخاص بالكيان المتعلق بالصورة
            $table->timestamps();

            $table->index(['imageable_type', 'imageable_id']); // فهرس للبحث السريع
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
