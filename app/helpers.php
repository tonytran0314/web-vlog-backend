<?php

if (!function_exists('customLinks')) {
    function customLinks($params) {
        $currentPage = $params['currentPage'];
        $lastPage = $params['lastPage'];

        $links = [];
        $startPage = max(1, $currentPage - 2);
        $endPage = min($lastPage, $currentPage + 2);
    
        $links[] = [
            'page' => $currentPage > 1 ? $currentPage - 1 : null,
            'label' => 'Trang trước',
            'active' => false,
        ];
    
        for ($page = $startPage; $page <= $endPage; $page++) {
            $links[] = [
                'page' => $page,
                'label' => $page,
                'active' => $page == $currentPage,
            ];
        }
    
        $links[] = [
            'page' => $currentPage < $lastPage ? $currentPage + 1 : null,
            'label' => 'Trang sau',
            'active' => false,
        ];
    
        return $links;
    }
}