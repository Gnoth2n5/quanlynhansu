<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\Notifications;
use App\Models\OfficeNotify;
use App\Services\PaginationService;
use App\Models\Users;

class NotifyController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;


        if ($_SESSION['role'] == 'admin') {
            $data = Notifications::withCount(['users', 'offices'])->orderBy('updated_at', 'desc');
            $pagination = PaginationService::paginate($data, $perPage, $page);
        } else {

            // lấy người dùng
            $user = Users::with(['notifications', 'offices.notifications'])->find($_SESSION['user']->id);

            // Thông báo cá nhân
            $personalNotifications = $user->notifications->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'content' => $notification->message,
                    'created_at' => $notification->created_at,
                    'type' => 'System',
                    'office_name' => null,
                ];
            })->toArray(); // Chuyển thành mảng

            // Thông báo theo phòng ban
            $officeNotifications = $user->offices->flatMap(function ($office) {
                return $office->notifications->map(function ($notification) use ($office) {
                    return [
                        'id' => $notification->id,
                        'title' => $notification->title,
                        'content' => $notification->message,
                        'created_at' => $notification->created_at,
                        'type' => 'Office',
                        'office_name' => $office->name,
                    ];
                });
            })->toArray(); // Chuyển thành mảng

            // Gộp thông báo và sắp xếp theo thời gian
            $data = array_merge($personalNotifications, $officeNotifications); // Sử dụng array_merge
            usort($data, function ($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']); // Sắp xếp theo thời gian
            });

            // Phân trang thủ công
            $totalRecords = count($data); // Tổng số bản ghi
            $totalPages = ceil($totalRecords / $perPage); // Tổng số trang
            $page = max($page, 1); // Đảm bảo page không nhỏ hơn 1
            $page = min($page, $totalPages); // Đảm bảo page không vượt quá tổng số trang

            // Tính offset để lấy dữ liệu cho trang hiện tại
            $offset = ($page - 1) * $perPage;

            // Lấy dữ liệu cho trang hiện tại
            $paginatedData = array_slice($data, $offset, $perPage);

            // Tạo pagination
            $pagination = [
                'data' => $paginatedData,
                'totalPages' => $totalPages,
                'currentPage' => $page,
                'totalRecords' => $totalRecords,
            ];
        }





        // \print_r($pagination['data']);
        // die();

        if ($_SESSION['role'] == 'admin') {
            $this->render('pages.admin.notification.notify', [
                'data' => $pagination['data'],
                'totalPages' => $pagination['totalPages'],
                'currentPage' => $pagination['currentPage'],
            ]);
        } else {
            $this->render('pages.client.notify_user', [
                'data' => $pagination['data'],
                'totalPages' => $pagination['totalPages'],
                'currentPage' => $pagination['currentPage'],
            ]);
        }
    }

    public function create()
    {
        $this->render('pages.admin.notification.create');
    }

    public function store()
    {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $toOffice = $_POST['office'];


        $notify = new Notifications();
        $notify->title = $title;
        $notify->message = $content;
        $notify->save();

        foreach ($toOffice as $office) {
            $officeNotify = new OfficeNotify();
            $officeNotify->office_id = $office;
            $officeNotify->notify_id = $notify->id;
            $officeNotify->save();
        }

        Redirect::to('/admin/notify-management')
            ->message('Tạo thông báo thành công', 'success')
            ->send();
    }

    public function delete($id)
    {
        $notify = Notifications::find($id);
        $notify->delete();

        Redirect::to('/admin/notify-management')
            ->message('Xóa thông báo thành công', 'success')
            ->send();
    }

    public function show($id)
    {
        if ($_SESSION['role'] == 'admin') {
            $notify = Notifications::with(['users', 'offices'])->find($id);

            if (!$notify) {
                Redirect::to('/admin/notify-management')
                    ->message('Thông báo không tồn tại', 'error')
                    ->send();
            }

            $this->render('pages.admin.notification.edit', [
                'notify' => $notify
            ]);
        } else {
            $notify = Notifications::find($id);
            $this->render('pages.client.show_notify', [
                'notify' => $notify
            ]);
        }
    }

    public function update()
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        $toOffice = $_POST['office'];

        $notify = Notifications::find($id);
        $notify->title = $title;
        $notify->message = $content;
        $notify->save();

        OfficeNotify::where('notify_id', $id)->delete();

        foreach ($toOffice as $office) {
            $officeNotify = new OfficeNotify();
            $officeNotify->office_id = $office;
            $officeNotify->notify_id = $notify->id;
            $officeNotify->save();
        }

        Redirect::to('/admin/notify-management')
            ->message('Cập nhật thông báo thành công', 'success')
            ->send();
    }
}
