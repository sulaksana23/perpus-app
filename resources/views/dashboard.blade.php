@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    @if($isAdmin)
        <div class="space-y-4">
            <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 md:text-3xl">Dashboard Admin</h1>
                        <p class="mt-1 text-sm text-slate-600">Monitoring lengkap data perpustakaan: anggota, buku, transaksi, dan pengajuan.</p>
                        <div class="mt-2 flex flex-wrap gap-2 text-xs font-semibold">
                            <span class="rounded-full border border-blue-200 bg-blue-50 px-2.5 py-1 text-blue-700">Role: {{ strtoupper($role ?: 'ADMIN') }}</span>
                            <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-emerald-700">Status: Login aktif</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('members.index') }}" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Kelola Anggota</a>
                        <a href="{{ route('books.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Kelola Buku</a>
                        <a href="{{ route('transactions.index') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Kelola Transaksi</a>
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-2 gap-3 lg:grid-cols-3 xl:grid-cols-6">
                <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                    <p class="text-xs text-slate-500">Total Anggota</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($dashboardData['kpi']['members']) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                    <p class="text-xs text-slate-500">Total Buku</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($dashboardData['kpi']['books']) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                    <p class="text-xs text-slate-500">Total Transaksi</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($dashboardData['kpi']['transactions']) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                    <p class="text-xs text-slate-500">Sedang Dipinjam</p>
                    <p class="mt-1 text-2xl font-bold text-blue-700">{{ number_format($dashboardData['kpi']['active_loans']) }}</p>
                </div>
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-3 shadow-sm">
                    <p class="text-xs text-amber-700">Pending Pengajuan Akun</p>
                    <p class="mt-1 text-2xl font-bold text-amber-800">{{ number_format($dashboardData['kpi']['pending_account_submissions']) }}</p>
                </div>
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-3 shadow-sm">
                    <p class="text-xs text-amber-700">Pending Pengajuan Pinjam</p>
                    <p class="mt-1 text-2xl font-bold text-amber-800">{{ number_format($dashboardData['kpi']['pending_loan_submissions']) }}</p>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-4 xl:grid-cols-3">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm xl:col-span-2">
                    <h2 class="mb-2 text-sm font-semibold text-slate-800">Trend Transaksi 6 Bulan Terakhir</h2>
                    <div id="txTrendChart" class="h-[320px]"></div>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 class="mb-2 text-sm font-semibold text-slate-800">Distribusi Status Transaksi</h2>
                    <div class="mx-auto max-w-[300px]">
                        <canvas id="txStatusChart" height="300"></canvas>
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h2 class="mb-2 text-sm font-semibold text-slate-800">Kategori Buku Terbanyak</h2>
                <canvas id="bookCategoryChart" height="110"></canvas>
            </section>

            <section class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 class="mb-3 text-sm font-semibold text-slate-800">Transaksi Terbaru</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs text-slate-500">
                                    <th class="pb-2">Anggota</th>
                                    <th class="pb-2">Buku</th>
                                    <th class="pb-2">Status</th>
                                    <th class="pb-2">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($dashboardData['latest_transactions'] as $transaction)
                                    <tr>
                                        <td class="py-2 font-medium text-slate-800">{{ $transaction->member->name ?? '-' }}</td>
                                        <td class="py-2 text-slate-600">{{ $transaction->book->title ?? '-' }}</td>
                                        <td class="py-2"><span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700">{{ strtoupper($transaction->status) }}</span></td>
                                        <td class="py-2 text-slate-500">{{ $transaction->borrowed_at?->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="py-4 text-center text-slate-500">Belum ada data transaksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 class="mb-3 text-sm font-semibold text-slate-800">Buku Stok Menipis (<= 3)</h2>
                    <div class="space-y-2">
                        @forelse($dashboardData['low_stock_books'] as $book)
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 px-3 py-2">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">{{ $book->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $book->author }}{{ $book->category_label ? ' • '.$book->category_label : '' }}</p>
                                </div>
                                <span class="rounded-full bg-rose-50 px-2 py-0.5 text-xs font-semibold text-rose-700">Stok: {{ $book->stock }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Semua buku masih aman, stok menipis belum ada.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 class="mb-3 text-sm font-semibold text-slate-800">Pengajuan Akun Terbaru</h2>
                    <div class="space-y-2">
                        @forelse($dashboardData['recent_account_submissions'] as $submission)
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 px-3 py-2">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">{{ $submission->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $submission->email }}</p>
                                </div>
                                <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $submission->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($submission->status === 'rejected' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">{{ strtoupper($submission->status) }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada pengajuan akun.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 class="mb-3 text-sm font-semibold text-slate-800">Pengajuan Pinjam Terbaru</h2>
                    <div class="space-y-2">
                        @forelse($dashboardData['recent_loan_submissions'] as $submission)
                            <div class="flex items-center justify-between rounded-lg border border-slate-200 px-3 py-2">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">{{ $submission->member->name ?? '-' }} → {{ $submission->book->title ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">{{ $submission->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $submission->status === 'approved' ? 'bg-emerald-50 text-emerald-700' : ($submission->status === 'rejected' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">{{ strtoupper($submission->status) }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada pengajuan peminjaman.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function () {
                const txTrendEl = document.querySelector('#txTrendChart');
                if (txTrendEl && window.ApexCharts) {
                    const txTrendChart = new ApexCharts(txTrendEl, {
                        chart: {
                            type: 'area',
                            height: 300,
                            toolbar: { show: false },
                            zoom: { enabled: false }
                        },
                        series: [{
                            name: 'Transaksi',
                            data: @json($dashboardData['monthly_transaction_series'])
                        }],
                        xaxis: {
                            categories: @json($dashboardData['monthly_transaction_labels'])
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        colors: ['#2563eb'],
                        dataLabels: { enabled: false },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.35,
                                opacityTo: 0.05,
                            }
                        },
                        grid: {
                            borderColor: '#e2e8f0'
                        }
                    });
                    txTrendChart.render();
                }

                const statusCtx = document.getElementById('txStatusChart');
                if (statusCtx && window.Chart) {
                    new Chart(statusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: @json($dashboardData['transaction_status_labels']),
                            datasets: [{
                                data: @json($dashboardData['transaction_status_series']),
                                backgroundColor: ['#2563eb', '#10b981', '#f59e0b'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            plugins: {
                                legend: { position: 'bottom' }
                            },
                            cutout: '68%'
                        }
                    });
                }

                const categoryCtx = document.getElementById('bookCategoryChart');
                if (categoryCtx && window.Chart) {
                    new Chart(categoryCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($dashboardData['book_category_labels']),
                            datasets: [{
                                label: 'Jumlah Buku',
                                data: @json($dashboardData['book_category_series']),
                                borderRadius: 8,
                                backgroundColor: '#3b82f6'
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            },
                            plugins: {
                                legend: { display: false }
                            }
                        }
                    });
                }
            })();
        </script>
    @else
        <div class="space-y-4">
            <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm md:p-5">
                <h1 class="text-2xl font-bold text-slate-900">Dashboard Member</h1>
                <p class="mt-1 text-sm text-slate-600">Pantau status pinjaman dan pengajuan Anda secara ringkas.</p>
                <div class="mt-3 flex flex-wrap gap-2 text-xs font-semibold">
                    <span class="rounded-full border border-blue-200 bg-blue-50 px-2.5 py-1 text-blue-700">Role: {{ strtoupper($role ?: 'MEMBER') }}</span>
                    <span class="rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-emerald-700">Status: Login aktif</span>
                </div>
                <div class="mt-3">
                    <a href="{{ route('borrow-requests.create') }}" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Ajukan Peminjaman Buku</a>
                </div>
            </section>

            <section class="grid grid-cols-2 gap-3 lg:grid-cols-5">
                <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                    <p class="text-xs text-slate-500">Total Transaksi Saya</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($dashboardData['kpi']['my_transactions']) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                    <p class="text-xs text-slate-500">Sedang Dipinjam</p>
                    <p class="mt-1 text-2xl font-bold text-blue-700">{{ number_format($dashboardData['kpi']['my_active_loans']) }}</p>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                    <p class="text-xs text-slate-500">Pengajuan Saya</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($dashboardData['kpi']['my_loan_submissions']) }}</p>
                </div>
                <div class="rounded-xl border border-amber-200 bg-amber-50 p-3 shadow-sm">
                    <p class="text-xs text-amber-700">Pending Pengajuan</p>
                    <p class="mt-1 text-2xl font-bold text-amber-800">{{ number_format($dashboardData['kpi']['pending_my_submissions']) }}</p>
                </div>
                <div class="rounded-xl border border-rose-200 bg-rose-50 p-3 shadow-sm">
                    <p class="text-xs text-rose-700">Denda Belum Lunas</p>
                    <p class="mt-1 text-2xl font-bold text-rose-800">Rp {{ number_format((float) $dashboardData['kpi']['my_unpaid_fines'], 0, ',', '.') }}</p>
                </div>
            </section>

            <section class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 class="mb-2 text-sm font-semibold text-slate-800">Status Pengajuan Peminjaman Saya</h2>
                    <div class="mx-auto max-w-[320px]">
                        <canvas id="memberSubmissionChart" height="270"></canvas>
                    </div>
                </div>

                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <h2 class="mb-3 text-sm font-semibold text-slate-800">Transaksi Terbaru Saya</h2>
                    <div class="space-y-2">
                        @forelse($dashboardData['my_latest_transactions'] as $transaction)
                            <div class="rounded-lg border border-slate-200 px-3 py-2">
                                <p class="text-sm font-medium text-slate-800">{{ $transaction->book->title ?? '-' }}</p>
                                <p class="text-xs text-slate-500">{{ $transaction->borrowed_at?->format('d M Y') }} • {{ strtoupper($transaction->status) }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Belum ada transaksi.</p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h2 class="mb-3 text-sm font-semibold text-slate-800">Buku Tersedia untuk Dipinjam</h2>
                <div class="grid grid-cols-1 gap-2 md:grid-cols-2 xl:grid-cols-4">
                    @forelse($dashboardData['books_ready_to_borrow'] as $book)
                        <div class="rounded-lg border border-slate-200 px-3 py-2">
                            <p class="text-sm font-medium text-slate-800">{{ $book->title }}</p>
                            <p class="text-xs text-slate-500">{{ $book->author }}</p>
                            <span class="mt-1 inline-block rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700">Stok {{ $book->stock }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada buku tersedia.</p>
                    @endforelse
                </div>
            </section>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function () {
                const memberCtx = document.getElementById('memberSubmissionChart');
                if (memberCtx && window.Chart) {
                    new Chart(memberCtx, {
                        type: 'doughnut',
                        data: {
                            labels: @json($dashboardData['my_submission_labels']),
                            datasets: [{
                                data: @json($dashboardData['my_submission_series']),
                                backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            plugins: {
                                legend: { position: 'bottom' }
                            },
                            cutout: '66%'
                        }
                    });
                }
            })();
        </script>
    @endif
@endsection
