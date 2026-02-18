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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->unique()->after('email');
            $table->string('username')->unique()->after('name');
            $table->string('referral_code')->unique()->after('username');
            $table->unsignedBigInteger('referred_by')->nullable()->after('referral_code');
            $table->boolean('is_verified')->default(false)->after('password');
            $table->decimal('balance', 15, 2)->default(0)->after('is_verified');
            $table->decimal('coins_balance', 15, 2)->default(0)->after('balance');
            $table->enum('status', ['active', 'suspended'])->default('active')->after('coins_balance');

            $table->foreign('referred_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['referred_by']);
            $table->dropColumn(['phone', 'username', 'referral_code', 'referred_by', 'is_verified', 'balance', 'coins_balance', 'status']);
        });
    }
};
