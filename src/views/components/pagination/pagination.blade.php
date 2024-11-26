<nav aria-label="Pagination">
    <ul class="pagination justify-content-center">
        <!-- Nút Previous -->
        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $currentPage > 1 ? '?page=' . ($currentPage - 1) : '#' }}"
                tabindex="-1">Previous</a>
        </li>

        <!-- Nút số trang -->
        @for ($i = 1; $i <= $totalPages; $i++)
            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
            </li>
        @endfor

        <!-- Nút Next -->
        <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $currentPage < $totalPages ? '?page=' . ($currentPage + 1) : '#' }}">Next</a>
        </li>
    </ul>
</nav>
