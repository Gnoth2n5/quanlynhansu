<?php

namespace App\Controllers;

use App\Models\Users;
use App\Models\Offices;

class SearchController extends Controller
{
    public function search_user_manager()
    {
        $users = Users::whereHas('role', function ($q) {
            $q->where('name', '!=', 'admin');
        })->select('id', 'full_name')->get();

        $jsonData = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'text' => $user->full_name
            ];
        });

        // \dd($jsonData);

        $this->json($jsonData);
        // \dd($users);
    }

    public function search_office()
    {
        $offices = Offices::select('id', 'name')->get();

        $jsonData = $offices->map(function ($office) {
            return [
                'id' => $office->id,
                'text' => $office->name
            ];
        });

        // \dd($jsonData);

        $this->json($jsonData);
        // \dd($users);
    }
}
