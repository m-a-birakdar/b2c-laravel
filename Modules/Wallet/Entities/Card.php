<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Card extends Model
{
    use HasFactory;

    protected $table = 'cards';

    protected $fillable = ['number', 'cvv', 'value', 'status'];

    public function transaction(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Transaction::class, 'sourceable');
    }

    protected static function newFactory(): \Modules\Wallet\Database\factories\CardFactory
    {
        return \Modules\Wallet\Database\factories\CardFactory::new();
    }
}
