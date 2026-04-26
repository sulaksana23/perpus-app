<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label"><i class="bi bi-person me-1"></i>Nama</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label"><i class="bi bi-at me-1"></i>Username</label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" placeholder="Opsional">
    </div>

    <div class="col-md-6">
        <label class="form-label"><i class="bi bi-envelope me-1"></i>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label class="form-label"><i class="bi bi-telephone me-1"></i>Nomor HP</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="Opsional">
    </div>

    <div class="col-md-6">
        <label class="form-label"><i class="bi bi-shield-lock me-1"></i>Role</label>
        <select name="role" class="form-select" required>
            @foreach($roleOptions as $option)
                <option value="{{ $option }}" @selected(old('role', $user->role ?: 'user') === $option)>{{ ucfirst($option) }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label"><i class="bi bi-patch-check me-1"></i>Status Akun</label>
        <select name="status_akun" class="form-select" required>
            @foreach($statusOptions as $option)
                <option value="{{ $option }}" @selected(old('status_akun', $user->status_akun ?: 'active') === $option)>{{ ucfirst($option) }}</option>
            @endforeach
        </select>
        <small class="text-muted">Role admin otomatis dipaksa aktif saat disimpan.</small>
    </div>

    <div class="col-12">
        <label class="form-label"><i class="bi bi-geo-alt me-1"></i>Alamat</label>
        <textarea name="address" rows="3" class="form-control" placeholder="Opsional">{{ old('address', $user->address) }}</textarea>
    </div>

    <div class="col-md-6">
        <label class="form-label"><i class="bi bi-key me-1"></i>Password {{ $user->exists ? 'Baru' : '' }}</label>
        <input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label"><i class="bi bi-check2-square me-1"></i>Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" {{ $user->exists ? '' : 'required' }}>
    </div>
</div>
