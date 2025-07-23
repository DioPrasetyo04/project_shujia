<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'booking_trx_id',
        'name',
        'email',
        'phone',
        'started_time',
        'schedule_at',
        'proof',
        'post_code',
        'city',
        'address',
        'sub_total',
        'total_amount',
        'total_tax_amount',
        'is_paid',
    ];

    public static function generateUniqueTrxId()
    {
        $prefix = 'Project_SHUJIA-';
        do {
            $$randomId = $prefix . mt_rand(100000, 999999);
            // tidak boleh ada data sama idnya self:where exists
        } while (self::where('booking_trx_id', $randomId)->exists());

        return $randomId;
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetails::class);
    }
}
