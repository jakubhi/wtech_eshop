<?php

namespace App\Http\Controllers;

use App\Models\Produkt;
use App\Models\Kategoria;
use App\Models\Znacka;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produkt::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('nazov', 'ILIKE', "%{$search}%");
        }

        if ($request->filled('category_id')) {
            $query->where('kategoria_id', $request->input('category_id'));
        }

        if ($request->filled('brand_id')) {
            $query->whereIn('znacka_id', (array) $request->input('brand_id'));
        }

        if ($request->filled('availability')) {
            $query->where('skladom', '>', 0);
        }

        if ($request->filled('availability_order')) {
            $query->where('na_objednavku', true);
        }

        if ($request->filled('availability_store')) {
            $query->where('na_predajni', true);
        }

        if ($request->filled('price_from')) {
            $query->where('cena', '>=', $request->input('price_from'));
        }
        if ($request->filled('price_to')) {
            $query->where('cena', '<=', $request->input('price_to'));
        }

        $sort = $request->input('sort', 'nazov_asc');
        
        switch ($sort) {
            case 'cena_asc':
                $query->orderBy('cena', 'asc');
                break;
            case 'cena_desc':
                $query->orderBy('cena', 'desc');
                break;
            case 'nazov_desc':
                $query->orderBy('nazov', 'desc');
                break;
            case 'nazov_asc':
            default:
                $query->orderBy('nazov', 'asc');
                break;
        }

        $products = $query->paginate(8)->withQueryString();
        $categories = Kategoria::all();
        $brands = Znacka::all();

        return view('pages.product_category_page', compact('products', 'categories', 'brands'));
    }

    public function show($id)
    {
        $product = Produkt::with(['kategoria', 'znacka'])->findOrFail($id);
        return view('pages.product_page', compact('product'));
    }
}
