<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttractionController extends Controller
{
    public function index(Request $request)
    {
        $attractions = session('attractions', $this->defaultAttractions());
        
        $category = $request->query('category', 'Semua');
        $search = $request->query('search', '');

        $filtered = collect($attractions)->filter(function ($item) use ($category, $search) {
            $matchCategory = $category === 'Semua' || $item['category'] === $category;
            $matchSearch = empty($search) || 
                str_contains(strtolower($item['name']), strtolower($search)) ||
                str_contains(strtolower($item['description']), strtolower($search));
            return $matchCategory && $matchSearch;
        })->values();

        $categories = ['Semua', 'Alam', 'Budaya', 'Kuliner', 'Belanja', 'Hiburan'];

        return view('attractions.index', [
            'attractions' => $filtered,
            'categories' => $categories,
            'selectedCategory' => $category,
            'searchQuery' => $search,
            'username' => session('username'),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'address' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'required|url',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $attractions = session('attractions', $this->defaultAttractions());
        $attractions[] = [
            'id' => uniqid(),
            'name' => $data['name'],
            'description' => $data['description'],
            'category' => $data['category'],
            'address' => $data['address'],
            'rating' => (float) $data['rating'],
            'image' => $data['image'],
            'coordinates' => [(float) $data['lng'], (float) $data['lat']],
        ];
        session(['attractions' => $attractions]);

        return redirect()->route('home')->with('success', 'Tempat wisata berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'address' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'required|url',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $attractions = session('attractions', $this->defaultAttractions());
        foreach ($attractions as &$a) {
            if ($a['id'] === $id) {
                $a['name'] = $data['name'];
                $a['description'] = $data['description'];
                $a['category'] = $data['category'];
                $a['address'] = $data['address'];
                $a['rating'] = (float) $data['rating'];
                $a['image'] = $data['image'];
                $a['coordinates'] = [(float) $data['lng'], (float) $data['lat']];
                break;
            }
        }
        session(['attractions' => $attractions]);

        return redirect()->route('home')->with('success', 'Tempat wisata berhasil diupdate!');
    }

    public function destroy($id)
    {
        $attractions = session('attractions', $this->defaultAttractions());
        $attractions = array_values(array_filter($attractions, fn($a) => $a['id'] !== $id));
        session(['attractions' => $attractions]);

        return redirect()->route('home')->with('success', 'Tempat wisata berhasil dihapus!');
    }

    private function defaultAttractions()
    {
        return [
            [
                'id' => '1',
                'name' => 'Tangkuban Perahu',
                'description' => 'Gunung berapi aktif dengan kawah yang menakjubkan dan pemandangan alam yang indah.',
                'category' => 'Alam',
                'address' => 'Kecamatan Lembang, Kabupaten Bandung Barat, Jawa Barat',
                'rating' => 4.7,
                'image' => 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=800&q=80',
                'coordinates' => [107.6000, -6.7596],
            ],
            [
                'id' => '2',
                'name' => 'Gedung Sate',
                'description' => 'Gedung bersejarah dengan arsitektur kolonial yang ikonik.',
                'category' => 'Budaya',
                'address' => 'Jl. Diponegoro No.22, Bandung',
                'rating' => 4.6,
                'image' => 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=800&q=80',
                'coordinates' => [107.6186, -6.9025],
            ],
            [
                'id' => '3',
                'name' => 'Kawah Putih',
                'description' => 'Danau kawah vulkanik dengan air berwarna putih kehijauan.',
                'category' => 'Alam',
                'address' => 'Ciwidey, Kabupaten Bandung, Jawa Barat',
                'rating' => 4.5,
                'image' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?w=800&q=80',
                'coordinates' => [107.4020, -7.1660],
            ],
            [
                'id' => '4',
                'name' => 'Trans Studio Bandung',
                'description' => 'Taman hiburan indoor terbesar di Indonesia.',
                'category' => 'Hiburan',
                'address' => 'Jl. Gatot Subroto No.289, Bandung',
                'rating' => 4.4,
                'image' => 'https://images.unsplash.com/photo-1513106580091-1d82408b8cd6?w=800&q=80',
                'coordinates' => [107.6356, -6.9261],
            ],
            [
                'id' => '5',
                'name' => 'Floating Market Lembang',
                'description' => 'Pasar terapung dengan kuliner dan wahana bermain.',
                'category' => 'Kuliner',
                'address' => 'Jl. Grand Hotel No.33E, Lembang',
                'rating' => 4.3,
                'image' => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&q=80',
                'coordinates' => [107.6175, -6.8167],
            ],
            [
                'id' => '6',
                'name' => 'Paris Van Java',
                'description' => 'Pusat perbelanjaan modern dengan konsep open air.',
                'category' => 'Belanja',
                'address' => 'Jl. Sukajadi No.131-139, Bandung',
                'rating' => 4.5,
                'image' => 'https://images.unsplash.com/photo-1519567241046-7f570eee3ce6?w=800&q=80',
                'coordinates' => [107.5936, -6.8936],
            ],
            [
                'id' => '7',
                'name' => 'Farm House Lembang',
                'description' => 'Wisata ala Eropa dengan rumah hobbit dan peternakan.',
                'category' => 'Hiburan',
                'address' => 'Jl. Raya Lembang No.108, Lembang',
                'rating' => 4.2,
                'image' => 'https://images.unsplash.com/photo-1500076656116-558758c991c1?w=800&q=80',
                'coordinates' => [107.6083, -6.8250],
            ],
            [
                'id' => '8',
                'name' => 'Saung Angklung Udjo',
                'description' => 'Pertunjukan seni angklung dan budaya Sunda.',
                'category' => 'Budaya',
                'address' => 'Jl. Padasuka No.118, Bandung',
                'rating' => 4.6,
                'image' => 'https://images.unsplash.com/photo-1518609878373-06d740f60d8b?w=800&q=80',
                'coordinates' => [107.6494, -6.8958],
            ],
            [
                'id' => '9',
                'name' => 'Cihampelas Walk',
                'description' => 'Mall dengan tema unik dan Factory Outlet.',
                'category' => 'Belanja',
                'address' => 'Jl. Cihampelas No.160, Bandung',
                'rating' => 4.1,
                'image' => 'https://images.unsplash.com/photo-1567449303183-ae0d6ed1498e?w=800&q=80',
                'coordinates' => [107.6042, -6.8933],
            ],
            [
                'id' => '10',
                'name' => 'Situ Patenggang',
                'description' => 'Danau indah dengan Pulau Asmara yang romantis.',
                'category' => 'Alam',
                'address' => 'Ciwidey, Kabupaten Bandung, Jawa Barat',
                'rating' => 4.4,
                'image' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=800&q=80',
                'coordinates' => [107.3617, -7.1658],
            ],
        ];
    }
}
