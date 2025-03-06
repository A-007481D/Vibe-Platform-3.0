<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQrcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('qrcodes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sender_id')->constrained(); // Assurez-vous que sender_id est lié à l'utilisateur
        $table->string('token', 60)->unique(); // Assure-toi que `token` est unique
        $table->timestamp('expires_at');
        $table->boolean('accepted')->default(false);
        $table->string('qr_code')->nullable(); // Assure-toi que qr_code est bien nullable
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qrcodes');
    }
}
