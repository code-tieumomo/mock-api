<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $prefix
 * @property array $structure
 * @property array $storage
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User $user
 * @property MockRequest[] $mockRequests
 */
class MockApi extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'prefix',
        'structure',
        'storage',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'structure' => 'array',
            'storage' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mockRequests()
    {
        return $this->hasMany(MockRequest::class);
    }
}
