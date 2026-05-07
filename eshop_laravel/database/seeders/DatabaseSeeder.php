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
        $categoryNameById = [];
        foreach ($categories as $catName) {
            $category = Kategoria::create(['nazov' => $catName]);
            $categoryModels[] = $category;
            $categoryNameById[$category->id] = $category->nazov;
        }

        $products = [
            ['nazov' => 'Biele tričko', 'cena' => 19.99, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 10, 'na_predajni' => true, 'na_objednavku' => false],
            ['nazov' => 'Čierna mikina', 'cena' => 29.99, 'kategoria_id' => $categoryModels[1]->id, 'znacka_id' => $brandModels[1]->znacka_id, 'skladom' => 5, 'na_predajni' => true, 'na_objednavku' => false],
            ['nazov' => 'Modré rifle', 'cena' => 39.99, 'kategoria_id' => $categoryModels[6]->id, 'znacka_id' => $brandModels[5]->znacka_id, 'skladom' => 15, 'na_predajni' => false, 'na_objednavku' => false],
            ['nazov' => 'Letné šaty', 'cena' => 24.99, 'kategoria_id' => $categoryModels[15]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 8, 'na_predajni' => true, 'na_objednavku' => true],
            ['nazov' => 'Jesenná bunda', 'cena' => 59.99, 'kategoria_id' => $categoryModels[12]->id, 'znacka_id' => $brandModels[2]->znacka_id, 'skladom' => 3, 'na_predajni' => false, 'na_objednavku' => true],
            ['nazov' => 'Rifľová sukňa', 'cena' => 14.99, 'kategoria_id' => $categoryModels[2]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 12, 'na_predajni' => true, 'na_objednavku' => false],
            ['nazov' => 'Biela košeľa', 'cena' => 19.99, 'kategoria_id' => $categoryModels[13]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 20, 'na_predajni' => false, 'na_objednavku' => false],
            ['nazov' => 'Károvaná košeľa', 'cena' => 34.99, 'kategoria_id' => $categoryModels[13]->id, 'znacka_id' => $brandModels[3]->znacka_id, 'skladom' => 7, 'na_predajni' => true, 'na_objednavku' => false],
            ['nazov' => 'Hnedé kraťasy', 'cena' => 22.99, 'kategoria_id' => $categoryModels[7]->id, 'znacka_id' => $brandModels[4]->znacka_id, 'skladom' => 11, 'na_predajni' => true, 'na_objednavku' => true],
            ['nazov' => 'Dámske tričko', 'cena' => 19.99, 'kategoria_id' => $categoryModels[0]->id, 'znacka_id' => $brandModels[0]->znacka_id, 'skladom' => 9, 'na_predajni' => false, 'na_objednavku' => true],
            
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

        foreach ($products as $index => $p) {
            $mainIconPath = 'images/product' . (($index % 9) + 1) . '.png';
            $categoryName = $categoryNameById[$p['kategoria_id']] ?? '';
            $material = $this->inferMaterial($p['nazov'], $categoryName);
            $farba = $this->inferColor($p['nazov'], $categoryName);
            $sezona = $this->inferSeason($p['nazov'], $categoryName);

            Produkt::create([
                'nazov' => $p['nazov'],
                'pouzivatel_id' => $admin->pouzivatel_id,
                'cena' => $p['cena'],
                'cena_bez_zlavy' => null,
                'kategoria_id' => $p['kategoria_id'],
                'znacka_id' => $p['znacka_id'],
                'skladom' => $p['skladom'],
                'material' => $material,
                'farba' => $farba,
                'sezona' => $sezona,
                'na_predajni' => $p['na_predajni'] ?? false,
                'na_objednavku' => $p['na_objednavku'] ?? false,
                // Keep seed icon deterministic across fresh migrations.
                'image_path1' => $mainIconPath,
                'obrazok_hlavny' => $mainIconPath,
            ]);
        }
    }

    private function inferColor(string $productName, string $categoryName): string
    {
        $name = mb_strtolower($productName);
        $category = mb_strtolower($categoryName);

        if (str_contains($name, 'biele') || str_contains($name, 'biela')) return 'biela';
        if (str_contains($name, 'čierne') || str_contains($name, 'čierna')) return 'cierna';
        if (str_contains($name, 'modré') || str_contains($name, 'modrá')) return 'modra';
        if (str_contains($name, 'červené') || str_contains($name, 'červená')) return 'cervena';
        if (str_contains($name, 'zelené') || str_contains($name, 'zelená')) return 'zelena';
        if (str_contains($name, 'hnedé') || str_contains($name, 'hnedá')) return 'cervena';
        if (str_contains($name, 'sivé') || str_contains($name, 'sivá')) return 'cierna';
        if (str_contains($name, 'žlté') || str_contains($name, 'žltá')) return 'biela';

        // Deterministic palette by category for realistic defaults.
        if (str_contains($category, 'tričká') || str_contains($category, 'košele') || str_contains($category, 'mikiny')) {
            $palette = ['cierna', 'biela', 'modra', 'cervena', 'zelena'];
        } elseif (str_contains($category, 'šaty') || str_contains($category, 'sukne')) {
            $palette = ['cierna', 'cervena', 'modra'];
        } elseif (str_contains($category, 'nohavice') || str_contains($category, 'kraťasy')) {
            $palette = ['cierna', 'modra', 'biela'];
        } elseif (str_contains($category, 'topánky') || str_contains($category, 'tenisky') || str_contains($category, 'vysoké podpätky')) {
            $palette = ['cierna', 'biela', 'cervena'];
        } else {
            $palette = ['cierna', 'biela', 'modra'];
        }

        return $palette[crc32($productName) % count($palette)];
    }

    private function inferMaterial(string $productName, string $categoryName): string
    {
        $name = mb_strtolower($productName);
        $category = mb_strtolower($categoryName);

        if (str_contains($name, 'rif') || str_contains($name, 'denim')) return 'Denim';
        if (str_contains($name, 'kožen')) return 'Koža';

        // Deterministic "random" material pools by category.
        if (str_contains($category, 'tričká') || str_contains($category, 'košele') || str_contains($category, 'tielka')) {
            $pool = ['Bavlna', 'Viskóza', 'Polyester'];
        } elseif (str_contains($category, 'mikiny') || str_contains($category, 'bundy')) {
            $pool = ['Polyester', 'Bavlna', 'Vlna'];
        } elseif (str_contains($category, 'sukne') || str_contains($category, 'šaty')) {
            $pool = ['Viskóza', 'Bavlna', 'Elastan'];
        } elseif (str_contains($category, 'nohavice') || str_contains($category, 'kraťasy')) {
            $pool = ['Denim', 'Bavlna', 'Elastan'];
        } elseif (str_contains($category, 'topánky') || str_contains($category, 'tenisky') || str_contains($category, 'vysoké podpätky')) {
            $pool = ['Koža', 'Polyester'];
        } elseif (str_contains($category, 'spodné prádlo') || str_contains($category, 'ponožky')) {
            $pool = ['Elastan', 'Bavlna'];
        } elseif (str_contains($category, 'šiltovky') || str_contains($category, 'doplnky')) {
            $pool = ['Polyester', 'Bavlna'];
        } else {
            $pool = ['Bavlna', 'Polyester'];
        }

        return $pool[crc32($productName . '|' . $categoryName) % count($pool)];
    }

    private function inferSeason(string $productName, string $categoryName): string
    {
        $name = mb_strtolower($productName);
        $category = mb_strtolower($categoryName);

        if (str_contains($name, 'zimná') || str_contains($name, 'jesenn')) return 'Jeseň/Zima';
        if (str_contains($name, 'letn')) return 'Jar/Leto';

        if (str_contains($category, 'bundy') || str_contains($category, 'mikiny')) return 'Jeseň/Zima';
        if (str_contains($category, 'kraťasy') || str_contains($category, 'tielka') || str_contains($category, 'šaty') || str_contains($category, 'sukne')) return 'Jar/Leto';
        if (str_contains($category, 'ponožky') || str_contains($category, 'spodné prádlo')) return 'Celoročné';
        if (str_contains($category, 'topánky') || str_contains($category, 'tenisky') || str_contains($category, 'vysoké podpätky')) return 'Celoročné';
        return 'Celoročné';
    }
}
