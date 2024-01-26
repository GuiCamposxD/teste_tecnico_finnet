<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Book extends Model
{
  use HasFactory;

  protected $keyType = 'string';
  public $incrementing = false;
  public $table = 'book';

  protected $fillable = [
    'title',
    'author',
    'publisher',
    'quantity',
  ];

  public static function boot() {
    parent::boot();

    static::creating(function ($model) {
        $model->id = Str::uuid();
    });
  }

  public function people(): BelongsToMany {
    return $this->belongsToMany(People::class, 'book_rental');
  }    
}
