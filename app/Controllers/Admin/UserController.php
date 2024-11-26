<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\Users;
use App\Services\PaginationService;

class UserController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $pagination = PaginationService::paginate(Users::query()->orderBy('updated_at', 'desc'), $perPage, $page);

        $this->render('pages.admin.user.user', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }

    public function show($uid, $id){
        $user = Users::find($id);

        if(!$user || $user->UID != $uid){

            Redirect::to('/admin/user-management')
                    ->message('Người dùng không tồn tại')
                    ->send();
        }
        
        $this->render('pages.admin.user.user_detail', [
            'user' => $user
        ]);        
    }
}