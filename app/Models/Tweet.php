<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable =
      [
        'criticism',
        'constructive',
        'ignore',
        'done'
      ];

    public $timestamps = true;

    public function scopeFindId($query, $source_id)
    {
        return $query->where('id', $source_id);
    }
}
