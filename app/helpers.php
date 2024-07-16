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

if (!function_exists('dateFormatter')) {
    function dateFormatter($timestamp) {
        // nên làm format '2 giờ trước', '2 tháng trước' hoặc cứ trả như này, rồi bên frontend sẽ đảm nhiệm phần đổi ra giờ trc, tháng trc khi bấm full description
        $date = new DateTime($timestamp);
        $formattedDate = $date->format('d/m/y H:i'); // y hiện 24, Y hiện 2024
    
        return $formattedDate;
    }
}