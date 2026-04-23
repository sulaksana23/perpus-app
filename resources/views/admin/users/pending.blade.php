@extends('layouts.admin', ['title' => 'Persetujuan Akun User'])

@section('content')
<div class="space-y-4">
    <form method="GET" class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-[1fr_auto]">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm"
                placeholder="Cari nama / email user"
            >
            <button class="inline-flex items-center justify-center gap-2 rounded-lg border border-teal-600 bg-teal-600 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-700">
                <i class="bi bi-search"></i>
                Cari
            </button>
        </div>
    </form>

    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center gap-2 border-b border-slate-200 px-3 py-2.5 text-sm font-bold text-slate-800">
            <i class="bi bi-hourglass-split text-slate-500"></i>
            Pengajuan Akun Pending
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold">Nama</th>
                        <th class="px-3 py-2 text-left font-semibold">Email</th>
                        <th class="px-3 py-2 text-left font-semibold">Tanggal Daftar</th>
                        <th class="px-3 py-2 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingUsers as $user)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-3 py-2.5">{{ $user->name }}</td>
                            <td class="px-3 py-2.5">{{ $user->email }}</td>
                            <td class="px-3 py-2.5">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-3 py-2.5">
                                <div class="flex flex-wrap gap-1.5">
                                    <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                        @csrf
                                        <button class="inline-flex items-center gap-1 rounded-md bg-emerald-600 px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-emerald-700">
                                            <i class="bi bi-check2-circle"></i>ACC
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                        @csrf
                                        <button class="inline-flex items-center gap-1 rounded-md bg-rose-600 px-2.5 py-1.5 text-xs font-semibold text-white hover:bg-rose-700">
                                            <i class="bi bi-x-circle"></i>Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-slate-500">Tidak ada pengajuan pending.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div>{{ $pendingUsers->links() }}</div>

    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center gap-2 border-b border-slate-200 px-3 py-2.5 text-sm font-bold text-slate-800">
            <i class="bi bi-person-check text-slate-500"></i>
            User Aktif
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold">Nama</th>
                        <th class="px-3 py-2 text-left font-semibold">Email</th>
                        <th class="px-3 py-2 text-left font-semibold">Status</th>
                        <th class="px-3 py-2 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($activeUsers as $user)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-3 py-2.5">{{ $user->name }}</td>
                            <td class="px-3 py-2.5">{{ $user->email }}</td>
                            <td class="px-3 py-2.5">
                                <span class="inline-flex rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">active</span>
                            </td>
                            <td class="px-3 py-2.5">
                                <form method="POST" action="{{ route('admin.users.deactivate', $user) }}" onsubmit="return confirm('Nonaktifkan akun user ini?')">
                                    @csrf
                                    <button class="inline-flex items-center gap-1 rounded-md border border-rose-500 px-2.5 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50">
                                        <i class="bi bi-person-x"></i>Nonaktifkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-slate-500">Belum ada user aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div>{{ $activeUsers->links() }}</div>

    <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center gap-2 border-b border-slate-200 px-3 py-2.5 text-sm font-bold text-slate-800">
            <i class="bi bi-person-x text-slate-500"></i>
            Pengajuan Ditolak / Nonaktif
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold">Nama</th>
                        <th class="px-3 py-2 text-left font-semibold">Email</th>
                        <th class="px-3 py-2 text-left font-semibold">Status</th>
                        <th class="px-3 py-2 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rejectedUsers as $user)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-3 py-2.5">{{ $user->name }}</td>
                            <td class="px-3 py-2.5">{{ $user->email }}</td>
                            <td class="px-3 py-2.5">
                                <span class="inline-flex rounded-full bg-rose-100 px-2 py-0.5 text-xs font-semibold text-rose-700">{{ $user->status_akun }}</span>
                            </td>
                            <td class="px-3 py-2.5">
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                    @csrf
                                    <button class="inline-flex items-center gap-1 rounded-md border border-emerald-500 px-2.5 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">
                                        <i class="bi bi-arrow-repeat"></i>Aktifkan Kembali
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-slate-500">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div>{{ $rejectedUsers->links() }}</div>
</div>
@endsection
