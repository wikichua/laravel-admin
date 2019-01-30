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
                ['id' => 1, 'name' => 'browse-admin', 'label' => 'Browse Admin'],
                ['id' => 2, 'name' => 'browse-users', 'label' => 'Browse Users'],
                ['id' => 3, 'name' => 'read-users', 'label' => 'Read Users'],
                ['id' => 4, 'name' => 'edit-users', 'label' => 'Edit Users'],
                ['id' => 5, 'name' => 'add-users', 'label' => 'Add Users'],
                ['id' => 6, 'name' => 'delete-users', 'label' => 'Delete Users'],
                ['id' => 7, 'name' => 'browse-roles', 'label' => 'Browse Roles'],
                ['id' => 8, 'name' => 'read-roles', 'label' => 'Read Roles'],
                ['id' => 9, 'name' => 'edit-roles', 'label' => 'Edit Roles'],
                ['id' => 10, 'name' => 'add-roles', 'label' => 'Add Roles'],
                ['id' => 11, 'name' => 'delete-roles', 'label' => 'Delete Roles'],
                ['id' => 12, 'name' => 'browse-permissions', 'label' => 'Browse Permissions'],
                ['id' => 13, 'name' => 'read-permissions', 'label' => 'Read Permissions'],
                ['id' => 14, 'name' => 'edit-permissions', 'label' => 'Edit Permissions'],
                ['id' => 15, 'name' => 'add-permissions', 'label' => 'Add Permissions'],
                ['id' => 16, 'name' => 'delete-permissions', 'label' => 'Delete Permissions'],
                ['id' => 17, 'name' => 'browse-settings', 'label' => 'Browse Settings'],
                ['id' => 18, 'name' => 'read-settings', 'label' => 'Read Settings'],
                ['id' => 19, 'name' => 'edit-settings', 'label' => 'Edit Settings'],
                ['id' => 20, 'name' => 'add-settings', 'label' => 'Add Settings'],
                ['id' => 21, 'name' => 'delete-settings', 'label' => 'Delete Settings'],
                ['id' => 22, 'name' => 'browse-generator', 'label' => 'Browse Generator'],
                ['id' => 23, 'name' => 'setup-generator', 'label' => 'Setup Generator'],
                ['id' => 24, 'name' => 'browse-activitylogs', 'label' => 'Browse Activitylogs'],
                ['id' => 25, 'name' => 'read-activitylogs', 'label' => 'Read Activitylogs'],
                ['id' => 26, 'name' => 'switch-users', 'label' => 'Switch Users'],
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
                ['role_id' => 1, 'permission_id' => 8],
                ['role_id' => 1, 'permission_id' => 9],
                ['role_id' => 1, 'permission_id' => 10],
                ['role_id' => 1, 'permission_id' => 11],
                ['role_id' => 1, 'permission_id' => 12],
                ['role_id' => 1, 'permission_id' => 13],
                ['role_id' => 1, 'permission_id' => 14],
                ['role_id' => 1, 'permission_id' => 15],
                ['role_id' => 1, 'permission_id' => 16],
                ['role_id' => 1, 'permission_id' => 17],
                ['role_id' => 1, 'permission_id' => 18],
                ['role_id' => 1, 'permission_id' => 19],
                ['role_id' => 1, 'permission_id' => 20],
                ['role_id' => 1, 'permission_id' => 21],
                ['role_id' => 1, 'permission_id' => 22],
                ['role_id' => 1, 'permission_id' => 23],
                ['role_id' => 1, 'permission_id' => 24],
                ['role_id' => 1, 'permission_id' => 25],
                ['role_id' => 1, 'permission_id' => 26],
            ]);
            DB::table('permission_role')->insert([
                ['role_id' => 2, 'permission_id' => 1],
                ['role_id' => 2, 'permission_id' => 2],
                ['role_id' => 2, 'permission_id' => 3],
                ['role_id' => 2, 'permission_id' => 7],
                ['role_id' => 2, 'permission_id' => 8],
                ['role_id' => 2, 'permission_id' => 12],
                ['role_id' => 2, 'permission_id' => 13],
                ['role_id' => 2, 'permission_id' => 18],
                ['role_id' => 2, 'permission_id' => 19],
                ['role_id' => 2, 'permission_id' => 24],
                ['role_id' => 2, 'permission_id' => 25],
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
