<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Extend the enum temporarily to include legacy values
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('new','process','pending','processing','shipped','delivered','cancel','cancelled','refunded') NOT NULL DEFAULT 'new'");
        DB::statement("ALTER TABLE `orders` MODIFY `payment_status` ENUM('paid','unpaid','pending','failed','refunded') NOT NULL DEFAULT 'unpaid'");

        // Normalize legacy data values
        DB::statement("UPDATE `orders` SET `status` = 'processing' WHERE `status` = 'process'");
        DB::statement("UPDATE `orders` SET `status` = 'cancelled' WHERE `status` = 'cancel'");

        // Final clean-up of the status enum
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('new','pending','processing','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'new'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `orders` MODIFY `status` ENUM('new','process','delivered','cancel') NOT NULL DEFAULT 'new'");
        DB::statement("ALTER TABLE `orders` MODIFY `payment_status` ENUM('paid','unpaid') NOT NULL DEFAULT 'unpaid'");
    }
};
