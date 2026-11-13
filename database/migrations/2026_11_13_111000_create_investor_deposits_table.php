<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investor_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained('investors')->cascadeOnDelete();
            $table->enum('type', ['deposit', 'withdrawal'])->default('deposit');
            $table->unsignedBigInteger('amount')->comment('Nominal setoran/penarikan modal pokok');
            $table->date('date')->comment('Tanggal transaksi setoran/penarikan');
            $table->string('notes')->nullable()->comment('Keterangan atau peruntukan modal');
            $table->string('proof_attachment')->nullable()->comment('Lampiran bukti transfer atau kwitansi');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Seed data awal: Untuk investor Arief, catatkan modal awal Rp 6.600.000
        $arief = DB::table('investors')->where('email', 'dataku.ak47@gmail.com')->orWhere('name', 'like', '%Arief%')->first();
        if ($arief) {
            DB::table('investor_deposits')->insert([
                'investor_id'      => $arief->id,
                'type'             => 'deposit',
                'amount'           => 6600000,
                'date'             => '2026-10-01',
                'notes'            => 'Setoran Modal Pokok Awal (2 Unit ThinkPad X1 Carbon Gen 7th)',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('investor_deposits');
    }
};

