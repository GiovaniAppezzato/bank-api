<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                "name"       =>  "admin",
                "email"      =>  "admin@gmail.com",
                "cpf"        =>  "83795750083",
                "password"   =>  Hash::make("123456"),
                "birth"      =>  "2000-04-03",
                "sex"        =>  "M",
                "created_at" =>  now(),
                "updated_at" =>  now()
            ]
        ]);
    }
}
