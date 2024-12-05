<?php

namespace App\Controllers;

use App\Helpers\Redirect;
use App\Models\OT;
use App\Models\Users;
use App\Services\PaginationService;
use Carbon\Carbon;

class OTController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $role = $_SESSION['role'];

        // \dd($role);  

        if ($role == 'user' || $role == 'manager') {
            $ot_request = OT::with('shift')->where('user_id', $_SESSION['user']->id)->orderBy('updated_at', 'desc');
        } elseif ($role == 'admin') {
            $ot_request = OT::with('user.offices')->orderBy('updated_at', 'desc');
        }

        $pagination = PaginationService::paginate($ot_request, $perPage, $page);

        if ($role == 'user' || $role == 'manager') {
            $this->render('pages.client.ot.ot', [
                'data' => $pagination['data'],
                'totalPages' => $pagination['totalPages'],
                'currentPage' => $pagination['currentPage'],
            ]);
        }
        if ($role == 'admin') {
            $this->render('pages.admin.ot.ot', [
                'data' => $pagination['data'],
                'totalPages' => $pagination['totalPages'],
                'currentPage' => $pagination['currentPage'],
            ]);
        }
    }

    public function create()
    {
        $check = OT::where('user_id', $_SESSION['user']->id)->whereDate('created_at', Carbon::today())->first();

        if ($check) {
            Redirect::to('/user/dashboard')
                ->message('Bạn đã gửi đơn OT hôm nay rồi, vui lòng thử lại sau', 'error')
                ->send();
        }

        $this->render('pages.client.ot.create');
    }

    public function store()
    {

        $requested_hours = $_POST['ot_time'];
        $user_id = $_SESSION['user']->id;
        $user = Users::with('shift')->find($user_id);
        if ($user && $user->shift->isNotEmpty()) {
            $shift_id = $user->shift->first()->id;
        } else {
            $shift_id = null;
        }

        $result = OT::create([
            'requested_hours' => $requested_hours,
            'user_id' => $user_id,
            'shift_id' => $shift_id,
        ]);

        if ($result) {
            Redirect::to('/user/ot-request')
                ->message('Đơn OT đã được tạo thành công', 'success')
                ->send();
        } else {
            Redirect::to('/user/ot-request')
                ->message('Có lỗi xảy ra, vui lòng thử lại', 'error')
                ->send();
        }
    }

    public function delete($id)
    {
        $ot = OT::find($id);
        if ($ot) {
            $ot->delete();
            Redirect::to('/user/ot-request')
                ->message('Đơn OT đã được hủy', 'success')
                ->send();
        } else {
            Redirect::to('/user/ot-request')
                ->message('Có lỗi xảy ra, vui lòng thử lại', 'error')
                ->send();
        }
    }

    public function show($id)
    {
        $ot = OT::find($id);
        $this->render('pages.client.ot.show', [
            'request' => $ot,
        ]);
    }

    public function update()
    {
        $id = $_POST['id'];
        $requested_hours = $_POST['ot_time'];
        $ot = OT::find($id);
        if ($ot) {
            $ot->requested_hours = $requested_hours;
            $ot->save();
            Redirect::to('/user/ot-request')
                ->message('Đơn OT đã được cập nhật', 'success')
                ->send();
        } else {
            Redirect::to('/user/ot-request')
                ->message('Có lỗi xảy ra, vui lòng thử lại', 'error')
                ->send();
        }
    }

    public function confirm($type, $id)
    {
        $ot = OT::find($id);
        if ($ot) {
            if ($type == 'approved') {
                $ot->status = 'approved';
                $ot->save();
                Redirect::to('/admin/ot-management')
                    ->message('Đơn OT đã được chấp nhận', 'success')
                    ->send();
            } elseif ($type == 'rejected') {
                $ot->status = 'rejected';
                $ot->save();
                Redirect::to('/admin/ot-management')
                    ->message('Đơn OT đã bị từ chối', 'success')
                    ->send();
            }
        } else {
            Redirect::to('/admin/ot-management')
                ->message('Có lỗi xảy ra, vui lòng thử lại', 'error')
                ->send();
        }
    }
}
