<?php

namespace App\Models\Company;

use App\Models\Company\Worker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Manager extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'perusahaan_id',
        'name',
        'phone_number',
        'address',
        'deleted_at'
    ];

    
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function worker()
    {
        return $this->hasMany(Worker::class);
    }
}
