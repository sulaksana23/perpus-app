<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label">Kode Buku</label>
        <input type="text" name="code" class="form-control" value="{{ old('code', $book->code ?? '') }}" required>
    </div>
    <div class="col-md-8">
        <label class="form-label">Judul</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $book->title ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Pengarang</label>
        <input type="text" name="author" class="form-control" value="{{ old('author', $book->author ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Penerbit</label>
        <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $book->publisher ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Tahun</label>
        <input type="number" name="year" class="form-control" value="{{ old('year', $book->year ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Stok</label>
        <input type="number" name="stock" min="0" class="form-control" value="{{ old('stock', $book->stock ?? 0) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Kategori</label>
        <select name="category_id" class="form-select">
            <option value="">Pilih Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((int)old('category_id', $book->category_id ?? 0) === $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label class="form-label">Cover</label>
        <input type="file" name="cover" class="form-control">
    </div>
    <div class="col-md-12">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description', $book->description ?? '') }}</textarea>
    </div>
</div>
