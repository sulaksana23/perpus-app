@extends('layouts.admin', ['title' => 'Dashboard Admin'])

@php
    $statusClasses = [
        'pending' => 'bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-200',
        'approved' => 'bg-sky-50 text-sky-700 ring-1 ring-inset ring-sky-200',
        'borrowed' => 'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200',
        'returned' => 'bg-slate-100 text-slate-700 ring-1 ring-inset ring-slate-200',
        'rejected' => 'bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200',
    ];

    $summaryCards = [
        [
            'label' => 'Total Buku',
            'value' => $stats['books'],
            'icon' => 'bi-journal-richtext',
            'tone' => 'from-sky-500/10 to-cyan-500/10 text-sky-700',
            'meta' => 'Koleksi terdaftar',
            'meta_icon' => 'bi-collection',
        ],
        [
            'label' => 'Kategori',
            'value' => $stats['categories'],
            'icon' => 'bi-tags',
            'tone' => 'from-violet-500/10 to-indigo-500/10 text-violet-700',
            'meta' => 'Kelompok buku',
            'meta_icon' => 'bi-diagram-3',
        ],
        [
            'label' => 'User',
            'value' => $stats['users'],
            'icon' => 'bi-people',
            'tone' => 'from-teal-500/10 to-emerald-500/10 text-teal-700',
            'meta' => 'Anggota terdaftar',
            'meta_icon' => 'bi-person-badge',
        ],
        [
            'label' => 'Pengajuan Akun',
            'value' => $stats['pending_accounts'],
            'icon' => 'bi-person-check',
            'tone' => 'from-amber-500/10 to-orange-500/10 text-amber-700',
            'meta' => 'Menunggu review',
            'meta_icon' => 'bi-hourglass-split',
        ],
        [
            'label' => 'Peminjaman Aktif',
            'value' => $stats['active_loans'],
            'icon' => 'bi-arrow-repeat',
            'tone' => 'from-rose-500/10 to-pink-500/10 text-rose-700',
            'meta' => 'Approved & borrowed',
            'meta_icon' => 'bi-journal-check',
        ],
    ];

    $quickLinks = [
        [
            'label' => 'Kelola Buku',
            'description' => 'Tambah atau perbarui koleksi.',
            'route' => route('admin.books.index'),
            'icon' => 'bi-journal-plus',
            'arrow' => 'bi-arrow-up-right',
        ],
        [
            'label' => 'Review Akun',
            'description' => 'Cek user yang masih pending.',
            'route' => route('admin.users.pending'),
            'icon' => 'bi-person-gear',
            'arrow' => 'bi-arrow-up-right',
        ],
        [
            'label' => 'Proses Pinjam',
            'description' => 'Lihat antrean pengajuan buku.',
            'route' => route('admin.loan_requests.index'),
            'icon' => 'bi-inboxes',
            'arrow' => 'bi-arrow-up-right',
        ],
    ];
@endphp

