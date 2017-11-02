<?php

function checkPermission($permissions) {
    if (Auth::check()) {
        $userAccess = auth()->user()->role;

        foreach ($permissions as $key => $value) {

            if ($value == $userAccess) {

                return true;
            }
        }

        return false;
    }
}

?>
