<?php

namespace App\Helpers;

class LabelsHelper
{
    public static function roleLabel($id)
    {
        try {
            $roles = [
                \App\Models\User::ADMIN => 'Administrador',
                \App\Models\User::MANAGER => 'Director',
                \App\Models\User::STUDENT => 'Estudiante',
                \App\Models\User::TEACHER => 'Docente',
            ];
            return $roles[$id];
        }catch (\Exception $exception){
            return '';
        }
    }

    public static function getIconNotification($id):string
    {
        try {
            $rows =  [
                'success' => 'success',
                'danger' => 'error',
                'warning' => 'warning',
                'info' => 'info',
            ];
            return $rows[$id];
        }catch (\Exception $exception){
            return '';
        }
    }

    public static function getGetLevelColor($level)
    {
        $data  = [
            1 => '#28a745',
            2 => '#17a2b8',
            3 => '#007bff',
            4 => '#dc3545',
            5 => '#28a745',
            6 => '#dc3545',
            7 => '#28a745',
            8 => '#dc3545',
            9 => '#28a745',
            10 => '#dc3545',
        ];
        return $data[$level];
    }
}
