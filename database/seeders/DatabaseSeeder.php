<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Menu;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'email' => 'admin@example.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'staff',
            'name' => 'Staff',
            'email' => 'staff@example.test',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);

        User::create([
            'username' => 'user',
            'name' => 'User',
            'email' => 'user@example.test',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://raw.githubusercontent.com/igdev116/free-food-menus-api/main/db.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $data = json_decode($response, true);
        $dessert = $data['sandwiches'];

        foreach ($dessert as $menu) {
            Menu::create([
                'name' => $menu['name'],
                'price' => intval($menu['price']) * 1000,
                'description' => $menu['dsc'],
                'icon' => $menu['img'],
                'rate' => $menu['rate'],
                'status' => 'active',
            ]);
        }
    }
}
