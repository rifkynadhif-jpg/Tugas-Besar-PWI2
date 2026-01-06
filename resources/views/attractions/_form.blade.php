@php $prefix = isset($isEdit) ? 'edit_' : ''; @endphp

<div>
    <label for="{{ $prefix }}name" class="block text-sm font-medium mb-1">Nama Wisata</label>
    <input type="text" name="name" id="{{ $prefix }}name" placeholder="Nama tempat wisata" required
        class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
</div>

<div>
    <label for="{{ $prefix }}category" class="block text-sm font-medium mb-1">Kategori</label>
    <select name="category" id="{{ $prefix }}category" required
        class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        <option value="">Pilih kategori</option>
        <option value="Alam">Alam</option>
        <option value="Sejarah">Sejarah</option>
        <option value="Kuliner">Kuliner</option>
        <option value="Rekreasi">Rekreasi</option>
        <option value="Hiburan">Hiburan</option>
        <option value="Budaya">Budaya</option>
    </select>
</div>

<div>
    <label for="{{ $prefix }}description" class="block text-sm font-medium mb-1">Deskripsi</label>
    <textarea name="description" id="{{ $prefix }}description" placeholder="Deskripsi tempat wisata" required rows="3"
        class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
</div>

<div>
    <label for="{{ $prefix }}address" class="block text-sm font-medium mb-1">Alamat</label>
    <input type="text" name="address" id="{{ $prefix }}address" placeholder="Alamat lengkap" required
        class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
</div>

<div>
    <label for="{{ $prefix }}rating" class="block text-sm font-medium mb-1">Rating (0-5)</label>
    <input type="number" name="rating" id="{{ $prefix }}rating" step="0.1" min="0" max="5" placeholder="4.5" required
        class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
</div>

<div>
    <label for="{{ $prefix }}image" class="block text-sm font-medium mb-1">URL Gambar</label>
    <input type="url" name="image" id="{{ $prefix }}image" placeholder="https://..." required
        class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="{{ $prefix }}longitude" class="block text-sm font-medium mb-1">Longitude</label>
        <input type="number" name="longitude" id="{{ $prefix }}longitude" step="any" placeholder="107.6186" required
            class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
    </div>
    <div>
        <label for="{{ $prefix }}latitude" class="block text-sm font-medium mb-1">Latitude</label>
        <input type="number" name="latitude" id="{{ $prefix }}latitude" step="any" placeholder="-6.9024" required
            class="w-full px-3 py-2 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
    </div>
</div>
