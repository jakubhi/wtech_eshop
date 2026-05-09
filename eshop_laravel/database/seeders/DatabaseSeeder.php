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
            $category = Kategoria::create(['nazov' => $catName]);
            $categoryModels[] = $category;
        }

        $categoryImageById = [
            $categoryModels[0]->id => 'images/product1.png',
            $categoryModels[1]->id => 'images/product2.png',
            $categoryModels[2]->id => 'images/product6.png',
            $categoryModels[6]->id => 'images/product3.png',
            $categoryModels[7]->id => 'images/product9.png',
            $categoryModels[11]->id => 'images/product1.png',
            $categoryModels[12]->id => 'images/product5.png',
            $categoryModels[13]->id => 'images/product7.png',
            $categoryModels[15]->id => 'images/product4.png',
        ];

        $products = [
            ['nazov' => 'Biele tričko', 'cena' => 19.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 10, 'material' => 'Bavlna', 'farba' => 'biela', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product1.png', 'image_path2' => null],
            ['nazov' => 'Čierna mikina', 'cena' => 29.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[1]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 5, 'material' => 'Polyester', 'farba' => 'cierna', 'sezona' => 'Jeseň/Zima', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product2.png', 'image_path2' => null],
            ['nazov' => 'Modré rifle', 'cena' => 39.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[6]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 15, 'material' => 'Denim', 'farba' => 'modra', 'sezona' => 'Celoročné', 'na_predajni' => false, 'na_objednavku' => false, 'image_path1' => 'images/product3.png', 'image_path2' => null],
            ['nazov' => 'Letné šaty', 'cena' => 24.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[15]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 8, 'material' => 'Viskóza', 'farba' => 'cervena', 'sezona' => 'Jar/Leto', 'na_predajni' => true, 'na_objednavku' => true, 'image_path1' => 'images/product4.png', 'image_path2' => 'images/product5.png'],
            ['nazov' => 'Jesenná bunda', 'cena' => 59.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 3, 'material' => 'Polyester', 'farba' => 'cierna', 'sezona' => 'Jeseň/Zima', 'na_predajni' => false, 'na_objednavku' => true, 'image_path1' => 'images/product5.png', 'image_path2' => 'images/product6.png'],
            ['nazov' => 'Rifľová sukňa', 'cena' => 14.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[2]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 12, 'material' => 'Denim', 'farba' => 'modra', 'sezona' => 'Jar/Leto', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product6.png', 'image_path2' => 'images/product7.png'],
            ['nazov' => 'Biela košeľa', 'cena' => 19.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[13]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 20, 'material' => 'Bavlna', 'farba' => 'biela', 'sezona' => 'Celoročné', 'na_predajni' => false, 'na_objednavku' => false, 'image_path1' => 'images/product7.png', 'image_path2' => 'images/product8.png'],
            ['nazov' => 'Károvaná košeľa', 'cena' => 34.99, 'cena_bez_zlavy' => 31.99, 'kategoria_id' => $categoryModels[13]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 7, 'material' => 'Bavlna', 'farba' => 'modra', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product8.png', 'image_path2' => 'images/product9.png'],
            ['nazov' => 'Hnedé kraťasy', 'cena' => 22.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[7]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 11, 'material' => 'Bavlna', 'farba' => 'hneda', 'sezona' => 'Jar/Leto', 'na_predajni' => true, 'na_objednavku' => true, 'image_path1' => 'images/product9.png', 'image_path2' => 'images/product1.png'],
            ['nazov' => 'Dámske tričko', 'cena' => 19.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 9, 'material' => 'Bavlna', 'farba' => 'ruzova', 'sezona' => 'Celoročné', 'na_predajni' => false, 'na_objednavku' => true, 'image_path1' => 'images/product1.png', 'image_path2' => 'images/product2.png'],
            ['nazov' => 'Nike tričko', 'cena' => 25.50, 'cena_bez_zlavy' => 22.90, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 15, 'material' => 'Bavlna', 'farba' => 'cierna', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product2.png', 'image_path2' => 'images/product3.png'],
            ['nazov' => 'Adidas mikina', 'cena' => 45.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[1]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 8, 'material' => 'Polyester', 'farba' => 'siva', 'sezona' => 'Jeseň/Zima', 'na_predajni' => true, 'na_objednavku' => true, 'image_path1' => 'images/product3.png', 'image_path2' => 'images/product4.png'],
            ['nazov' => 'Čierne tepláky', 'cena' => 30.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[6]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 20, 'material' => 'Bavlna', 'farba' => 'cierna', 'sezona' => 'Celoročné', 'na_predajni' => false, 'na_objednavku' => false, 'image_path1' => 'images/product4.png', 'image_path2' => 'images/product5.png'],
            ['nazov' => 'Večerné šaty', 'cena' => 49.99, 'cena_bez_zlavy' => 44.99, 'kategoria_id' => $categoryModels[15]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 5, 'material' => 'Viskóza', 'farba' => 'cierna', 'sezona' => 'Jar/Leto', 'na_predajni' => true, 'na_objednavku' => true, 'image_path1' => 'images/product5.png', 'image_path2' => 'images/product6.png'],
            ['nazov' => 'Levis 501', 'cena' => 89.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[6]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 12, 'material' => 'Denim', 'farba' => 'modra', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product6.png', 'image_path2' => 'images/product7.png'],
            ['nazov' => 'Nike tenisky', 'cena' => 120.00, 'cena_bez_zlavy' => 99.99, 'kategoria_id' => $categoryModels[4]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 6, 'material' => 'Koža', 'farba' => 'biela', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => true, 'image_path1' => 'images/product7.png', 'image_path2' => 'images/product8.png'],
            ['nazov' => 'Letná sukňa', 'cena' => 19.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[2]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 18, 'material' => 'Viskóza', 'farba' => 'zlta', 'sezona' => 'Jar/Leto', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product8.png', 'image_path2' => 'images/product9.png'],
            ['nazov' => 'Zimná bunda', 'cena' => 75.50, 'cena_bez_zlavy' => 69.90, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 4, 'material' => 'Polyester', 'farba' => 'modra', 'sezona' => 'Jeseň/Zima', 'na_predajni' => false, 'na_objednavku' => true, 'image_path1' => 'images/product9.png', 'image_path2' => 'images/product1.png'],
            ['nazov' => 'Adidas šiltovka', 'cena' => 15.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[10]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 25, 'material' => 'Bavlna', 'farba' => 'modra', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product1.png', 'image_path2' => 'images/product2.png'],
            ['nazov' => 'Levis tričko', 'cena' => 22.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 30, 'material' => 'Bavlna', 'farba' => 'siva', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product2.png', 'image_path2' => 'images/product3.png'],
            ['nazov' => 'Nike kraťasy', 'cena' => 28.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[7]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 14, 'material' => 'Polyester', 'farba' => 'cierna', 'sezona' => 'Jar/Leto', 'na_predajni' => true, 'na_objednavku' => true, 'image_path1' => 'images/product3.png', 'image_path2' => 'images/product4.png'],
            ['nazov' => 'Kožená bunda', 'cena' => 99.99, 'cena_bez_zlavy' => 89.99, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 2, 'material' => 'Koža', 'farba' => 'hneda', 'sezona' => 'Jeseň/Zima', 'na_predajni' => false, 'na_objednavku' => true, 'image_path1' => 'images/product4.png', 'image_path2' => 'images/product5.png'],
            ['nazov' => 'Ponožky 3ks', 'cena' => 5.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[9]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 50, 'material' => 'Bavlna', 'farba' => 'biela', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product5.png', 'image_path2' => 'images/product6.png'],
            ['nazov' => 'Tenisky Adidas', 'cena' => 65.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[4]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 10, 'material' => 'Koža', 'farba' => 'modra', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product6.png', 'image_path2' => 'images/product7.png'],
            ['nazov' => 'Nike tielko', 'cena' => 18.50, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[11]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 22, 'material' => 'Bavlna', 'farba' => 'biela', 'sezona' => 'Jar/Leto', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product7.png', 'image_path2' => 'images/product8.png'],
            ['nazov' => 'Puma kraťasy', 'cena' => 24.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[7]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 16, 'material' => 'Polyester', 'farba' => 'cierna', 'sezona' => 'Jar/Leto', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product8.png', 'image_path2' => 'images/product9.png'],
            ['nazov' => 'Denimová bunda', 'cena' => 79.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 7, 'material' => 'Denim', 'farba' => 'modra', 'sezona' => 'Jeseň/Zima', 'na_predajni' => false, 'na_objednavku' => true, 'image_path1' => 'images/product9.png', 'image_path2' => 'images/product1.png'],
            ['nazov' => 'Topánky Zara', 'cena' => 45.50, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[5]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 9, 'material' => 'Koža', 'farba' => 'cierna', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => true, 'image_path1' => 'images/product1.png', 'image_path2' => 'images/product2.png'],
            ['nazov' => 'Boxerky 2ks', 'cena' => 12.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[8]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 40, 'material' => 'Elastan', 'farba' => 'cierna', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product2.png', 'image_path2' => 'images/product3.png'],
            ['nazov' => 'Nike batoh', 'cena' => 35.00, 'cena_bez_zlavy' => 29.99, 'kategoria_id' => $categoryModels[14]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 12, 'material' => 'Polyester', 'farba' => 'cierna', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product3.png', 'image_path2' => 'images/product4.png'],
            ['nazov' => 'Červené tričko', 'cena' => 21.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 10, 'material' => 'Bavlna', 'farba' => 'cervena', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product4.png', 'image_path2' => 'images/product5.png'],
            ['nazov' => 'Modré tričko', 'cena' => 23.50, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 8, 'material' => 'Bavlna', 'farba' => 'modra', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product5.png', 'image_path2' => 'images/product6.png'],
            ['nazov' => 'Zelené tričko', 'cena' => 18.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 15, 'material' => 'Bavlna', 'farba' => 'zelena', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product6.png', 'image_path2' => 'images/product7.png'],
            ['nazov' => 'Žlté tričko', 'cena' => 16.50, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 12, 'material' => 'Bavlna', 'farba' => 'zlta', 'sezona' => 'Celoročné', 'na_predajni' => false, 'na_objednavku' => true, 'image_path1' => 'images/product7.png', 'image_path2' => 'images/product8.png'],
            ['nazov' => 'Sivé tričko', 'cena' => 12.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 20, 'material' => 'Bavlna', 'farba' => 'siva', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product8.png', 'image_path2' => 'images/product9.png'],
            ['nazov' => 'Čierne tričko', 'cena' => 25.99, 'cena_bez_zlavy' => 20.99, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 5, 'material' => 'Bavlna', 'farba' => 'cierna', 'sezona' => 'Celoročné', 'na_predajni' => false, 'na_objednavku' => true, 'image_path1' => 'images/product9.png', 'image_path2' => 'images/product1.png'],
            ['nazov' => 'Pruhované tričko', 'cena' => 27.00, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 10, 'material' => 'Bavlna', 'farba' => 'modra', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product1.png', 'image_path2' => 'images/product2.png'],
            ['nazov' => 'Vzorované tričko', 'cena' => 29.50, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 8, 'material' => 'Bavlna', 'farba' => 'viacfarebna', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product2.png', 'image_path2' => 'images/product3.png'],
            ['nazov' => 'Tričko Puma', 'cena' => 19.99, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 15, 'material' => 'Bavlna', 'farba' => 'cierna', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product3.png', 'image_path2' => 'images/product4.png'],
            ['nazov' => 'Tričko Zara', 'cena' => 22.50, 'cena_bez_zlavy' => null, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 12, 'material' => 'Bavlna', 'farba' => 'biela', 'sezona' => 'Celoročné', 'na_predajni' => true, 'na_objednavku' => false, 'image_path1' => 'images/product4.png', 'image_path2' => 'images/product5.png'],
        ];

        foreach ($products as $p) {
            Produkt::create([
                'nazov' => $p['nazov'],
                'pouzivatel_id' => $admin->pouzivatel_id,
                'cena' => $p['cena'],
                'cena_bez_zlavy' => $p['cena_bez_zlavy'],
                'kategoria_id' => $p['kategoria_id'],
                'znacka_id' => $p['znacka_id'],
                'skladom' => $p['skladom'],
                'material' => $p['material'],
                'farba' => $p['farba'],
                'sezona' => $p['sezona'],
                'na_predajni' => $p['na_predajni'],
                'na_objednavku' => $p['na_objednavku'],
                'image_path1' => $categoryImageById[$p['kategoria_id']] ?? 'images/empty.png',
                'image_path2' => null,
            ]);
        }
    }
}
