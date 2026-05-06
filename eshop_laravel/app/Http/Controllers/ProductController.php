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

    public function destroy($id)
    {
        $product = Produkt::findOrFail($id);
        $product->delete();
        
        return redirect()->back()->with('success', 'Produkt bol úspešne vymazaný!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nazov' => 'required|string|max:255',
            'popis' => 'nullable|string',
            'kategoria_id' => 'required|integer|min:1',
            'cena' => 'required|numeric|min:0',
            'skladom' => 'required|integer|min:0',
            'znacka_id' => 'required|integer|min:1',
            'material' => 'nullable|string|max:255',
            'farba' => 'required|in:blue,black,white,red,green',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nazov.required' => 'Názov produktu je povinný.',
            'cena.required' => 'Cena je povinná.',
            'cena.numeric' => 'Cena musí byť číslo.',
            'kategoria_id.required' => 'Kategória je povinná.',
            'kategoria_id.integer' => 'ID kategórie musí byť číslo.',
            'znacka_id.required' => 'Značka je povinná.',
            'znacka_id.integer' => 'ID značky musí byť číslo.',
            'farba.required' => 'Farba je povinná.',
            'farba.in' => 'Zvolte platnú farbu.',
            'image1.image' => 'Prvý súbor musí byť obrázok.',
            'image1.mimes' => 'Prvý obrázok musí byť formátu: jpeg, png, jpg, gif.',
            'image1.max' => 'Maximálna veľkosť prvého obrázka je 2MB.',
            'image2.image' => 'Druhý súbor musí byť obrázok.',
            'image2.mimes' => 'Druhý obrázok musí byť formátu: jpeg, png, jpg, gif.',
            'image2.max' => 'Maximálna veľkosť druhého obrázka je 2MB.'
        ]);

        // Handle image uploads with comprehensive error handling
        $imagePath1 = null;
        $imagePath2 = null;
        $timestamp = time();
        
                
        // Ensure upload directory exists
        $uploadPath = public_path('images/products');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Process first image
        if ($request->hasFile('image1')) {
            try {
                $image = $request->file('image1');
                
                // Validate file
                if ($image->isValid()) {
                    $extension = $image->getClientOriginalExtension();
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (!in_array(strtolower($extension), $allowedExtensions)) {
                        throw new \Exception('Nepodporovaný formát obrázka: ' . $extension);
                    }
                    
                    // Create unique filename
                    $imageName = $timestamp . '_1_' . str_replace(' ', '_', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
                    
                    // Move file with error handling
                    if ($image->move($uploadPath, $imageName)) {
                        $imagePath1 = 'images/products/' . $imageName;
                    } else {
                        throw new \Exception('Chyba pri nahrávaní prvého obrázka');
                    }
                } else {
                    throw new \Exception('Neplatný súbor prvého obrázka');
                }
            } catch (\Exception $e) {
                // Log error but continue processing
                \Log::error('Image1 upload error: ' . $e->getMessage());
            }
        }
        
        // Process second image
        if ($request->hasFile('image2')) {
            try {
                $image = $request->file('image2');
                
                // Validate file
                if ($image->isValid()) {
                    $extension = $image->getClientOriginalExtension();
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (!in_array(strtolower($extension), $allowedExtensions)) {
                        throw new \Exception('Nepodporovaný formát obrázka: ' . $extension);
                    }
                    
                    // Create unique filename with different timestamp
                    $imageName = ($timestamp + 1) . '_2_' . str_replace(' ', '_', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
                    
                    // Move file with error handling
                    if ($image->move($uploadPath, $imageName)) {
                        $imagePath2 = 'images/products/' . $imageName;
                    } else {
                        throw new \Exception('Chyba pri nahrávaní druhého obrázka');
                    }
                } else {
                    throw new \Exception('Neplatný súbor druhého obrázka');
                }
            } catch (\Exception $e) {
                // Log error but continue processing
                \Log::error('Image2 upload error: ' . $e->getMessage());
            }
        }

        // Create new product
        $product = new Produkt();
        $product->nazov = $validated['nazov'];
        $product->popis = $validated['popis'];
        $product->cena = $validated['cena'];
        $product->skladom = $validated['skladom'];
        $product->farba = $validated['farba'];
        $product->material = $validated['material'];
        $product->image_path1 = $imagePath1;
        $product->image_path2 = $imagePath2;
        $product->kategoria_id = $validated['kategoria_id'];
        $product->znacka_id = $validated['znacka_id'];
        
        // Handle pouzivatel_id automatically
        $product->pouzivatel_id = auth()->id() ?? 1; // Use logged-in user ID or default to 1
        
        $product->save();

        return redirect('/admin_products_review')->with('success', 'Produkt bol úspešne pridaný!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nazov' => 'required|string|max:255',
            'popis' => 'nullable|string',
            'kategoria_id' => 'required|integer|min:1',
            'cena' => 'required|numeric|min:0',
            'skladom' => 'required|integer|min:0',
            'znacka_id' => 'required|integer|min:1',
            'material' => 'nullable|string|max:255',
            'farba' => 'required|in:blue,black,white,red,green',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nazov.required' => 'Názov produktu je povinný.',
            'cena.required' => 'Cena je povinná.',
            'cena.numeric' => 'Cena musí byť číslo.',
            'kategoria_id.required' => 'Kategória je povinná.',
            'kategoria_id.integer' => 'ID kategórie musí byť číslo.',
            'znacka_id.required' => 'Značka je povinná.',
            'znacka_id.integer' => 'ID značky musí byť číslo.',
            'farba.required' => 'Farba je povinná.',
            'farba.in' => 'Zvolte platnú farbu.',
            'image1.image' => 'Prvý súbor musí byť obrázok.',
            'image1.mimes' => 'Prvý obrázok musí byť formátu: jpeg, png, jpg, gif.',
            'image1.max' => 'Maximálna veľkosť prvého obrázka je 2MB.',
            'image2.image' => 'Druhý súbor musí byť obrázok.',
            'image2.mimes' => 'Druhý obrázok musí byť formátu: jpeg, png, jpg, gif.',
            'image2.max' => 'Maximálna veľkosť druhého obrázka je 2MB.'
        ]);

        $product = Produkt::findOrFail($id);

        // Handle image uploads with comprehensive error handling
        $timestamp = time();
        
        // Ensure upload directory exists
        $uploadPath = public_path('images/products');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Process first image
        if ($request->hasFile('image1')) {
            try {
                $image = $request->file('image1');
                
                // Validate file
                if ($image->isValid()) {
                    $extension = $image->getClientOriginalExtension();
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (!in_array(strtolower($extension), $allowedExtensions)) {
                        throw new \Exception('Nepodporovaný formát obrázka: ' . $extension);
                    }
                    
                    // Create unique filename
                    $imageName = $timestamp . '_1_' . str_replace(' ', '_', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
                    
                    // Move file with error handling
                    if ($image->move($uploadPath, $imageName)) {
                        $product->image_path1 = 'images/products/' . $imageName;
                    } else {
                        throw new \Exception('Chyba pri nahrávaní prvého obrázka');
                    }
                } else {
                    throw new \Exception('Neplatný súbor prvého obrázka');
                }
            } catch (\Exception $e) {
                // Log error but continue processing
                \Log::error('Image1 upload error: ' . $e->getMessage());
            }
        }
        
        // Process second image
        if ($request->hasFile('image2')) {
            try {
                $image = $request->file('image2');
                
                // Validate file
                if ($image->isValid()) {
                    $extension = $image->getClientOriginalExtension();
                    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                    
                    if (!in_array(strtolower($extension), $allowedExtensions)) {
                        throw new \Exception('Nepodporovaný formát obrázka: ' . $extension);
                    }
                    
                    // Create unique filename with different timestamp
                    $imageName = ($timestamp + 1) . '_2_' . str_replace(' ', '_', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $extension;
                    
                    // Move file with error handling
                    if ($image->move($uploadPath, $imageName)) {
                        $product->image_path2 = 'images/products/' . $imageName;
                    } else {
                        throw new \Exception('Chyba pri nahrávaní druhého obrázka');
                    }
                } else {
                    throw new \Exception('Neplatný súbor druhého obrázka');
                }
            } catch (\Exception $e) {
                // Log error but continue processing
                \Log::error('Image2 upload error: ' . $e->getMessage());
            }
        }

        // Update product data
        $product->nazov = $validated['nazov'];
        $product->popis = $validated['popis'];
        $product->cena = $validated['cena'];
        $product->skladom = $validated['skladom'];
        $product->farba = $validated['farba'];
        $product->material = $validated['material'];
        $product->kategoria_id = $validated['kategoria_id'];
        $product->znacka_id = $validated['znacka_id'];
        
        $product->save();

        return redirect('/admin_products_review')->with('success', 'Produkt bol úspešne aktualizovaný!');
    }
}
