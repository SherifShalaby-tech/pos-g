<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_data = [
            'name' => 'superadmin',
            'email' => 'superadmin@sherifshalaby.tech',
            'password' => Hash::make('123456'),
            'is_superadmin' => 1,
            'is_admin' => 0,
            'is_detault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $user = User::firstOrCreate($user_data);

        $employee_data = [
            'user_id' => $user->id,
            'employee_name' => $user->name,
            'date_of_start_working' => Carbon::now(),
            'date_of_birth' => '1995-02-03',
            'annual_leave_per_year' => '10',
            'sick_leave_per_year' => '10',
            'mobile' => '123456789',
        ];

        Employee::firstOrCreate($employee_data);

        $user_data = [
            'name' => 'Admin',
            'email' => 'admin@sherifshalaby.tech',
            'password' => Hash::make('123456'),
            'is_superadmin' => 0,
            'is_admin' => 1,
            'is_detault' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        $user = User::firstOrCreate($user_data);

        $employee_data = [
            'user_id' => $user->id,
            'employee_name' => $user->name,
            'date_of_start_working' => Carbon::now(),
            'date_of_birth' => '1995-02-03',
            'annual_leave_per_year' => '10',
            'sick_leave_per_year' => '10',
            'mobile' => '123456789',
        ];

        Employee::firstOrCreate($employee_data);
    }
}
