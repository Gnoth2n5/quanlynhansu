<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller;
use App\Models\Users;
use App\Helpers\Redirect;
use App\Models\Shifts;
use App\Models\UserShift;

class AuthController extends Controller
{
    public function loginView()
    {
        return $this->render('pages.authentication.signin');
    }

    public function registerView()
    {
        return $this->render('pages.authentication.signup');
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $user = Users::where('email', $email)->first();

        if ($user && password_verify($password, $user->password)) {
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user->role->name;
            
            if($user->role->name == 'admin') {
                Redirect::to('/admin/dashboard')
                    ->message('Đăng nhập thành công!', 'success')
                    ->send();
            }
            if($user->role->name == 'user' || $user->role->name == 'manager') {
                Redirect::to('/user/dashboard')
                    ->message('Đăng nhập thành công!', 'success')
                    ->send();
            }

            if($user->status == 'inactive') {
                Redirect::to('/')
                    ->message('Tài khoản của bạn đã bị khóa!', 'warning')
                    ->send();
            }
            
        }

        Redirect::to('/')
            ->message('Tài khoản hoặc mật khẩu không chính xác!', 'error')
            ->send();
    }

    public function register()
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $fullname = $_POST['full_name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];

        // \dd($data);

        if(!$username || !$email || !$password || !$fullname || !$birthday || !$gender) {
            Redirect::to('/signup')
                ->message('Vui lòng nhập đầy đủ thông tin', 'danger')
                ->send();
        }

        $user = new Users();

        $user->username = $username;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_ARGON2ID);
        $user->role_id = 1;
        $user->full_name = $fullname;
        $user->birthday = $birthday;
        $user->gender = $gender;
        $user->UID = createUID($fullname, $birthday);
        $user->save();

        // lấy ca làm việc sáng làm mặc định
        $shift_morning = Shifts::where('shift_name', 'Sáng')->first();

        $userShift = UserShift::create([
            'user_id' => $user->id,
            'shift_id' => $shift_morning->id
        ]);

        if(!$userShift) {
            Redirect::to('/')
                ->message('Đăng kí thất bại! Không thể phân ca', 'danger')
                ->send();
        }
        

        Redirect::to('/')
            ->message('Đăng kí thành công', 'success')
            ->send();
    }

    public function logout()
    {
        session_destroy();
        Redirect::to('/')
            ->message('Đăng xuất thành công!', 'success')
            ->send();
    }
}