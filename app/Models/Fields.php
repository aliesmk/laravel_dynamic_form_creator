<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fields extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'field';
    protected $fillable = [
        'form_id',
        'label',
        'key',
        'options',
        'placeholder',
        'required',
        'tooltip',
        'sequence',
        'field_type_id'
    ];


    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function fieldTypes()
    {
        return $this->hasOne(FieldType::class, 'id', 'field_type_id',);
    }

}
