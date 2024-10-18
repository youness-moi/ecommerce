<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('paymentMethod', ['Cash on Delivery', 'Credit Card', 'PayPal'])->default('Cash on Delivery');
            /*
            pending : Le paiement a été créé mais n'est pas encore finalisé ou confirmé.
            completed : Le paiement a été réalisé avec succès et l'argent a été reçu.
            failed : Le paiement a échoué pour une raison quelconque (ex. erreur de transaction, fonds insuffisants, etc.).
            refunded : Le paiement a été remboursé à l'utilisateur.
            cancelled : Le paiement a été annulé avant ou après avoir été initié.
            */
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending');
            $table->boolean('isCashOnDelivery')->default(true);
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
        Schema::dropIfExists('payments');
    }
};
