<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => "Administrator Fakultas", 
                'username' => "admin", 
                'password' => bcrypt("123456"),
                'level' => 1, 
                'email' => "adminFakultas@gmail.com", 
            ],
            [
                'name' => "Dekan", 
                'username' => "dekan", 
                'password' => bcrypt("123456"),
                'level' => 0, 
                'email' => "dekan@gmail.com", 
            ],
            [
                'name' => "Kadep Informatika", 
                'username' => "kadepIF", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadepIF@gmail.com", 
            ],
            [
                'name' => "administrator IF", 
                'username' => "adminIF", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "adminIF@gmail.com", 
            ],
        ];

        foreach($user as $key => $value){
            User::create($value);
        }
    }
}