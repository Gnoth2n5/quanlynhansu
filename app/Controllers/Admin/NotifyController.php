<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;
use App\Models\Notifications;
use App\Services\PaginationService;

class NotifyController extends Controller
{
    public function index()
    {   
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $data = Notifications::query()->orderBy('updated_at', 'desc');

        $pagination = PaginationService::paginate($data, $perPage, $page);
        
        $this->render('pages.admin.notification.notify',[
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],    
        ]);
    }
}