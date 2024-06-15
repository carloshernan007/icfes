<?php

namespace App\Helpers;

class AlertHelper
{
    public static function existNotification()
    {
        $message = '';
        foreach (['success','danger','warning'] as $row) {
            if (session()->has($row)) {
                $message = $row;
                break;
            }
        }
        return $message;
    }
}
