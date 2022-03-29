<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;
    use Searchable;

    //@TODO
    // name => summary
    // "key": "TSV4-5108",
    protected $fillable = ['key', 'summary', 'url'];

    protected $searchableFields = ['*'];

    public function releases()
    {
        return $this->belongsToMany(Release::class);
    }
}
