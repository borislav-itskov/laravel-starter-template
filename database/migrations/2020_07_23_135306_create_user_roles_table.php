<?php

use App\Services\UserRoleService;
use App\Services\UserService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // shift the data to here
        $admins = DB::table('users')->whereIsAdmin(1)->get();
        $adminRole = DB::table('roles')->where('name', 'Admin')->get()->first();
        $data = $admins->map(function($admin) use ($adminRole) {
            return ['user_id' => $admin->id, 'role_id' => $adminRole->id];
        })->toArray();

        // add the admins
        $userRoleService = app(UserRoleService::class);
        $userRoleService->bulkInsert($data);

        // drop the is admin
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
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
            $table->boolean('is_admin')->default(0);
        });

        // find the admins
        $adminRole = DB::table('roles')->where('name', 'Admin')->get()->first();
        $admins = DB::table('users')
            ->select('users.*')
            ->leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->where('user_roles.role_id', '=', $adminRole->id)
            ->distinct()
            ->get()
        ;

        // save the admins
        foreach ($admins as $admin) {
            DB::table('users')->where('id', $admin->id)->update(['is_admin' => 1]);
        }

        Schema::dropIfExists('user_roles');
    }
}
