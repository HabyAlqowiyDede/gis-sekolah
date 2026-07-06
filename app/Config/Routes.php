<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('beranda', 'Home::beranda');
$routes->get('datasekolah', 'Home::datasekolah');
$routes->get('pemetaansekolah', 'Home::pemetaansekolah');
$routes->get('datasekolah/detail/(:num)', 'Home::sekolah/$1');
$routes->get('sekolah/(:num)', 'Home::sekolah/$1');
$routes->get('peta', 'Home::peta');
$routes->get('tentang', 'Home::tentang');
$routes->get('Admin/login', 'Admin::login');
$routes->post('Admin/cekLogin', 'Admin::cekLogin');
$routes->get('Admin/logout', 'Admin::logout');
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Dashboard / umum untuk admin yang terautentikasi
    $routes->get('Admin', 'Admin::index');
    $routes->get('Admin/logout', 'Admin::logout');

    // Sekolah (akses dibatasi di controller: admin sekolah / superadmin)
    $routes->get('Sekolah', 'Sekolah::index');
    $routes->get('Sekolah/input', 'Sekolah::input');
    $routes->post('Sekolah/InsertData', 'Sekolah::InsertData');
    $routes->get('Sekolah/edit/(:num)', 'Sekolah::edit/$1');
    $routes->post('Sekolah/saveDraft/(:num)', 'Sekolah::saveDraft/$1');
    $routes->post('Sekolah/UpdateData/(:num)', 'Sekolah::UpdateData/$1');
    $routes->get('Sekolah/Delete/(:num)', 'Sekolah::Delete/$1');
    $routes->post('Sekolah/DeleteData/(:num)', 'Sekolah::DeleteData/$1');
    $routes->get('Sekolah/galeri/(:any)', 'Sekolah::galeri/$1');

    // Pengaturan akun untuk user yang sedang login (operator sekolah bisa akses)
    $routes->get('User/setting', 'User::setting');
    $routes->post('User/UpdatePassword', 'User::UpdatePassword');

    // Rute yang hanya boleh diakses super admin
    $routes->group('', ['filter' => 'auth:super_admin'], function($routes) {
        // Wilayah
        $routes->get('Wilayah', 'Wilayah::index');
        $routes->get('Wilayah/input', 'Wilayah::input');
        $routes->post('Wilayah/InsertData', 'Wilayah::InsertData');
        $routes->get('Wilayah/Edit/(:num)', 'Wilayah::Edit/$1');
        $routes->post('Wilayah/UpdateData/(:num)', 'Wilayah::UpdateData/$1');
        $routes->post('Wilayah/Delete/(:num)', 'Wilayah::Delete/$1');

        // Jenjang
        $routes->post('Jenjang/InsertData', 'Jenjang::InsertData');
        $routes->post('Jenjang/UpdateData/(:num)', 'Jenjang::UpdateData/$1');
        $routes->post('Jenjang/DeleteData/(:num)', 'Jenjang::DeleteData/$1');

        // User management (superadmin)
        $routes->get('User', 'User::index');
        $routes->get('User/edit', 'User::edit');
        $routes->post('User/UpdateProfil', 'User::UpdateProfil');
        $routes->post('User/UpdateEmail', 'User::UpdateEmail');

        // Admin settings
        $routes->get('Admin/Setting', 'Admin::Setting');
        $routes->post('Admin/UpdateSetting', 'Admin::UpdateSetting');
    });
});
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
