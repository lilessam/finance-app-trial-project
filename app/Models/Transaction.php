<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @deprecated Use the "casts" property
     *
     * @var array
     */
    protected $dates = [
        'amount_date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'transaction_readable_date',
        'amount_integer',
        'amount_decimals',
        'amount_type',
        'amount_date_time'
    ];

    /**
     * Add `transaction_readable_date` attribute.
     *
     * @return string
     */
    public function getTransactionReadableDateAttribute()
    {
        return $this->amount_date->toDayDateTimeString();
    }

    /**
     * Add `amount_integer` attribute.
     *
     * @return float
     */
    public function getAmountIntegerAttribute()
    {
        return abs(sscanf($this->amount, '%d.%d')[0]);
    }

    /**
     * Add `amount_decimals` attribute.
     *
     * @return float
     */
    public function getAmountDecimalsAttribute()
    {
        return explode('.', number_format($this->amount, 2))[1];
    }

    /**
     * Add `amount_type` attribute.
     *
     * @return string|null
     */
    public function getAmountTypeAttribute()
    {
        return $this->amount < 0 ? '-' : '';
    }

    /**
     * Add `amount_date_time` for HTML markup.
     *
     * @return string
     */
    public function getAmountDateTimeAttribute()
    {
        return date("Y-m-d\TH:i:s", strtotime($this->amount_date));
    }
}
