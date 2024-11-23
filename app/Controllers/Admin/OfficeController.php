<?php

namespace App\Controllers\Admin;
use App\Models\Offices;
use App\Controllers\Controller;

class OfficeController extends Controller
{
    public function index()
    {
       $offices=Offices::all ();
       $data= $offices->map(function($offices){
        return[
            'id'=>$offices->id,
            'name'=>$offices->name,
            'location'=>$offices->location,

        ];
       });
        $this->render('pages.admin.office.office',compact('data'));
    }
}