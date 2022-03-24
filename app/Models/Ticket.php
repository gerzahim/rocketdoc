<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['reference', 'name', 'url'];

    protected $searchableFields = ['*'];

    public function releases()
    {
        return $this->belongsToMany(Release::class);
    }
}
