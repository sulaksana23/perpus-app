<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@perpus.test'],
            [
                'name' => 'Admin Perpus',
                'password' => 'password123',
                'role' => 'admin',
                'status_akun' => 'active',
                'is_approved' => true,
                'status' => 'active',
            ],
        );

        $activeUser = User::query()->updateOrCreate(
            ['email' => 'user@perpus.test'],
            [
                'name' => 'User Aktif',
                'password' => 'password123',
                'role' => 'user',
                'status_akun' => 'active',
                'is_approved' => true,
                'status' => 'active',
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'pending@perpus.test'],
            [
                'name' => 'User Pending',
                'password' => 'password123',
                'role' => 'user',
                'status_akun' => 'pending',
                'is_approved' => false,
                'status' => 'inactive',
            ],
        );

        $categoryNames = ['Novel', 'Teknologi', 'Sejarah', 'Sains', 'Komik'];

        $categories = collect($categoryNames)->map(function (string $name) {
            return Category::query()->updateOrCreate(
                ['name' => $name],
                [
                    'description' => 'Kategori '.$name,
                    'is_active' => true,
                ],
            );
        });

        if (Book::query()->count() < 15) {
            foreach (range(1, 20) as $index) {
                Book::query()->updateOrCreate(
                    ['code' => 'BK-'.str_pad((string) $index, 4, '0', STR_PAD_LEFT)],
                    [
                        'title' => 'Buku Contoh '.$index,
                        'author' => 'Penulis '.$index,
                        'publisher' => 'Penerbit '.$index,
                        'year' => (int) now()->format('Y') - random_int(0, 10),
                        'stock' => random_int(0, 8),
                        'category_id' => $categories->random()->id,
                        'description' => 'Deskripsi buku contoh nomor '.$index,
                    ],
                );
            }
        }

        if (Borrowing::query()->count() === 0) {
            $sampleBorrowing = Borrowing::query()->create([
                'transaction_code' => 'TRX-'.now()->format('Ymd').'-0001',
                'user_id' => $activeUser->id,
                'borrow_date' => now()->toDateString(),
                'return_date' => now()->addDays(7)->toDateString(),
                'status' => 'pending',
                'notes' => 'Contoh pengajuan peminjaman dari seeder.',
            ]);

            $book = Book::query()->where('stock', '>', 0)->first();
            if ($book) {
                BorrowingDetail::query()->create([
                    'borrowing_id' => $sampleBorrowing->id,
                    'book_id' => $book->id,
                    'qty' => 1,
                ]);
            }
        }

        $admin->refresh();
    }
}
