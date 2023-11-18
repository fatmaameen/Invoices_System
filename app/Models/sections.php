<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class sections extends Model
{
    use HasFactory;
    protected $fillable=['section_name' ,'description' ,'created_by'];



    public function product():HasMany
    {
        return $this->hasMany(Product::class);
    }
}
