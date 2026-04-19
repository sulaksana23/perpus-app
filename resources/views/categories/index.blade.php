@extends('layouts.app', ['title' => 'Kategori Buku'])

@section('content')
<section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-bold">Kategori Buku</h1>
        <a href="{{ route('categories.create') }}" class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white">+ Kategori</a>
    </div>
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-xs text-slate-600"><tr><th class="px-3 py-2 text-left">Nama</th><th class="px-3 py-2 text-left">Status</th><th class="px-3 py-2 text-left">Aksi</th></tr></thead>
            <tbody class="divide-y">
            @forelse($categories as $category)
                <tr>
                    <td class="px-3 py-2">{{ $category->name }}</td>
                    <td class="px-3 py-2">{{ $category->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="px-3 py-2 flex gap-2">
                        <a href="{{ route('categories.edit', $category) }}" class="rounded border px-2 py-1 text-xs">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST">@csrf @method('DELETE')<button class="rounded bg-rose-600 px-2 py-1 text-xs text-white">Hapus</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-3 py-6 text-center text-slate-500">Belum ada kategori.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $categories->links() }}</div>
</section>
@endsection
