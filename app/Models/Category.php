<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id';

    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['name','slug','description'];
    public function products(){
        return $this->hasMany(Product::class,'category_id','category_id');
    }
}
