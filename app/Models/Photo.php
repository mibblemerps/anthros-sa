<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function canUserModify($user): bool
    {
        if ($user === null) return false;
        return $user->is_admin || $user->id === $this->user_id;
    }
}
