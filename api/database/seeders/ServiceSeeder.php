<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::factory(5)->create();

        //        $count = intval(Service::count() / 2);
        //
        //        User::employee()->each(function (User $employee) use ($count) {
        //            $employee->services()->attach(Service::pluck('id')->random($count));
        //        });
    }
}
