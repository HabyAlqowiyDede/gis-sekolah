<?php

if (!function_exists('isSuperAdmin')) {
    function isSuperAdmin()
    {
        return session()->get('role') === 'super_admin';
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return session()->get('role') === 'admin';
    }
}

if (!function_exists('isAdminSekolah')) {
    function isAdminSekolah()
    {
        return session()->get('role') === 'admin' && session()->get('id_sekolah') !== null;
    }
}

if (!function_exists('getCurrentUserSchoolId')) {
    function getCurrentUserSchoolId()
    {
        return session()->get('id_sekolah');
    }
}