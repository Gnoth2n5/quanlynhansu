<?php

namespace App\Controllers;
use App\Models\Users;

class SearchController extends Controller
{
    public function search_user_manager()
    {
        $users = Users::select('id', 'full_name')->get();

        $jsonData = $users->map(function($user){
            return [
                'id' => $user->id,
                'text' => $user->full_name
            ];
        });

        // \dd($jsonData);

        $this->json($jsonData);
        // \dd($users);
    }
}