<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesPermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);
        });
        $existed = DB::table('permissions')->count();
        if ($existed == 0) {
            DB::table('permissions')->insert([
                ['name' => 'browse-admin', 'label' => 'Browse Admin'],
                ['name' => 'browse-users', 'label' => 'Browse Users'],
                ['name' => 'browse-roles', 'label' => 'Browse Roles'],
                ['name' => 'browse-permissions', 'label' => 'Browse Permissions'],
                ['name' => 'browse-activitylogs', 'label' => 'Browse Activitylogs'],
                ['name' => 'browse-settings', 'label' => 'Browse Settings'],
                ['name' => 'browse-generator', 'label' => 'Browse Generator'],
            ]);
            DB::table('users')->insert([
                ['name' => 'admin', 'email' => 'admin@admin.com', 'password' => bcrypt('admin')],
                ['name' => 'user', 'email' => 'user@user.com', 'password' => bcrypt('user')],
            ]);
            DB::table('roles')->insert([
                ['name' => 'admin', 'label' => 'Admin']
                ['name' => 'user', 'label' => 'User']
            ]);
            DB::table('role_user')->insert([
                ['user_id' => 1, 'role_id' => 1],
                ['user_id' => 2, 'role_id' => 2],
            ]);
            DB::table('permission_role')->insert([
                ['role_id' => 1, 'permission_id' => 1],
                ['role_id' => 1, 'permission_id' => 2],
                ['role_id' => 1, 'permission_id' => 3],
                ['role_id' => 1, 'permission_id' => 4],
                ['role_id' => 1, 'permission_id' => 5],
                ['role_id' => 1, 'permission_id' => 6],
                ['role_id' => 1, 'permission_id' => 7],
                ['role_id' => 2, 'permission_id' => 1],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('role_user');
        Schema::drop('roles');
        Schema::drop('permissions');
    }
}
