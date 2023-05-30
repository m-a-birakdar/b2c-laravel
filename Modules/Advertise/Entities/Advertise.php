<?php

namespace Modules\Advertise\Entities;

use App\OverrideModel;
use App\Traits\ScopeModels;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Modules\User\Entities\User;

class Advertise extends OverrideModel
{
    use ScopeModels, HybridRelations;

    protected $fillable = ['image', 'url', 'type', 'rank', 'redirect_in', 'user_id'];

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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statistics(): \Illuminate\Database\Eloquent\Relations\HasMany|\Jenssegers\Mongodb\Relations\HasMany
    {
        return $this->hasMany(AdvertiseStatistics::class);
    }
}
