<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\LeaveRequests;
use App\Helpers\Redirect;
use App\Services\PaginationService;

class LeaveController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $leave_requests = LeaveRequests::with('users')->orderBy('updated_at', 'desc');

        $pagination = PaginationService::paginate($leave_requests, $perPage, $page);

        $this->render('pages.admin.leave.leave', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }

    public function show($id)
    {
        $leave_request = LeaveRequests::find($id);
        $this->render('pages.admin.leave.show', [
            'leave_request' => $leave_request,
        ]);
    }

    public function confirm($type, $id)
    {
        $leave_request = LeaveRequests::find($id);

        if ($leave_request->status !== 'pending') {
            Redirect::to('/admin/leave-management')
                ->message('Không thể xác nhận yêu cầu nghỉ phép đã được duyệt hoặc từ chối')
                ->send();
        }

        $leave_request->update([
            'status' => $type,
            'approved_by' => $_SESSION['user']->id,
        ]);

        Redirect::to('/admin/leave-management')
            ->message('Đã xác nhận yêu cầu nghỉ phép thành công')
            ->send();
    }
}
