<?php

namespace App\Controllers;

use App\Models\Users;
use App\Models\Offices;
use App\Models\Salaries;
use App\Services\NotifyService;

class SearchController extends Controller
{
    protected $notifyService;

    public function __construct()
    {
        $this->notifyService = new NotifyService();
    }

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

    public function search_user_salary()
    {
        $salary = Salaries::with('users:id,full_name')->get();

        $jsonData = $salary->map(function ($item) {
            return $item->users ? [
                'id' => $item->users->id,
                'text' => $item->users->full_name,
            ] : null;
        })->filter();

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

    public function countUnreadNotify()
    {
        $userId = $_SESSION['user']->id;

        $count = $this->notifyService->countUnreadNotifications($userId);

        $this->json(['count' => $count]);
    }
}
