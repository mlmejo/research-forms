<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'announcements' => Announcement::all(),
        ]);
    }
}
