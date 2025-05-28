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
        Schema::create('weather_records', function (Blueprint $table) {
            $table->id(); // Columna 'id' autoincrementable y clave primaria
            $table->string('city_name'); // Columna para el nombre de la ciudad (cadena de texto)
            $table->json('weather_data'); // Columna para los datos JSON del clima
            $table->timestamp('consulted_at'); // Columna para la fecha y hora de la consulta
            $table->timestamps(); // Columnas 'created_at' y 'updated_at' (por defecto de Laravel)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_records');
    }
};
