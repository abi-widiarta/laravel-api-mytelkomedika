<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminsData = [
            [
                "name" => "Novita Sari",
                "username"=> "novitasari",
                "email" => "novitasari@gmail.com",
                "password" => "AAAAa1!",
            ],
        ];

        foreach ($adminsData as $data) {
            Admin::create([
                "name" => $data['name'],
                "username"=> $data['username'],
                "email" => $data['email'],
                "password" => bcrypt($data['password']),
            ]);
        }
    }
}
