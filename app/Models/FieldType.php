<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    protected $table = 'field_type';
    protected $fillable = ['name', 'description', 'is_optional'];


    public function fields()
    {
        return $this->hasMany(Fields::class, 'field_type_id', 'id');
    }



}
