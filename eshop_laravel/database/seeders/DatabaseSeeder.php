<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kategoria;
use App\Models\Znacka;
use App\Models\Produkt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::create([
            'login' => 'admin',
            'email' => 'admin@eshop.sk',
            'heslo' => Hash::make('admin123'),
            'rola' => 'admin',
        ]);

        User::create([
            'login' => 'zakaznik',
            'email' => 'zakaznik@eshop.sk',
            'heslo' => Hash::make('zakaznik123'),
            'rola' => 'zakaznik',
        ]);

        $brands = [
            'Nike', 'Adidas', 'Puma', 'Zara', 'H&M', 'Levis'
        ];
        $brandModels = [];
        foreach ($brands as $brandName) {
            $brandModels[] = Znacka::create(['nazov' => $brandName]);
        }

        $categories = [
            'Tričká', 'Mikiny', 'Sukne', 'Topánky', 'Tenisky', 'Vysoké podpätky',
            'Nohavice', 'Kraťasy', 'Spodné prádlo', 'Ponožky', 'Šiltovky', 'Tielka',
            'Bundy', 'Košele', 'Doplnky', 'Šaty'
        ];
        $categoryModels = [];
        foreach ($categories as $catName) {
            $categoryModels[] = Kategoria::create(['nazov' => $catName]);
        }

        $products = [
            ['nazov' => 'Biele tričko', 'cena' => 19.99, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 10],
            ['nazov' => 'Čierna mikina', 'cena' => 29.99, 'kategoria_id' => $categoryModels[1]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 5],
            ['nazov' => 'Modré rifle', 'cena' => 39.99, 'kategoria_id' => $categoryModels[6]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 15],
            ['nazov' => 'Letné šaty', 'cena' => 24.99, 'kategoria_id' => $categoryModels[15]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 8],
            ['nazov' => 'Jesenná bunda', 'cena' => 59.99, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 3],
            ['nazov' => 'Rifľová sukňa', 'cena' => 14.99, 'kategoria_id' => $categoryModels[2]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 12],
            ['nazov' => 'Biela košeľa', 'cena' => 19.99, 'kategoria_id' => $categoryModels[13]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 20],
            ['nazov' => 'Károvaná košeľa', 'cena' => 34.99, 'kategoria_id' => $categoryModels[13]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 7],
            ['nazov' => 'Hnedé kraťasy', 'cena' => 22.99, 'kategoria_id' => $categoryModels[7]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 11],
            ['nazov' => 'Dámske tričko', 'cena' => 19.99, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 9],
            
            ['nazov' => 'Nike tričko', 'cena' => 25.50, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 15],
            ['nazov' => 'Adidas mikina', 'cena' => 45.00, 'kategoria_id' => $categoryModels[1]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 8],
            ['nazov' => 'Čierne tepláky', 'cena' => 30.00, 'kategoria_id' => $categoryModels[6]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 20],
            ['nazov' => 'Večerné šaty', 'cena' => 49.99, 'kategoria_id' => $categoryModels[15]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 5],
            ['nazov' => 'Levis 501', 'cena' => 89.99, 'kategoria_id' => $categoryModels[6]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 12],
            ['nazov' => 'Nike tenisky', 'cena' => 120.00, 'kategoria_id' => $categoryModels[4]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 6],
            ['nazov' => 'Letná sukňa', 'cena' => 19.99, 'kategoria_id' => $categoryModels[2]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 18],
            ['nazov' => 'Zimná bunda', 'cena' => 75.50, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 4],
            ['nazov' => 'Adidas šiltovka', 'cena' => 15.00, 'kategoria_id' => $categoryModels[10]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 25],
            ['nazov' => 'Levis tričko', 'cena' => 22.00, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 30],
            ['nazov' => 'Nike kraťasy', 'cena' => 28.00, 'kategoria_id' => $categoryModels[7]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 14],
            ['nazov' => 'Kožená bunda', 'cena' => 99.99, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 2],
            ['nazov' => 'Ponožky 3ks', 'cena' => 5.99, 'kategoria_id' => $categoryModels[9]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 50],
            ['nazov' => 'Tenisky Adidas', 'cena' => 65.00, 'kategoria_id' => $categoryModels[4]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 10],
            ['nazov' => 'Nike tielko', 'cena' => 18.50, 'kategoria_id' => $categoryModels[11]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 22],
            ['nazov' => 'Puma kraťasy', 'cena' => 24.00, 'kategoria_id' => $categoryModels[7]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 16],
            ['nazov' => 'Denimová bunda', 'cena' => 79.99, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 7],
            ['nazov' => 'Topánky Zara', 'cena' => 45.50, 'kategoria_id' => $categoryModels[5]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 9],
            ['nazov' => 'Boxerky 2ks', 'cena' => 12.99, 'kategoria_id' => $categoryModels[8]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 40],
            ['nazov' => 'Nike batoh', 'cena' => 35.00, 'kategoria_id' => $categoryModels[14]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 12],
            ['nazov' => 'Červené tričko', 'cena' => 21.00, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 10],
            ['nazov' => 'Modré tričko', 'cena' => 23.50, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 8],
            ['nazov' => 'Zelené tričko', 'cena' => 18.99, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 15],
            ['nazov' => 'Žlté tričko', 'cena' => 16.50, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 12],
            ['nazov' => 'Sivé tričko', 'cena' => 12.00, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 20],
            ['nazov' => 'Čierne tričko', 'cena' => 25.99, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 5],
            ['nazov' => 'Pruhované tričko', 'cena' => 27.00, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 10],
            ['nazov' => 'Vzorované tričko', 'cena' => 29.50, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 8],
            ['nazov' => 'Tričko Puma', 'cena' => 19.99, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 15],
            ['nazov' => 'Tričko Zara', 'cena' => 22.50, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 12],
        ];

        foreach ($products as $p) {
            Produkt::create([
                'nazov' => $p['nazov'],
                'pouzivatel_id' => $admin->pouzivatel_id,
                'cena' => $p['cena'],
                'kategoria_id' => $p['kategoria_id'],
                'znacka_id' => $p['znacka_id'],
                'skladom' => $p['skladom'],
            ]);
        }
    }
}
