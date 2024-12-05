<?php

namespace App\Services;

class PaginationService
{
    public static function paginate($query, $perPage, $page)
    {
        // if (!$query) {
        //     return [
        //         'data' => [],
        //         'totalPages' => 0,
        //         'currentPage' => 1,
        //         'totalRecords' => 0,
        //     ];
        // }

        $page = max($page, 1); 
        $totalRecords = $query->count();
        $totalPages = ceil($totalRecords / $perPage);

        $page = min($page, $totalPages);

        $offset = ($page - 1) * $perPage;

        $data = $query->skip($offset)->take($perPage)->get();
        // $data = $query->forPage($page, $perPage)->get();

        return [
            'data' => $data,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'totalRecords' => $totalRecords, 
        ];
    }
}