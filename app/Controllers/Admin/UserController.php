<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;
use App\Models\Users;
use App\Services\PaginationService;

class UserController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $pagination = PaginationService::paginate(Users::query(), $perPage, $page);

        $this->render('pages.admin.user.user', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }
}