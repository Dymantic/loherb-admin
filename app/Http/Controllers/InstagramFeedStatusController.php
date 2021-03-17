<?php

namespace App\Http\Controllers;

use Dymantic\InstagramFeed\Exceptions\BadTokenException;
use Dymantic\InstagramFeed\Instagram;
use Dymantic\InstagramFeed\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InstagramFeedStatusController extends Controller
{
    public function show()
    {
        $profile = Profile::first();
        $checked = true;
        $has_access = true;
        $media = [];

        if(!$profile->latestToken()) {
            return [
                'checked' => true,
                'has_access' => false,
                'auth_url' => $profile->getInstagramAuthUrl(),
                'media' => [],
            ];
        }

        try {
            $media = app()->make(Instagram::class)->fetchMedia($profile->latestToken());
        } catch(BadTokenException $badTokenException) {
            $has_access = false;
        } catch(\Exception $e) {
            Log::critical($e->getMessage());
            $checked = false;
        }

        return [
            'checked' => $checked,
            'has_access' => $has_access,
            'auth_url' => $profile->getInstagramAuthUrl(),
            'media' => $media,
        ];
    }
}
