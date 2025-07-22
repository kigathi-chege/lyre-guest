<?php

namespace Lyre\Guest\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Lyre\Model;

class Guest extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo($this->userModel());
    }

    /**
     * Get the user model class.
     *
     * @return string
     */
    protected function userModel()
    {
        return config('lyre.user.model', \App\Models\User::class);
    }
}
