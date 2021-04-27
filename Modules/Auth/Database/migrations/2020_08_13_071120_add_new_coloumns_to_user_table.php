<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColoumnsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('phone')->nullable();

            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->change();
            }

            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable();
            }

            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'banned_at')) {
                $table->timestamp('banned_at')->nullable();
            }

            if (!Schema::hasColumn('users', 'activation_code')) {
                $table->string('activation_code')->nullable();
            }

            if (!Schema::hasColumn('users', 'level')) {
                $table->integer('level')->default(1);
            }

            if (!Schema::hasColumn('users', 'last_online')) {
                $table->timestamp('last_online')->nullable();
            }

            if (!Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }

            if (!Schema::hasColumn('users', 'meta')) {
                $table->json('meta')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable();
            $table->dropColumn('avatar');
            $table->dropColumn('banned_at');
            $table->dropColumn('activation_code');
            $table->dropColumn('level');
            $table->dropColumn('last_online');
            $table->dropColumn('deleted_at');
            $table->dropColumn('meta');
        });
    }
}
