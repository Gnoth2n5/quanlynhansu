<?php

namespace App\Controllers\Admin;

use App\Models\Offices;
use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\Roles;
use App\Models\Users;
use App\Services\PaginationService;

use function PHPSTORM_META\map;

class OfficeController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        // $offices = Offices::with(['users' => function ($query) {
        //     $query->whereHas('role', function ($roleQuery) {
        //         $roleQuery->where('name', 'manager');
        //     })->limit(1);
        // }])->orderBy('updated_at', 'desc')->get();

        $offices = Offices::with('manager')->orderBy('updated_at', 'desc');

        // foreach ($offices as $office) {
        //     echo "Phòng ban: " . $office->name . "<br>";
        //     echo "Vị trí: " . $office->location . "<br>";

        //     foreach ($office->users as $user) {
        //         echo "Trưởng phòng: " . $user->full_name . "<br>";
        //     }
        // }
        // die();

        // cần thêm get nhưng khi truyen vao paginate thi no se tu them get

        $pagination = PaginationService::paginate($offices, $perPage, $page);

        return $this->render('pages.admin.office.office', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }

    public function delete($id)
    {
        $office = Offices::find($id);

        if (!$office) {
            Redirect::to('/admin/office-management')
                ->message('Phòng ban không tồn tại', 'error')
                ->send();
        }

        $office->delete();

        Redirect::to('/admin/office-management')
            ->message('Xóa phòng ban thành công', 'success')
            ->send();
    }
    public function create()
    {
        $this->render('pages.admin.office.create_office');
    }

    public function edit($id)
    {
        $office = Offices::with('manager', 'users')->find($id);

        if (!$office) {
            Redirect::to('/admin/office-management')
                ->message('Lỗi không tìm thấy phòng ban', 'error')
                ->send();
        }

        $this->render('pages.admin.office.edit_office', [
            'office' => $office,
            'manager' => $office->manager->first(),
            'employees' => $office->users,
        ]);
    }


    public function store()
    {
        $name = $_POST['roomName'];
        $location = $_POST['location'];

        if (empty($name) || empty($location)) {
            Redirect::to('/admin/create-office')
                ->message('Vui lòng nhập đầy đủ thông tin', 'error')
                ->send();
        }

        $office = Offices::where('name', $name)->first();

        if ($office) {
            Redirect::to('/admin/create-office')
                ->message('Phòng ban đã tồn tại', 'error')
                ->send();
        }

        $result = Offices::create([
            'name' => $name,
            'location' => $location,
        ]);

        if (!$result) {
            Redirect::to('/admin/create-office')
                ->message('Lỗi khi thêm phòng ban', 'error')
                ->send();
        }

        Redirect::to('/admin/office-management')
            ->message('Thêm phòng ban thành công', 'success')
            ->send();
    }


    public function update()
    {
        // Lấy dữ liệu từ POST và kiểm tra
        $id = $_POST['id'];
        $name = $_POST['roomName'];
        $location = $_POST['location'];
        $managerId = $_POST['managerId'];

        // \dd($_POST);

        if (!$id || empty($name) || empty($location)) {
            return Redirect::to('/admin/edit-office/' . $id)
                ->message('Vui lòng nhập đầy đủ thông tin', 'error')
                ->send();
        }

        // Tìm phòng ban kèm thông tin trưởng phòng
        $office = Offices::with('manager')->find($id);
        if (!$office) {
            return Redirect::to('/admin/office-management')
                ->message('Lỗi không tìm thấy phòng ban', 'error')
                ->send();
        }

        // Tìm nhân viên trưởng phòng mới
        $newManager = Users::find($managerId);
        if (!$newManager) {
            return Redirect::to('/admin/edit-office/' . $id)
                ->message('Nhân viên không tồn tại', 'error')
                ->send();
        }


        
        $oldManager = optional($office->manager)->first();
        $managerRole = Roles::where('name', 'manager')->first();
        $employeeRole = Roles::where('name', 'user')->first();

        if ($oldManager && $oldManager->id !== $managerId) {
            $oldManager->role_id = $employeeRole->id;
            $oldManager->save();
        }

        if (!$oldManager || $oldManager->id !== $managerId) {
            $newManager->role_id = $managerRole->id;
            $newManager->save();
        }

        // Cập nhật dữ liệu
        $office->name = $name;
        $office->location = $location;

        $office->save();

        // Chuyển hướng thành công
        return Redirect::to('/admin/office-management')
            ->message('Cập nhật phòng ban thành công', 'success')
            ->send();
    }
}
