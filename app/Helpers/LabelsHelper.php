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
}
