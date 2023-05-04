<?php

namespace Modules\Advertise\Entities;

use App\OverrideModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Entities\User;

class Advertise extends OverrideModel
{
    protected $fillable = ['image', 'url', 'type', 'rank', 'views', 'redirect_in', 'user_id'];

    protected $casts = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            $model->user_id = auth()->id();
        });
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
