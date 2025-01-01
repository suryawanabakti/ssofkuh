<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function visibleApplication()
    {
        return $this->hasMany(VisibleApplicationUser::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function needTrustedHost()
    {
        return $this->hasMany(NeedTrustedHost::class);
    }
}
