<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Helpers\Redirect;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {

        $settingIps = Setting::where('setting_key', 'ip_range_company')->pluck('setting_value')->first();

        $ot = Setting::where('setting_key', 'ot')->pluck('setting_value')->first();


        $this->render('pages.admin.setting', [
            'settingIps' => $settingIps,
            'ot' => $ot
        ]);
    }


    public function update()
    {
        $newOt = \post('ot');
        $newSettingIps = \post('ip');

        if(empty($newOt) || empty($newSettingIps)){
            Redirect::to('/admin/system-setting')
                ->message('Vui lòng nhập đầy đủ thông tin', 'danger')
                ->send();
        }

        $settingIps = Setting::where('setting_key', 'ip_range_company')->first();
        $ot = Setting::where('setting_key', 'ot')->first();

        $settingIps->setting_value = $newSettingIps;
        $ot->setting_value = $newOt;

        $settingIps->save();
        $ot->save();

        Redirect::to('/admin/system-setting')
            ->message('Cập nhật thành công', 'success')
            ->send();
    }
}
