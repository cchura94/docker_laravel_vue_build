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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->decimal("precio", 12, 2);
            $table->integer("stock")->default(0);
            $table->string("imagen")->nullable();
            $table->text("descripcion")->nullable();
            $table->boolean("estado")->default(true);
            $table->bigInteger("categoria_id")->unsigned();
            // N:1
            $table->foreign("categoria_id")->references("id")->on("categorias");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
