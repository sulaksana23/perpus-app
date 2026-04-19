<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Fine;
use App\Models\Rating;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::findOrCreate('admin', 'web');
        $memberRole = Role::findOrCreate('member', 'web');

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'username' => 'admin', 'password' => 'password123', 'role' => 'admin', 'is_approved' => true, 'status' => 'active']
        );
        $admin->assignRole($adminRole);

        $newUsers = User::factory(5)->create();
        $newUsers->each(function (User $user) use ($memberRole): void {
            $user->update([
                'username' => $user->username ?: strtolower(str_replace(' ', '', $user->name)).$user->id,
                'phone' => $user->phone ?: '08'.random_int(1000000000, 9999999999),
                'address' => $user->address ?: 'Alamat anggota '.$user->name,
                'role' => 'member',
                'is_approved' => true,
                'status' => 'active',
            ]);
            $user->assignRole($memberRole);
        });

        $categories = collect([
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Pemrograman',
            'Sains',
            'Sejarah',
        ])->map(function (string $name) {
            return Category::query()->firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name, 'description' => 'Kategori '.$name, 'is_active' => true]
            );
        });

        if (Book::query()->count() < 10) {
            foreach (range(1, 20) as $index) {
                Book::query()->create([
                    'code' => 'BK-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT),
                    'title' => 'Buku Contoh '.$index,
                    'author' => 'Penulis '.$index,
                    'publisher' => 'Penerbit Sekolah',
                    'category_id' => $categories->random()->id,
                    'rack' => 'R'.random_int(1, 9).'-'.random_int(1, 4),
                    'description' => 'Deskripsi buku contoh '.$index,
                    'isbn' => '978000000'.$index,
                    'stock' => random_int(1, 20),
                    'status' => 'tersedia',
                    'price' => random_int(30000, 120000),
                    'published_year' => random_int(2015, 2026),
                    'avg_rating' => random_int(30, 50) / 10,
                    'popular_score' => random_int(10, 200),
                ]);
            }
        }

        collect([
            ['name' => 'Buku rusak ringan', 'slug' => 'buku-rusak-ringan', 'amount' => 10000, 'type' => 'fixed'],
            ['name' => 'Buku rusak berat', 'slug' => 'buku-rusak-berat', 'amount' => 25000, 'type' => 'fixed'],
            ['name' => 'Buku hilang', 'slug' => 'buku-hilang', 'amount' => 100, 'type' => 'percentage'],
            ['name' => 'Telat per hari', 'slug' => 'telat-per-hari', 'amount' => 2000, 'type' => 'per_day'],
            ['name' => 'Cover sobek', 'slug' => 'cover-sobek', 'amount' => 5000, 'type' => 'fixed'],
            ['name' => 'Halaman hilang', 'slug' => 'halaman-hilang', 'amount' => 15000, 'type' => 'fixed'],
        ])->each(function (array $fine): void {
            Fine::query()->updateOrCreate(['slug' => $fine['slug']], $fine + ['is_active' => true]);
        });

        $members = User::query()->role('member')->get();
        $books = Book::query()->limit(15)->get();
        if (Transaction::query()->count() < 10) {
            foreach (range(1, 30) as $i) {
                $borrowedAt = now()->subDays(random_int(1, 120));
                $dueAt = (clone $borrowedAt)->addDays(7);
                $returned = random_int(0, 1) ? (clone $borrowedAt)->addDays(random_int(2, 14)) : null;
                Transaction::query()->create([
                    'code' => 'TRX-'.now()->format('Ymd').'-'.str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                    'member_id' => $members->random()->id,
                    'book_id' => $books->random()->id,
                    'borrowed_at' => $borrowedAt->toDateString(),
                    'due_at' => $dueAt->toDateString(),
                    'returned_at' => $returned?->toDateString(),
                    'late_days' => $returned && $returned->gt($dueAt) ? $dueAt->diffInDays($returned) : 0,
                    'status' => $returned ? ($returned->gt($dueAt) ? 'terlambat' : 'dikembalikan') : 'dipinjam',
                    'total_fine' => 0,
                ]);
            }
        }

        if (Rating::query()->count() < 10) {
            foreach (range(1, 40) as $_) {
                Rating::query()->updateOrCreate(
                    ['member_id' => $members->random()->id, 'book_id' => $books->random()->id],
                    ['rating' => random_int(3, 5), 'review' => 'Buku bagus untuk belajar.']
                );
            }
        }
    }
}
