<?php

if (!function_exists('customLinks')) {
    function customLinks($params) {
        $currentPage = $params['currentPage'];
        $lastPage = $params['lastPage'];
        $path = $params['path'];

        $links = [];
        $startPage = max(1, $currentPage - 2);
        $endPage = min($lastPage, $currentPage + 2);
    
        $links[] = [
            // 'url' => $currentPage > 1 ? route('vlogs.index', ['page' => $currentPage - 1]) : null,
            'url' => $currentPage > 1 ? url($path.'?page='.$currentPage - 1) : null,
            'label' => 'Trang trước',
            'active' => false,
        ];
    
        for ($page = $startPage; $page <= $endPage; $page++) {
            $links[] = [
                // 'url' => route('vlogs.index', ['page' => $page]),
                'url' => url($path.'?page='.$page),
                'label' => $page,
                'active' => $page == $currentPage,
            ];
        }
    
        $links[] = [
            // 'url' => $currentPage < $lastPage ? route('vlogs.index', ['page' => $currentPage + 1]) : null,
            'url' => $currentPage < $lastPage ? url($path.'?page='.$currentPage + 1) : null,
            'label' => 'Trang sau',
            'active' => false,
        ];
    
        return $links;
    }
}