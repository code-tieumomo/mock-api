<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $endpoint
 * @property array $storage
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User $user
 * @property MockRequest[] $mockRequests
 */
class MockApi extends Model
{
    protected $fillable = [
        'user_id',
        'endpoint',
        'storage',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mockRequests()
    {
        return $this->hasMany(MockRequest::class);
    }
}
