<?php

namespace App\Controllers;

use App\Helpers\Redirect;
use App\Models\Users;
use App\Models\OfficeUsers;
use Illuminate\Database\Capsule\Manager as DB;


class ProfileController extends Controller
{
    public function profile()
    {

        $user = Users::find($_SESSION['user']->id);


        return $this->render('pages.client.profile', [
            'user' => $user,
        ]);
    }

    public function update()
    {
        $id = $_SESSION['user']->id;

        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $avatar = $_FILES['avatar'];
        $username = $_POST['username'];
        $gender = $_POST['gender'];

        DB::beginTransaction();

        $user = Users::find($id);

        if (!$user) {
            Redirect::to('/admin/user-management')
                ->message('Người dùng không tồn tại')
                ->send();
        }

        $avatarPath = $user->avatar; // Giữ ảnh cũ làm mặc định
        if ($avatar && $avatar['error'] === UPLOAD_ERR_OK) {
            $result = $this->upload('avatar');

            if ($result && str_starts_with($result, 'image_')) {
                $avatarPath = $result; // Cập nhật ảnh mới
            } else {
                Redirect::to('/user/profile')
                    ->message($result)
                    ->send();
            }
        }

        try {
            $updateStatus = $user->update([
                'full_name' => $fullname,
                'email' => $email,
                'address' => $address,
                'phone' => $phone,
                'avatar' => $avatarPath, // Cập nhật ảnh (cũ hoặc mới)
                'username' => $username,
                'gender' => $gender,
            ]);

            if ($updateStatus) {
                DB::commit();

                $_SESSION['user'] = Users::find($id);

                Redirect::to('/user/profile')
                    ->message('Cập nhật thông tin người dùng thành công')
                    ->send();
            } else {
                DB::rollBack();
                Redirect::to('/user/profile')
                    ->message('Không có thay đổi nào được thực hiện')
                    ->send();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Redirect::to('/user/profile')
                ->message('Có lỗi xảy ra: ' . $e->getMessage())
                ->send();
        }
    }
}
