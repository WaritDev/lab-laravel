<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('dinner-poll', function ($user) {
//     return $user->isAdmin();
// });

Broadcast::channel('genre.{genre_id}', function (User $user, $genre_id) {
    return $user->isAdmin();
}, ['guards' => ['sanctum']]);