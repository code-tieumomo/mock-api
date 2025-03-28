<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $mock_api_id
 * @property string $method
 * @property string $endpoint
 * @property array $request_data
 * @property array $response_data
 * @property int $status
 * @property string $action
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property MockApi $mockApi
 */
class MockRequest extends Model
{
    protected $fillable = [
        'mock_api_id',
        'method',
        'endpoint',
        'request_data',
        'response_data',
        'status',
        'action',
    ];

    public function mockApi()
    {
        return $this->belongsTo(MockApi::class);
    }
}
