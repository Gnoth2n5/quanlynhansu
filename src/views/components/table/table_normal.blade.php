<?php

/* @var array $columns */
/* @var array $data */
?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                @foreach ($columns as $column => $label)
                    <!-- Sử dụng key-value, với key là tên cột -->
                    <th>{{ $label }}</th> <!-- value là tên cột -->
                @endforeach
                <th>Actions</th> <!-- Cột hành động -->
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($columns as $column => $label)
                        <td>{{ $row[$column] ?? '' }}</td> <!-- key dùng để lấy giá trị từ row -->
                    @endforeach
                    <td>
                        <!-- Các nút hành động -->
                        <button class="btn btn-primary">Edit</button>
                        <button class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
