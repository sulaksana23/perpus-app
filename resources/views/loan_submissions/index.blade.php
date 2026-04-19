@extends('layouts.app', ['title' => 'Pengajuan Peminjaman'])

@section('content')
    <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-slate-900">Pengajuan Peminjaman</h1>
                <p class="mt-1 text-sm text-slate-500">Cek dan review pengajuan peminjaman dari anggota.</p>
            </div>
            <div class="flex gap-2 text-sm">
                <a href="{{ route('loan-submissions.index') }}" class="rounded-lg border px-3 py-1.5 {{ $status === '' ? 'border-blue-600 bg-blue-50 text-blue-700' : 'border-slate-300 text-slate-700' }}">Semua</a>
                <a href="{{ route('loan-submissions.index', ['status' => 'pending']) }}" class="rounded-lg border px-3 py-1.5 {{ $status === 'pending' ? 'border-amber-600 bg-amber-50 text-amber-700' : 'border-slate-300 text-slate-700' }}">Pending</a>
                <a href="{{ route('loan-submissions.index', ['status' => 'approved']) }}" class="rounded-lg border px-3 py-1.5 {{ $status === 'approved' ? 'border-emerald-600 bg-emerald-50 text-emerald-700' : 'border-slate-300 text-slate-700' }}">Approved</a>
                <a href="{{ route('loan-submissions.index', ['status' => 'rejected']) }}" class="rounded-lg border px-3 py-1.5 {{ $status === 'rejected' ? 'border-rose-600 bg-rose-50 text-rose-700' : 'border-slate-300 text-slate-700' }}">Rejected</a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-slate-200">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <th class="px-3 py-2">Anggota</th>
                        <th class="px-3 py-2">Buku</th>
                        <th class="px-3 py-2">Catatan</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($submissions as $submission)
                        <tr>
                            <td class="px-3 py-2 font-medium">{{ $submission->member->name ?? '-' }}</td>
                            <td class="px-3 py-2">{{ $submission->book->title ?? '-' }}</td>
                            <td class="px-3 py-2 text-slate-500">{{ $submission->notes ?: '-' }}</td>
                            <td class="px-3 py-2">
                                <span class="rounded-full px-2 py-0.5 text-xs font-semibold
                                    {{ $submission->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($submission->status === 'rejected' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">
                                    {{ strtoupper($submission->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                @if($submission->status === 'pending')
                                    <div class="flex gap-2">
                                        <form action="{{ route('loan-submissions.approve', $submission) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rounded-md bg-emerald-600 px-2 py-1 text-xs font-semibold text-white hover:bg-emerald-700">Setujui</button>
                                        </form>
                                        <form action="{{ route('loan-submissions.reject', $submission) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="rounded-md bg-rose-600 px-2 py-1 text-xs font-semibold text-white hover:bg-rose-700">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400">Sudah direview</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3 py-6 text-center text-slate-500">Belum ada pengajuan peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $submissions->links() }}</div>
    </section>
@endsection
