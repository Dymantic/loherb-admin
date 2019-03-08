<?php

namespace App\Http\Controllers;

use Dymantic\InstagramFeed\Exceptions\BadTokenException;
use Dymantic\InstagramFeed\Instagram;
use Dymantic\InstagramFeed\Profile;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function show()
    {

        return view('dashboard');
    }
}
