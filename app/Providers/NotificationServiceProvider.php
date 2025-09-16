<?php
// app/Providers/NotificationServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Mengirim data ke view tertentu setiap kali view tersebut dirender
        View::composer('layouts.app', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $unreadNotifications = $user->unreadNotifications()->take(5)->get();
                $view->with('unreadNotifications', $unreadNotifications);
            }
        });
    }
}