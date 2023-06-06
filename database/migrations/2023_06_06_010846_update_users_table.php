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
            // 氏名のNullを許容する
            $table->string('name')->nullable()->change();
            // ニックネーム
            $table->string('nickname')->after('name')->unique()->nullable();
            // メールアドレスのユニーク制約を外す
            $table->dropUnique(['email']);
            // created_atとupdated_atのデフォルト値を変更する
            DB::statement('ALTER TABLE users MODIFY created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
            DB::statement('ALTER TABLE users MODIFY updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
            // 郵便番号、都道府県、市区町村、番地、電話番号を追加する
            $table->string('zip_code', 8)->after('email')->nullable();
            $table->string('state')->after('zip_code')->nullable();
            $table->string('city')->after('state')->nullable();
            $table->string('address')->after('city')->nullable();
            // 電話番号を追加する
            $table->string('tel')->after('address')->nullable();
            // 論理削除カラムを追加する
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
            $table->dropColumn('nickname');
            $table->unique(['email']);
            DB::statement('ALTER TABLE users MODIFY created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
            DB::statement('ALTER TABLE users MODIFY updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
            $table->dropColumn('zip_code');
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('address');
            $table->dropColumn('tel');
            $table->dropSoftDeletes();
        });
    }
};
