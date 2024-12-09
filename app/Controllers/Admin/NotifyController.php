<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\Notifications;
use App\Models\OfficeNotify;
use App\Services\PaginationService;
use App\Models\Users;
use App\Services\NotifyService;

class NotifyController extends Controller
{
    protected $notifyService;

    public function __construct()
    {
        $this->notifyService = new NotifyService();
    }

    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($_SESSION['role'] == 'admin') {
            $data = Notifications::withCount(['users', 'offices'])->orderBy('updated_at', 'desc');
            $pagination = PaginationService::paginate($data, $perPage, $page);

            $this->render('pages.admin.notification.notify', [
                'data' => $pagination['data'],
                'totalPages' => $pagination['totalPages'],
                'currentPage' => $pagination['currentPage'],
            ]);
        } else {
            $pagination = $this->notifyService->getUserNotifications($_SESSION['user']->id, $perPage, $page);

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
        // Kiểm tra quyền truy cập
        if ($_SESSION['role'] == 'admin') {
            $notify = Notifications::with(['users', 'offices'])->find($id);
        } else {
            $notify = Notifications::find($id);
        }

        // Nếu thông báo không tồn tại
        if (!$notify) {
            Redirect::to('/admin/notify-management')
                ->message('Thông báo không tồn tại', 'error')
                ->send();
        }

        // Xử lý trạng thái "đã đọc" cho user không phải admin
        if ($_SESSION['role'] !== 'admin') {
            if (!isset($this->notifyService)) {
                throw new \Exception("NotifyService chưa được khởi tạo");
            }
            $this->notifyService->isRead($_SESSION['user']->id, $id);
            $this->render('pages.client.show_notify', [
                'notify' => $notify
            ]);
        } else {
            // Hiển thị giao diện admin
            $this->render('pages.admin.notification.edit', [
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