@section('content')
<div class="space-y-3">
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="grid gap-3 px-4 py-4 lg:grid-cols-[minmax(0,1.35fr)_minmax(300px,0.9fr)] lg:px-5">
            <div class="min-w-0">
                <div class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-white">
                    <span class="inline-block h-2 w-2 rounded-full bg-emerald-400"></span>
                    Panel Operasional
                </div>
                <h2 class="mt-3 mb-1 flex items-center gap-2 text-lg font-extrabold tracking-tight text-slate-900 lg:text-[1.65rem]">
                    <i class="bi bi-shield-check text-teal-700"></i>
                    Kontrol perpustakaan dalam satu tampilan
                </h2>
                <p class="mb-0 max-w-2xl text-sm leading-6 text-slate-600">
                    Ringkasan ini membantu admin memantau koleksi, antrean akun, dan aktivitas peminjaman tanpa harus berpindah-pindah halaman.
                </p>
            </div>

            <div class="grid gap-2 sm:grid-cols-3 lg:grid-cols-1">
                @foreach($quickLinks as $link)
                    <a href="{{ $link['route'] }}" class="group flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-decoration-none transition hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white">
                        <span class="inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-white text-slate-700 shadow-sm ring-1 ring-slate-200">
                            <i class="bi {{ $link['icon'] }}"></i>
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-semibold text-slate-900">{{ $link['label'] }}</span>
                            <span class="block text-xs leading-5 text-slate-500">{{ $link['description'] }}</span>
                        </span>
                        <i class="bi {{ $link['arrow'] }} text-slate-400 transition group-hover:text-slate-700"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="grid gap-2.5 sm:grid-cols-2 xl:grid-cols-5">
        @foreach($summaryCards as $card)
            <article class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="mb-1 flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">
                            <i class="bi {{ $card['icon'] }}"></i>
                            {{ $card['label'] }}
                        </p>
                        <div class="flex items-end gap-2">
                            <h3 class="mb-0 text-[1.75rem] font-extrabold leading-none text-slate-900">{{ $card['value'] }}</h3>
                        </div>
                        <p class="mt-2 mb-0 flex items-center gap-1.5 text-xs text-slate-500">
                            <i class="bi {{ $card['meta_icon'] }}"></i>
                            {{ $card['meta'] }}
                        </p>
                    </div>
                    <span class="inline-flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br {{ $card['tone'] }}">
                        <i class="bi {{ $card['icon'] }} text-base"></i>
                    </span>
                </div>
            </article>
        @endforeach
    </section>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between gap-3 border-bottom px-4 py-2.5 lg:px-5">
            <div>
                <h3 class="mb-1 text-base font-bold text-slate-900"><i class="bi bi-clock-history me-2 text-slate-500"></i>Peminjaman Terbaru</h3>
                <p class="mb-0 text-xs text-slate-500">Daftar transaksi terbaru yang perlu dipantau admin.</p>
            </div>
            <a href="{{ route('admin.loan_requests.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-box-arrow-up-right me-1"></i>Lihat semua
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="text-xs fw-bold text-uppercase text-slate-500"><i class="bi bi-receipt-cutoff me-1"></i>Transaksi</th>
                        <th class="text-xs fw-bold text-uppercase text-slate-500"><i class="bi bi-person me-1"></i>User</th>
                        <th class="text-xs fw-bold text-uppercase text-slate-500"><i class="bi bi-calendar3 me-1"></i>Periode</th>
                        <th class="text-xs fw-bold text-uppercase text-slate-500"><i class="bi bi-patch-check me-1"></i>Status</th>
                        <th class="text-xs fw-bold text-uppercase text-slate-500 text-end"><i class="bi bi-lightning-charge me-1"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($latestBorrowings as $item)
                    <tr>
                        <td>
                            <div class="fw-semibold text-slate-800"><i class="bi bi-upc-scan me-1 text-slate-400"></i>{{ $item->transaction_code }}</div>
                            <div class="text-xs text-slate-500"><i class="bi bi-journals me-1"></i>{{ $item->details_count ?? $item->details->count() }} buku diajukan</div>
                        </td>
                        <td>
                            <div class="fw-semibold text-slate-800"><i class="bi bi-person-circle me-1 text-slate-400"></i>{{ $item->user?->name ?? '-' }}</div>
                            <div class="text-xs text-slate-500"><i class="bi bi-envelope me-1"></i>{{ $item->user?->email ?? 'Email tidak tersedia' }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold text-slate-800"><i class="bi bi-calendar-event me-1 text-slate-400"></i>{{ $item->borrow_date?->format('d M Y') }}</div>
                            <div class="text-xs text-slate-500"><i class="bi bi-arrow-right me-1"></i>s/d {{ $item->return_date?->format('d M Y') }}</div>
                        </td>
                        <td>
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $statusClasses[$item->status] ?? 'bg-slate-100 text-slate-700 ring-1 ring-inset ring-slate-200' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.loan_requests.show', $item) }}" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-5 text-center">
                            <div class="mx-auto flex max-w-sm flex-col items-center">
                                <span class="mb-3 inline-flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                                    <i class="bi bi-inboxes"></i>
                                </span>
                                <h4 class="mb-1 text-sm font-bold text-slate-800">Belum ada transaksi terbaru</h4>
                                <p class="mb-0 text-xs leading-5 text-slate-500">Saat user mulai mengajukan peminjaman, datanya akan muncul di dashboard ini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
