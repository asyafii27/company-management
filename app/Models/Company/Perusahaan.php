<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perusahaan extends Model
{
    use SoftDeletes;
    
    protected $table = 'perusahaan';
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'deleted_at'
    ];

    public function manager()
    {
        return $this->hasMany(Manager::class);
    }
}
