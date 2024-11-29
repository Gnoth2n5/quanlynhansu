<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\OfficeUsers;
use App\Models\Users;
use App\Services\PaginationService;
use App\Models\Roles;
use Illuminate\Database\Capsule\Manager as DB;


class UserController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $data = Users::whereHas('role', function ($q) {
            $q->where('name', '!=', 'admin');
        })
            ->with('role', 'offices')
            ->orderBy('updated_at', 'desc');

        $pagination = PaginationService::paginate($data, $perPage, $page);

        $this->render('pages.admin.user.user', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }

    public function show($uid, $id)
    {

        $user = Users::with('offices')
            ->find($id);

        if (!$user || $user->UID != $uid) {

            Redirect::to('/admin/user-management')
                ->message('Người dùng không tồn tại')
                ->send();
        }

        $roles = Roles::all();

        $this->render('pages.admin.user.user_detail', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function block($uid, $id)
    {
        $user = Users::find($id);

        if (!$user || $user->UID != $uid) {

            Redirect::to('/admin/user-management')
                ->message('Người dùng không tồn tại')
                ->send();
        }

        $user->status = 'inactive';
        $user->save();

        Redirect::to('/admin/user-management')
            ->message('Khoá tài khoản thành công')
            ->send();
    }

    public function unlock($uid, $id)
    {
        $user = Users::find($id);

        if (!$user || $user->UID != $uid) {

            Redirect::to('/admin/user-management')
                ->message('Người dùng không tồn tại')
                ->send();
        }

        $user->status = 'active';
        $user->save();

        Redirect::to('/admin/user-management')
            ->message('Mở khoá tài khoản thành công')
            ->send();
    }

    public function update()
    {
        $id = $_POST['id'];

        $fullname = $_POST['fullname'];
        $email = $_POST['email'];

        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $avatar = $_FILES['avatar'];

        $username = $_POST['username'];

        $status = $_POST['status'];
        $roleId = $_POST['role'];
        $officeId = $_POST['office'];

        DB::beginTransaction();

        $user = Users::find($id);

        if (!$user) {
            Redirect::to('/admin/user-management')
                ->message('Người dùng không tồn tại')
                ->send();
        }

        $result = $this->upload('avatar');

        if ($result || str_starts_with($result, 'image_')) {
            try {
                $user->update([
                    'fullname' => $fullname,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'avatar' => $result,
                    'username' => $username,
                    'status' => $status,
                    'role_id' => $roleId,
                ]);

                if (!($officeId == 0 || $officeId == null)) {
                    OfficeUsers::updateOrCreate(
                        ['user_id' => $id],
                        ['office_id' => $officeId]
                    );
                }

                DB::commit();

                Redirect::to('/admin/user-management')
                    ->message('Cập nhật thông tin người dùng thành công')
                    ->send();
            } catch (\Exception $e) {
                DB::rollBack();
                Redirect::to('/admin/user-management')
                    ->message('Có lỗi xảy ra, vui lòng thử lại sau')
                    ->send();
            }
        } else {
            Redirect::to('/admin/user-management')
                ->message($result)
                ->send();
        }
    }
}
