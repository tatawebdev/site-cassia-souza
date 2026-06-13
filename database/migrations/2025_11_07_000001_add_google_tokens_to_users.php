<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'google_access_token')) {
                $table->string('google_access_token')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'google_refresh_token')) {
                $table->string('google_refresh_token')->nullable()->after('google_access_token');
            }
            if (!Schema::hasColumn('users', 'google_token_expires_at')) {
                $table->timestamp('google_token_expires_at')->nullable()->after('google_refresh_token');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('users', 'google_access_token')) {
                $columns[] = 'google_access_token';
            }
            if (Schema::hasColumn('users', 'google_refresh_token')) {
                $columns[] = 'google_refresh_token';
            }
            if (Schema::hasColumn('users', 'google_token_expires_at')) {
                $columns[] = 'google_token_expires_at';
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
