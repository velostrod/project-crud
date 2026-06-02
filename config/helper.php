<?php

// function : sebuah query yang bisa digunakan berulang
function getStatus(int $status): string
{
    return $status ? '<span class="badge bg-primary">Active</span>' :
        '<span class="badge bg-warning">Warning</span>';
}


// versi 2 (lebih panjang)

// function getLabel($status){
//     switch ($status) {
//         case '1';
//         return '<span class="badge bg-primary">Active</span>';
//         break;


//     default:
//         return '<span class="badge bg-warning">Warning</span>';
//         break;
//     }
// }

// function inputFailed($status)
// {
//     return "<span class='text-danger'>$status</span>";
// }
