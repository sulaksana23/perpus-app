<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoanManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_user_can_cancel_own_pending_loan(): void
    {
        $user = $this->activeUser();
        $book = Book::factory()->create();

        $borrowing = Borrowing::query()->create([
            'transaction_code' => 'TRX-20260426-0001',
            'user_id' => $user->id,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDays(7)->toDateString(),
            'status' => 'pending',
        ]);

        BorrowingDetail::query()->create([
            'borrowing_id' => $borrowing->id,
            'book_id' => $book->id,
            'qty' => 1,
        ]);

        $this->actingAs($user)
            ->delete(route('user.loans.destroy', $borrowing))
            ->assertRedirect(route('user.loans.index'));

        $this->assertDatabaseMissing('borrowings', [
            'id' => $borrowing->id,
        ]);
    }

    public function test_user_can_return_own_borrowed_loan_and_stock_is_restored(): void
    {
        $user = $this->activeUser();
        $book = Book::factory()->create([
            'stock' => 0,
        ]);

        $borrowing = Borrowing::query()->create([
            'transaction_code' => 'TRX-20260426-0002',
            'user_id' => $user->id,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDays(7)->toDateString(),
            'status' => 'borrowed',
            'borrowed_at' => now(),
        ]);

        BorrowingDetail::query()->create([
            'borrowing_id' => $borrowing->id,
            'book_id' => $book->id,
            'qty' => 1,
        ]);

        $this->actingAs($user)
            ->post(route('user.loans.return', $borrowing))
            ->assertRedirect(route('user.loans.show', $borrowing));

        $this->assertDatabaseHas('borrowings', [
            'id' => $borrowing->id,
            'status' => 'returned',
        ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'stock' => 1,
        ]);
    }

    public function test_user_cannot_manage_other_users_loan(): void
    {
        $owner = $this->activeUser();
        $otherUser = $this->activeUser();

        $borrowing = Borrowing::query()->create([
            'transaction_code' => 'TRX-20260426-0003',
            'user_id' => $owner->id,
            'borrow_date' => now()->toDateString(),
            'return_date' => now()->addDays(7)->toDateString(),
            'status' => 'pending',
        ]);

        $this->actingAs($otherUser)
            ->delete(route('user.loans.destroy', $borrowing))
            ->assertForbidden();
    }

    private function activeUser(): User
    {
        return User::factory()->create([
            'role' => 'user',
            'status_akun' => 'active',
            'is_approved' => true,
            'status' => 'active',
        ]);
    }
}
