<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'name', 'rate', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
