<?php

namespace App\Http\Controllers;

use App\Models\Produkt;
use App\Models\Kategoria;
use App\Models\Znacka;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    private const IMAGE_WIDTH = 256;
    private const IMAGE_HEIGHT = 357;
    private const IMAGE_CROP_ZOOM = 1.12;

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
            'nazov' => 'required|string|max:25',
            'popis' => 'nullable|string|max:1000',
            'kategoria_id' => 'required|integer|min:1',
            'cena' => ['required', 'numeric', 'gt:0', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
            'cena_bez_zlavy' => ['nullable', 'numeric', 'gt:0', 'lt:cena', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
            'skladom' => 'required|integer|min:1',
            'znacka_id' => 'required|integer|min:1',
            'material' => 'required|string|max:255',
            'farba' => 'nullable|in:modra,cierna,biela,cervena,zelena',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nazov.required' => 'Názov produktu je povinný.',
            'popis.max' => 'Detailný opis môže mať maximálne 1000 znakov.',
            'cena.required' => 'Cena je povinná.',
            'cena.numeric' => 'Cena musí byť číslo.',
            'cena.gt' => 'Cena bez zľavy musí byť väčšia ako 0.',
            'cena.regex' => 'Cena bez zľavy môže byť maximálne 9999.99.',
            'cena_bez_zlavy.numeric' => 'Cena so zľavou musí byť číslo.',
            'cena_bez_zlavy.gt' => 'Cena so zľavou musí byť väčšia ako 0.',
            'cena_bez_zlavy.lt' => 'Cena so zľavou musí byť menšia ako cena bez zľavy.',
            'cena_bez_zlavy.regex' => 'Cena so zľavou môže byť maximálne 9999.99.',
            'kategoria_id.required' => 'Kategória je povinná.',
            'kategoria_id.integer' => 'ID kategórie musí byť číslo.',
            'znacka_id.required' => 'Značka je povinná.',
            'znacka_id.integer' => 'ID značky musí byť číslo.',
            'material.required' => 'Materiál je povinný.',
            'farba.in' => 'Zvolte platnú farbu.',
            'image1.image' => 'Prvý súbor musí byť obrázok.',
            'image1.mimes' => 'Prvý obrázok musí byť formátu: jpeg, png, jpg, gif.',
            'image1.max' => 'Maximálna veľkosť prvého obrázka je 2MB.',
            'image2.image' => 'Druhý súbor musí byť obrázok.',
            'image2.mimes' => 'Druhý obrázok musí byť formátu: jpeg, png, jpg, gif.',
            'image2.max' => 'Maximálna veľkosť druhého obrázka je 2MB.'
        ]);

        $imagePath1 = $this->fallbackPrimaryImagePath(0);
        $imagePath2 = $this->fallbackSecondaryImagePath(0);
        $timestamp = time();

        if ($request->hasFile('image1')) {
            try {
                $imagePath1 = $this->storeUploadedImage($request->file('image1'), $timestamp, '1');
            } catch (\Exception $e) {
                \Log::error('Image1 upload error: ' . $e->getMessage());
            }
        }

        if ($request->hasFile('image2')) {
            try {
                $imagePath2 = $this->storeUploadedImage($request->file('image2'), $timestamp + 1, '2');
            } catch (\Exception $e) {
                \Log::error('Image2 upload error: ' . $e->getMessage());
            }
        }

        $product = new Produkt();
        $product->nazov = $validated['nazov'];
        $product->popis = $validated['popis'];
        $product->cena = $validated['cena'];
        $product->cena_bez_zlavy = $validated['cena_bez_zlavy'] ?? null;
        $product->skladom = $validated['skladom'];
        $product->farba = $validated['farba'] ?? $product->farba;
        $product->material = $validated['material'];
        $product->image_path1 = $imagePath1;
        $product->image_path2 = $imagePath2;
        $product->kategoria_id = $validated['kategoria_id'];
        $product->znacka_id = $validated['znacka_id'];

        $product->pouzivatel_id = auth()->id() ?? 1;
        
        $product->save();

        return redirect('/admin_products_review')->with('success', 'Produkt bol úspešne pridaný!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nazov' => 'required|string|max:25',
            'popis' => 'nullable|string|max:1000',
            'kategoria_id' => 'required|integer|min:1',
            'cena' => ['required', 'numeric', 'gt:0', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
            'cena_bez_zlavy' => ['nullable', 'numeric', 'gt:0', 'lt:cena', 'regex:/^\d{1,4}(\.\d{1,2})?$/'],
            'skladom' => 'required|integer|min:1',
            'znacka_id' => 'required|integer|min:1',
            'material' => 'nullable|string|max:255',
            'farba' => 'required|in:modra,cierna,biela,cervena,zelena',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'nazov.required' => 'Názov produktu je povinný.',
            'popis.max' => 'Detailný opis môže mať maximálne 1000 znakov.',
            'cena.required' => 'Cena je povinná.',
            'cena.numeric' => 'Cena musí byť číslo.',
            'cena.gt' => 'Cena bez zľavy musí byť väčšia ako 0.',
            'cena.regex' => 'Cena bez zľavy môže byť maximálne 9999.99.',
            'cena_bez_zlavy.numeric' => 'Cena so zľavou musí byť číslo.',
            'cena_bez_zlavy.gt' => 'Cena so zľavou musí byť väčšia ako 0.',
            'cena_bez_zlavy.lt' => 'Cena so zľavou musí byť menšia ako cena bez zľavy.',
            'cena_bez_zlavy.regex' => 'Cena so zľavou môže byť maximálne 9999.99.',
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

        $timestamp = time();

        if ($request->hasFile('image1')) {
            try {
                $product->image_path1 = $this->storeUploadedImage($request->file('image1'), $timestamp, '1');
            } catch (\Exception $e) {
                \Log::error('Image1 upload error: ' . $e->getMessage());
            }
        }

        if ($request->hasFile('image2')) {
            try {
                $product->image_path2 = $this->storeUploadedImage($request->file('image2'), $timestamp + 1, '2');
            } catch (\Exception $e) {
                \Log::error('Image2 upload error: ' . $e->getMessage());
            }
        }

        $product->nazov = $validated['nazov'];
        $product->popis = $validated['popis'];
        $product->cena = $validated['cena'];
        $product->cena_bez_zlavy = $validated['cena_bez_zlavy'] ?? null;
        $product->skladom = $validated['skladom'];
        $product->farba = $validated['farba'];
        $product->material = $validated['material'];
        $product->kategoria_id = $validated['kategoria_id'];
        $product->znacka_id = $validated['znacka_id'];
        
        $product->save();

        return redirect('/admin_products_review')->with('success', 'Produkt bol úspešne aktualizovaný!');
    }

    public function deleteImage(int $id, string $slot)
    {
        if (!in_array($slot, ['1', '2'], true)) {
            abort(404);
        }

        $product = Produkt::findOrFail($id);

        $field = $slot === '1' ? 'image_path1' : 'image_path2';

        $path = (string) ($product->{$field} ?? '');

        if ($path !== '' && str_starts_with($path, 'images/products/')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $product->{$field} = null;
        $product->save();

        return redirect()->back()->with('success', 'Obrázok bol zmazaný.');
    }

    private function storeUploadedImage(UploadedFile $image, int $timestamp, string $suffix): string
    {
        if (!$image->isValid()) {
            throw new \RuntimeException('Neplatný obrázkový súbor.');
        }

        $extension = strtolower($image->getClientOriginalExtension());
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($extension, $allowedExtensions, true)) {
            throw new \RuntimeException('Nepodporovaný formát obrázka: ' . $extension);
        }

        $uploadPath = public_path('images/products');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $safeName = str_replace(' ', '_', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
        $imageName = $timestamp . '_' . $suffix . '_' . $safeName . '.' . $extension;
        $destinationPath = $uploadPath . DIRECTORY_SEPARATOR . $imageName;
        $this->resizeAndCropToExactSize($image->getPathname(), $destinationPath, $extension);

        return 'images/products/' . $imageName;
    }

    private function resizeAndCropToExactSize(string $sourcePath, string $destinationPath, string $extension): void
    {
        $sourceImageData = @file_get_contents($sourcePath);
        if ($sourceImageData === false) {
            throw new \RuntimeException('Nepodarilo sa načítať obrázok.');
        }

        $sourceImage = @imagecreatefromstring($sourceImageData);
        if ($sourceImage === false) {
            throw new \RuntimeException('Nepodarilo sa spracovať obrázok.');
        }

        $sourceWidth = imagesx($sourceImage);
        $sourceHeight = imagesy($sourceImage);
        $targetRatio = self::IMAGE_WIDTH / self::IMAGE_HEIGHT;
        $sourceRatio = $sourceWidth / $sourceHeight;

        if ($sourceRatio > $targetRatio) {
            $cropHeight = $sourceHeight;
            $cropWidth = (int) round($sourceHeight * $targetRatio);
            $srcX = (int) floor(($sourceWidth - $cropWidth) / 2);
            $srcY = 0;
        } else {
            $cropWidth = $sourceWidth;
            $cropHeight = (int) round($sourceWidth / $targetRatio);
            $srcX = 0;
            $srcY = (int) floor(($sourceHeight - $cropHeight) / 2);
        }

        $zoomedCropWidth = max(1, (int) floor($cropWidth / self::IMAGE_CROP_ZOOM));
        $zoomedCropHeight = max(1, (int) floor($cropHeight / self::IMAGE_CROP_ZOOM));
        $srcX += (int) floor(($cropWidth - $zoomedCropWidth) / 2);
        $srcY += (int) floor(($cropHeight - $zoomedCropHeight) / 2);
        $cropWidth = $zoomedCropWidth;
        $cropHeight = $zoomedCropHeight;

        $targetImage = imagecreatetruecolor(self::IMAGE_WIDTH, self::IMAGE_HEIGHT);

        if (in_array($extension, ['png', 'gif'], true)) {
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
            $transparent = imagecolorallocatealpha($targetImage, 0, 0, 0, 127);
            imagefilledrectangle($targetImage, 0, 0, self::IMAGE_WIDTH, self::IMAGE_HEIGHT, $transparent);
        }

        imagecopyresampled(
            $targetImage,
            $sourceImage,
            0,
            0,
            $srcX,
            $srcY,
            self::IMAGE_WIDTH,
            self::IMAGE_HEIGHT,
            $cropWidth,
            $cropHeight
        );

        $saved = match ($extension) {
            'png' => imagepng($targetImage, $destinationPath),
            'gif' => imagegif($targetImage, $destinationPath),
            default => imagejpeg($targetImage, $destinationPath, 90),
        };

        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        if (!$saved) {
            throw new \RuntimeException('Nepodarilo sa uložiť upravený obrázok.');
        }
    }

    private function fallbackPrimaryImagePath(int $_productId): string
    {
        return 'images/empty.png';
    }

    private function fallbackSecondaryImagePath(int $_productId): string
    {
        return 'images/empty.png';
    }
}
