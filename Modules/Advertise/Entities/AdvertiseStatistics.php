<?php

namespace Modules\Advertise\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use Modules\User\Entities\User;

class AdvertiseStatistics extends Model
{
    protected $connection = 'mongodb';

    public $timestamps = false;

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
