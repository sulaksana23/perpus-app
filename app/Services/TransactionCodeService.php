<?php

namespace App\Services;

use App\Models\Borrowing;
use Illuminate\Support\Carbon;

class TransactionCodeService
{
    public function generate(?Carbon $date = null): string
    {
        $date = $date ?? now();
        $prefix = 'TRX-'.$date->format('Ymd').'-';

        $lastCode = Borrowing::query()
            ->where('transaction_code', 'like', $prefix.'%')
            ->orderByDesc('transaction_code')
            ->value('transaction_code');

        $lastNumber = 0;

        if ($lastCode !== null) {
            $parts = explode('-', $lastCode);
            $lastNumber = (int) end($parts);
        }

        $nextNumber = str_pad((string) ($lastNumber + 1), 4, '0', STR_PAD_LEFT);

        return $prefix.$nextNumber;
    }
}
