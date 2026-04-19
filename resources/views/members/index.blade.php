@extends('layouts.app', ['title' => 'Kelola Anggota'])

@section('content')
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Data Anggota</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola anggota, status aktif/nonaktif, dan data kontak.</p>
            </div>
            <a href="{{ route('members.create') }}" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">+ Tambah Anggota</a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <th class="px-3 py-2">Nama</th>
                        <th class="px-3 py-2">Username</th>
                        <th class="px-3 py-2">Kontak</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($members as $member)
                        <tr>
                            <td class="px-3 py-2 font-medium">{{ $member->name }}<p class="text-xs text-slate-500">{{ $member->email }}</p></td>
                            <td class="px-3 py-2">{{ $member->username ?: '-' }}</td>
                            <td class="px-3 py-2">{{ $member->phone ?: '-' }}</td>
                            <td class="px-3 py-2"><span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $member->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">{{ strtoupper($member->status ?: 'ACTIVE') }}</span></td>
                            <td class="px-3 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('members.edit', $member) }}" class="rounded border px-2 py-1 text-xs">Edit</a>
                                    <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?')">@csrf @method('DELETE')<button class="rounded bg-rose-600 px-2 py-1 text-xs text-white">Hapus</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3 py-6 text-center text-slate-500">Belum ada data anggota.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $members->links() }}</div>
    </section>
@endsection
