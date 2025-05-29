<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'test_type', 'answers', 'score'];

    protected $casts = [
        'answers' => 'array',
    ];
}
