<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Isabella", //'name' => $reques->name,
            'email' => "isabella@email.com", //'email' => $request->email,
            'password' => Hash::make("123456"), 
                        //'password' => Hash::make($request->password),
            'role' => 'ADM', //'role' => 'ADM', 
        ]);

        User::create([
            'name' => "Isabelle", //'name' => $reques->name,
            'email' => "isabelle@email.com", //'email' => $request->email,
            'password' => Hash::make("123456"), 
                        //'password' => Hash::make($request->password),
            'role' => 'ADM', //'role' => 'CLI', 
        ]);

        User::create([
            'name' => "Juliana", //'name' => $reques->name,
            'email' => "juliana@email.com", //'email' => $request->email,
            'password' => Hash::make("123456"), 
                        //'password' => Hash::make($request->password),
            'role' => 'ATD', //'role' => 'CLI', 
        ]);

        User::create([
            'name' => "Kamily", //'name' => $reques->name,
            'email' => "kamily@email.com", //'email' => $request->email,
            'password' => Hash::make("123456"), 
                        //'password' => Hash::make($request->password),
            'role' => 'TEC', //'role' => 'CLI', 
        ]);
    }
}
