<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Release extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'document',
        'released_at',
        'project_id',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'released_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function issues()
    {
        return $this->belongsToMany(Issue::class);
    }
}
