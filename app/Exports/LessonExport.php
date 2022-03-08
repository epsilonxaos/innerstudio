<?php

namespace App\Exports;

use App\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;

class LessonExport implements FromCollection
{
    public function collection()
    {
        return Reservation::join('_mat_per_class', 'reservation.id_mat_per_class', '=', '_mat_per_class.id_mat_per_class')
        -> join('customer', 'reservation.id_customer', '=', 'customer.id_customer')
        -> join('lesson','_mat_per_class.id_class', '=', 'lesson.id_lesson')
        -> join('mat', '_mat_per_class.id_mat', '=', 'mat.id_mat')
        -> select(
            'reservation.id_reservation',
            'lesson.id_lesson',
            'customer.name',
            'customer.lastname',
            'customer.email',
            'customer.phone',
            'mat.no_mat'
        )
        -> where('lesson.id_lesson',1)
        -> whereIn('reservation.status', [1,2])
        -> orderBy('customer.name', 'ASC')
        ->get();
    }
}