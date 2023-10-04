<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    use HasFactory;

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
