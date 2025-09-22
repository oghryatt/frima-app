<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('shipping_addresses', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // usersテーブルと連携
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // ordersテーブルと連携（任意）
            $table->string('recipient_name'); // 宛名
            $table->string('postal_code', 10); // 郵便番号
            $table->text('address_line'); // 住所詳細（都道府県〜建物名など）
            $table->timestamp('created_at')->useCurrent(); // 登録日時
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};