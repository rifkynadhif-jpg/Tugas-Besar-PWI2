<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Temukan destinasi wisata Bandung dengan peta interaktif, pencarian, filter, dan rute ke Google Maps.">
    <link rel="canonical" href="<?php echo e(url('/')); ?>">
    <title>Jelajah Bandung - Peta Wisata Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .animate-fade-in { animation: fadeIn 0.5s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    
    <header class="fixed top-4 right-4 z-50">
        <nav class="flex items-center gap-3 rounded-lg bg-white/80 backdrop-blur-sm border border-gray-200 px-3 py-2 shadow-sm">
            <?php if($username): ?>
                <span class="hidden sm:inline text-sm text-gray-500">Halo, <span class="font-medium text-gray-900"><?php echo e($username); ?></span></span>
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="px-3 py-1.5 text-sm font-medium bg-gray-100 hover:bg-gray-200 rounded-md transition">Logout</button>
            </form>
        </nav>
    </header>

    
    <section class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600 py-20 px-6">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIxLTEuNzktNC00LTRzLTQgMS43OS00IDQgMS43OSA0IDQgNCA0LTEuNzkgNC00em0wLTEwYzAtMi4yMS0xLjc5LTQtNC00cy00IDEuNzktNCA0IDEuNzkgNCA0IDQgNC0xLjc5IDQtNHptMC0xMGMwLTIuMjEtMS43OS00LTQtNHMtNCAxLjc5LTQgNCAxLjc5IDQgNCA0IDQtMS43OSA0LTR6Ii8+PC9nPjwvZz48L3N2Zz4=')] opacity-30"></div>
        <div class="relative max-w-5xl mx-auto text-center">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 animate-fade-in">Jelajah Bandung</h1>
            <p class="text-xl md:text-2xl text-white/90 mb-10">Temukan destinasi wisata terbaik dengan peta interaktif</p>
            <form method="GET" action="<?php echo e(url('/')); ?>" class="flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
                <div class="relative flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" name="search" value="<?php echo e($searchQuery); ?>" placeholder="Cari destinasi wisata..." class="w-full pl-12 pr-4 h-14 text-lg bg-white rounded-lg shadow-lg border-0 focus:ring-2 focus:ring-white/50 outline-none">
                    <input type="hidden" name="category" value="<?php echo e($selectedCategory); ?>">
                </div>
                <button type="button" onclick="getMyLocation()" class="h-14 px-8 bg-white text-emerald-600 hover:bg-gray-100 rounded-lg shadow-lg font-semibold flex items-center justify-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span id="locateBtnText">Lokasi Saya</span>
                </button>
            </form>
        </div>
    </section>

    
    <section class="container mx-auto px-4 py-6">
        <div class="flex flex-wrap gap-2">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(url('/')); ?>?category=<?php echo e(urlencode($cat)); ?>&search=<?php echo e(urlencode($searchQuery)); ?>" class="px-4 py-2 rounded-full text-sm font-medium transition <?php echo e($selectedCategory === $cat ? 'bg-emerald-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'); ?>">
                    <?php echo e($cat); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    
    <main class="container mx-auto px-4 pb-12">
        <div class="grid lg:grid-cols-2 gap-8">
            
            <div class="h-[500px] lg:h-[600px] lg:sticky lg:top-4 relative rounded-lg overflow-hidden shadow-lg bg-gray-200">
                <iframe id="mapFrame" src="https://www.openstreetmap.org/export/embed.html?bbox=107.5591%2C-6.9675%2C107.6791%2C-6.8675&layer=mapnik&marker=-6.9175%2C107.6191" class="w-full h-full border-0" allowfullscreen loading="lazy" title="Peta Wisata Bandung"></iframe>

                
                <div id="attractionList" class="absolute top-20 left-4 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg max-w-xs max-h-72 overflow-y-auto z-10">
                    <div class="flex items-center justify-between p-3 border-b border-gray-200">
                        <h3 class="font-semibold text-sm">Tempat Wisata</h3>
                        <button onclick="document.getElementById('attractionList').classList.add('hidden'); document.getElementById('showListBtn').classList.remove('hidden');" class="p-1 hover:bg-gray-100 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="p-2 space-y-1">
                        <?php $__currentLoopData = $attractions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button onclick="selectAttraction(<?php echo e(json_encode($a)); ?>)" class="w-full text-left p-2 rounded-md hover:bg-gray-100 transition attraction-item" data-id="<?php echo e($a['id']); ?>">
                                <div class="flex items-start gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <div class="min-w-0">
                                        <p class="font-medium text-sm truncate"><?php echo e($a['name']); ?></p>
                                        <p class="text-xs text-gray-500 truncate"><?php echo e($a['category']); ?></p>
                                        <div class="flex items-center gap-1 mt-0.5">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-400 fill-yellow-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            <span class="text-xs"><?php echo e($a['rating']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                
                <button id="showListBtn" onclick="document.getElementById('attractionList').classList.remove('hidden'); this.classList.add('hidden');" class="hidden absolute top-20 left-4 bg-emerald-600 text-white px-4 py-2 rounded-lg shadow-lg text-sm font-medium hover:bg-emerald-700 transition z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Lihat Tempat Wisata
                </button>

                
                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-2 rounded-lg shadow-md z-10">
                    <p class="text-xs text-gray-500">Wilayah</p>
                    <p class="font-semibold text-sm">Bandung, Jawa Barat</p>
                </div>

                
                <div id="selectedCard" class="hidden absolute bottom-4 left-4 right-4 md:right-auto md:max-w-md bg-white/95 backdrop-blur-sm rounded-lg shadow-lg p-4 z-10">
                    <div class="flex gap-3">
                        <img id="selectedImage" src="" alt="" class="w-20 h-20 rounded-lg object-cover bg-gray-200">
                        <div class="flex-1 min-w-0">
                            <h3 id="selectedName" class="font-semibold truncate"></h3>
                            <p id="selectedCategory" class="text-sm text-gray-500"></p>
                            <div class="flex items-center gap-1 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400 fill-yellow-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                <span id="selectedRating" class="text-sm font-medium"></span>
                            </div>
                            <p id="selectedAddress" class="text-xs text-gray-500 mt-1 line-clamp-2"></p>
                        </div>
                    </div>
                    <a id="googleMapsLink" href="#" target="_blank" rel="noopener noreferrer" class="mt-3 w-full inline-flex items-center justify-center gap-2 bg-emerald-600 text-white rounded-md py-2 text-sm font-medium hover:bg-emerald-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        Buka di Google Maps
                    </a>
                </div>
            </div>

            
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-900"><?php echo e(count($attractions)); ?> Destinasi</h2>
                    <button onclick="openAddModal()" class="px-4 py-2 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        Tambah Wisata
                    </button>
                </div>

                <?php $__empty_1 = true; $__currentLoopData = $attractions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition cursor-pointer" onclick="selectAttraction(<?php echo e(json_encode($a)); ?>)">
                        <div class="relative">
                            <img src="<?php echo e($a['image']); ?>" alt="<?php echo e($a['name']); ?>" class="w-full h-48 object-cover" onerror="this.src='https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&q=60'">
                            <div class="absolute top-3 right-3 flex gap-2">
                                <button onclick="event.stopPropagation(); openEditModal(<?php echo e(json_encode($a)); ?>)" class="p-2 bg-white/90 hover:bg-white rounded-full shadow transition" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form method="POST" action="<?php echo e(url('/attractions/' . $a['id'])); ?>" onclick="event.stopPropagation();" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 bg-red-500/90 hover:bg-red-600 rounded-full shadow transition" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <div>
                                    <h3 class="font-semibold text-lg text-gray-900"><?php echo e($a['name']); ?></h3>
                                    <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded-full mt-1"><?php echo e($a['category']); ?></span>
                                </div>
                                <div class="flex items-center gap-1 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400 fill-yellow-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    <span class="font-medium"><?php echo e($a['rating']); ?></span>
                                </div>
                            </div>
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2"><?php echo e($a['description']); ?></p>
                            <p class="text-gray-500 text-xs flex items-start gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <?php echo e($a['address']); ?>

                            </p>
                        </div>
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-12">
                        <p class="text-gray-500 text-lg">Tidak ada destinasi yang ditemukan</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    
    <footer class="bg-gray-100 py-8 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-500">© 2024 Jelajah Bandung. Sistem Informasi Geografis Wisata Bandung</p>
        </div>
    </footer>

    
    <div id="formModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 id="modalTitle" class="text-lg font-semibold">Tambah Wisata</h3>
                <button onclick="closeModal()" class="p-1 hover:bg-gray-100 rounded">&times;</button>
            </div>
            <form id="attractionForm" method="POST" action="<?php echo e(url('/attractions')); ?>" class="p-4 space-y-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" id="formName" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="formDescription" rows="3" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" id="formCategory" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="Alam">Alam</option>
                            <option value="Budaya">Budaya</option>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Belanja">Belanja</option>
                            <option value="Hiburan">Hiburan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                        <input type="number" name="rating" id="formRating" min="0" max="5" step="0.1" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <input type="text" name="address" id="formAddress" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL Gambar</label>
                    <input type="url" name="image" id="formImage" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                        <input type="number" name="lat" id="formLat" step="any" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                        <input type="number" name="lng" id="formLng" step="any" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition">Simpan</button>
            </form>
        </div>
    </div>

    
    <?php if(session('success')): ?>
        <div id="toast" class="fixed bottom-4 right-4 bg-emerald-600 text-white px-4 py-3 rounded-lg shadow-lg z-50 animate-fade-in">
            <?php echo e(session('success')); ?>

        </div>
        <script>setTimeout(() => document.getElementById('toast')?.remove(), 3000);</script>
    <?php endif; ?>

    <script>
        let userLocation = null;
        let selectedAttraction = null;

        function getMyLocation() {
            const btn = document.getElementById('locateBtnText');
            btn.textContent = 'Mencari...';

            if (!window.isSecureContext) {
                alert('Deteksi lokasi butuh koneksi aman (HTTPS) atau localhost.');
                btn.textContent = 'Lokasi Saya';
                return;
            }

            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                        btn.textContent = 'Lokasi Saya';
                        updateMap(userLocation.lat, userLocation.lng);
                        document.getElementById('selectedCard').classList.add('hidden');
                        selectedAttraction = null;
                        alert('Lokasi ditemukan! Peta diperbarui ke lokasi Anda.');
                    },
                    () => {
                        btn.textContent = 'Lokasi Saya';
                        alert('Gagal mengakses lokasi. Aktifkan izin lokasi di browser.');
                    },
                    { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                );
            } else {
                btn.textContent = 'Lokasi Saya';
                alert('Browser tidak mendukung geolocation.');
            }
        }

        function updateMap(lat, lng) {
            const bbox = {
                left: lng - 0.02,
                bottom: lat - 0.015,
                right: lng + 0.02,
                top: lat + 0.015
            };
            const url = `https://www.openstreetmap.org/export/embed.html?bbox=${bbox.left}%2C${bbox.bottom}%2C${bbox.right}%2C${bbox.top}&layer=mapnik&marker=${lat}%2C${lng}`;
            document.getElementById('mapFrame').src = url;
        }

        function selectAttraction(a) {
            selectedAttraction = a;
            const lat = a.coordinates[1];
            const lng = a.coordinates[0];
            updateMap(lat, lng);

            document.getElementById('selectedImage').src = a.image;
            document.getElementById('selectedImage').alt = a.name;
            document.getElementById('selectedName').textContent = a.name;
            document.getElementById('selectedCategory').textContent = a.category;
            document.getElementById('selectedRating').textContent = a.rating;
            document.getElementById('selectedAddress').textContent = a.address;

            let mapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}&travelmode=driving`;
            if (userLocation) {
                mapsUrl += `&origin=${userLocation.lat},${userLocation.lng}`;
            }
            document.getElementById('googleMapsLink').href = mapsUrl;
            document.getElementById('selectedCard').classList.remove('hidden');

            document.querySelectorAll('.attraction-item').forEach(el => el.classList.remove('bg-emerald-100'));
            document.querySelector(`.attraction-item[data-id="${a.id}"]`)?.classList.add('bg-emerald-100');
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Tambah Wisata';
            document.getElementById('attractionForm').action = '<?php echo e(url("/attractions")); ?>';
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('formName').value = '';
            document.getElementById('formDescription').value = '';
            document.getElementById('formCategory').value = 'Alam';
            document.getElementById('formRating').value = '';
            document.getElementById('formAddress').value = '';
            document.getElementById('formImage').value = '';
            document.getElementById('formLat').value = '';
            document.getElementById('formLng').value = '';
            document.getElementById('formModal').classList.remove('hidden');
        }

        function openEditModal(a) {
            document.getElementById('modalTitle').textContent = 'Edit Wisata';
            document.getElementById('attractionForm').action = '/attractions/' + a.id;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('formName').value = a.name;
            document.getElementById('formDescription').value = a.description;
            document.getElementById('formCategory').value = a.category;
            document.getElementById('formRating').value = a.rating;
            document.getElementById('formAddress').value = a.address;
            document.getElementById('formImage').value = a.image;
            document.getElementById('formLat').value = a.coordinates[1];
            document.getElementById('formLng').value = a.coordinates[0];
            document.getElementById('formModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('formModal').classList.add('hidden');
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\pwi2sem5\resources\views/attractions/index.blade.php ENDPATH**/ ?>