<?php
namespace App\Controllers\Admin;

use App\Models\Offices;
use App\Controllers\Controller;
use App\Services\PaginationService;

class OfficeController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $pagination = PaginationService::paginate(Offices::query(), $perPage, $page);

        return $this->render('pages.admin.office.office', [
            'data' => $pagination['data'],
            'totalPages' => $pagination['totalPages'],
            'currentPage' => $pagination['currentPage'],
        ]);
    }
}