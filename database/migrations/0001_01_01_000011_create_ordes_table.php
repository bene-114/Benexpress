<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('vendor_profile_id')->constrained('vendor_profiles')->onDelete('restrict');
            $table->enum('delivery_type', ['recoleccion', 'domicilio']);
            $table->text('delivery_address')->nullable();
            $table->string('delivery_reference', 255)->nullable();
            $table->string('delivery_phone', 20)->nullable();
            $table->decimal('delivery_cost', 10, 2)->default(0.00);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('payment_method', ['efectivo', 'transferencia']);
            $table->enum('status', ['pendiente', 'confirmado', 'en_preparacion', 'en_ruta', 'listo_recoger', 'entregado', 'cancelado'])->default('pendiente');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};