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
                'kode' => "0000",
                'name' => "Administrator Fakultas", 
                'username' => "admin", 
                'password' => bcrypt("123456"),
                'level' => 1, 
                'email' => "adminFakultas@gmail.com", 
            ],
            [
                'kode' => "0001",
                'name' => "Dekan", 
                'username' => "dekan", 
                'password' => bcrypt("123456"),
                'level' => 0, 
                'email' => "dekan@gmail.com", 
            ],
            [
                'kode' => "0101",
                'name' => "Kadep Matematika", 
                'username' => "kadepMatematika", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadepMatematika@gmail.com", 
            ],
            [
                'kode' => "0100",
                'name' => "Administrator Matematika", 
                'username' => "adminMatematika", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "adminMatematika@gmail.com", 
            ],
            [
                'kode' => "0201",
                'name' => "Kadep Biologi", 
                'username' => "kadepBiologi", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadepBiologi@gmail.com", 
            ],
            [
                'kode' => "0200",
                'name' => "Administrator Biologi", 
                'username' => "adminBiologi", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "adminBiologi@gmail.com", 
            ],
            [
                'kode' => "0301",
                'name' => "Kadep Kimia", 
                'username' => "kadepKimia", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadepKimia@gmail.com", 
            ],
            [
                'kode' => "0300",
                'name' => "Administrator Kimia", 
                'username' => "adminKimia", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "adminKimia@gmail.com", 
            ],
            [
                'kode' => "0401",
                'name' => "Kadep Fisika", 
                'username' => "kadepFisika", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadepFisika@gmail.com", 
            ],
            [
                'kode' => "0400",
                'name' => "Administrator Fisika", 
                'username' => "adminFisika", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "adminFisika@gmail.com", 
            ],
            [
                'kode' => "0501",
                'name' => "Kadep Statistika", 
                'username' => "kadepStatistika", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadepStatistika@gmail.com", 
            ],
            [
                'kode' => "0500",
                'name' => "Administrator Statistika", 
                'username' => "adminStatistika", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "adminStatistika@gmail.com", 
            ],
            [
                'kode' => "0601",
                'name' => "Kadep Informatika", 
                'username' => "kadepInformatika", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "kadepInformatika@gmail.com", 
            ],
            [
                'kode' => "0600",
                'name' => "Administrator Informatika", 
                'username' => "adminInformatika", 
                'password' => bcrypt("123456"),
                'level' => 2, 
                'email' => "adminInformatika@gmail.com", 
            ],
        ];

        foreach($user as $key => $value){
            User::create($value);
        }
    }
}