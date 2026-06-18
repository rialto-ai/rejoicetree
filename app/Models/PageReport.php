<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageReport extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function page()
    {
        return $this->belongsTo(User::class, 'page_id');
    }

    public function link()
    {
        return $this->belongsTo(Link::class, 'link_id');
    }
}
