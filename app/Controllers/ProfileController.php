<?php

namespace App\Controllers;

use App\Helpers\Redirect;

class ProfileController extends Controller
{
    public function profile()
    {
        return $this->render('pages.client.profile');
    }

    public function updateProfile()
    {
        
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $avatar = $_FILES['avatar'];
        $username = $_POST('username');
        $oldpassword = $_POST['oldpassword'];
        $newPassword = $_POST['newpassword'];

        $errors = [];

        if (empty($fullname)) {
            $errors['fullname'] = "Họ và tên không được để trống.";
        } elseif (strlen($fullname) < 3 || strlen($fullname) > 100) {
            $errors['fullname'] = "Họ và tên phải từ 3 đến 100 ký tự.";
        }

        if (empty($email)) {
            $errors['email'] = "Email không được để trống.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ.";
        }

        if (!empty($address) && strlen($address) > 255) {
            $errors['address'] = "Địa chỉ không được vượt quá 255 ký tự.";
        }

        if ($avatar && $avatar['error'] === 0) {
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            $fileType = pathinfo($avatar['name'], PATHINFO_EXTENSION);
    
            if (!in_array(strtolower($fileType), $allowedTypes)) {
                $errors['avatar'] = "Chỉ chấp nhận file ảnh (JPG, JPEG, PNG).";
            } elseif ($avatar['size'] > 2 * 1024 * 1024) { 
                $errors['avatar'] = "Ảnh đại diện không được vượt quá 2MB.";
            }
        }

        if (empty($username)) {
            $errors['username'] = "Tên người dùng không được để trống.";
        } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
            $errors['username'] = "Tên người dùng chỉ được chứa chữ cái, số, dấu gạch dưới, từ 3-20 ký tự.";
        }

        if (!empty($newPassword)) {
            if (strlen($newPassword) < 6) {
                $errors['newpassword'] = "Mật khẩu mới phải có ít nhất 6 ký tự.";
            } elseif (!password_verify($oldpassword, $_SESSION['user']->password)) {
                $errors['oldpassword'] = "Mật khẩu hiện tại không chính xác.";
            }
        }

        if (!empty($errors)) {
            Redirect::to('/user/profile')
                    ->message('Lỗi', 'error')
                    ->send();
        }

        // tạo thư mục nếu ko có
        $uploadDir = '/uploads/avatars/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
          
            $fileType = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        
            
            $newFileName = uniqid('avatar_', true) . '.' . $fileType;
        
            
            $uploadPath = $uploadDir . $newFileName;
        
           
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadPath)) {
                
                $avatarUrl = '/' . $uploadPath;
             
        
                
                $_SESSION['user']->avatar = $avatarUrl;
        
               
                
            }
        } else {
          
            Redirect::to('/user/profile')
                ->message('Vui lòng chọn một file ảnh!', 'error')
                ->send();
        }
        

        
        
        
        return $this->render('pages.client.profile');
    }
}