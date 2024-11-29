<?php

namespace App\Controllers;

use App\Helpers\Redirect;
use App\Models\LeaveRequests;
use App\Models\Users;
use App\Services\PaginationService;

class RequestController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $leave_requests = LeaveRequests::where('user_id', $_SESSION['user']->id)->orderBy('updated_at', 'desc');

        $pagination = PaginationService::paginate($leave_requests, $perPage, $page);

        return $this->render('pages.client.request.request', [
            'data' => $pagination['data'], // Lấy dữ liệu từ mảng
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }

    public function create()
    {
        return $this->render('pages.client.request.create_request');
    }

    public function store()
    {
        $data = $_POST;
        $data['user_id'] = $_SESSION['user']->id;
        $data['status'] = 'pending';

        LeaveRequests::create($data);

        Redirect::to('/user/leave-request')
                ->message('Đã tạo yêu cầu nghỉ phép thành công')
                ->send();
    }

    public function show($id)
    {
        $leave_request = LeaveRequests::find($id);

        return $this->render('pages.client.request.showOrUpdate_request', [
            'leave_request' => $leave_request,
        ]);
    }

    public function delete($id)
    {
        $leave_request = LeaveRequests::find($id);

        if($leave_request->status !== 'pending') {
            Redirect::to('/user/leave-request')
                ->message('Không thể xóa yêu cầu nghỉ phép đã được duyệt hoặc từ chối')
                ->send();
        }

        $leave_request->delete();

        Redirect::to('/user/leave-request')
                ->message('Đã xóa yêu cầu nghỉ phép thành công')
                ->send();
    }

    public function update()
    {
        $data = $_POST;

        $leave_request = LeaveRequests::find($data['id']);

        if($leave_request->status !== 'pending') {
            Redirect::to('/user/leave-request')
                ->message('Không thể cập nhật yêu cầu nghỉ phép đã được duyệt hoặc từ chối')
                ->send();
        }

        $leave_request->update($data);

        Redirect::to('/user/leave-request')
                ->message('Đã cập nhật yêu cầu nghỉ phép thành công')
                ->send();
    }

}
