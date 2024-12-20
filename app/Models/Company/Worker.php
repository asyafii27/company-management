<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'manager_id',
        'name',
        'phone_number',
        'address',
        'deleted_at'
    ];

    public function manager()
    {
        return $this->belongsTo(Manager::class);
    }
}
