<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BookRental extends Model
{
  use HasFactory;

  protected $keyType = 'string';
  public $incrementing = false;
  public $table = 'book_rental';

  protected $fillable = [
    'people_id',
    'book_id',
    'delivery_date',
  ];

  public static function boot() {
    parent::boot();

    static::creating(function ($model) {
        $model->id = Str::uuid();
    });
  }
}
