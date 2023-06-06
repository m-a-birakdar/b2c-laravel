<?php

namespace Modules\Advertise\Entities;

use App\Models\TenantModelMongo;
use Modules\User\Entities\User;

class AdvertiseStatistics extends TenantModelMongo
{
    protected $collection = 'advertise_statistics';

    protected $fillable = [
        'advertise_id', 'user_id', 'type', 'created_at'
    ];

    public function advertise(): \Illuminate\Database\Eloquent\Relations\BelongsTo|\Jenssegers\Mongodb\Relations\BelongsTo
    {
        return $this->setConnection('tenant')->belongsTo(Advertise::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo|\Jenssegers\Mongodb\Relations\BelongsTo
    {
        return $this->setConnection('tenant')->belongsTo(User::class);
    }
}
