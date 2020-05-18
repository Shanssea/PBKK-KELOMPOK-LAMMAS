<?php

$router = $di->getRouter();

// Define your routes here

$router->handle($_SERVER['REQUEST_URI']);

/**************************************
 ****************UMUM******************
 **************************************/

$router->add(
    '/login',
    [
        'controller' => 'pengguna',
        'action' => 'loginpage',
    ]
);

/**
 * INVENTARIS
 */

$router->add(
    'inventaris/submit/([0-9])/:params',
    [
        'controller' => 'inventaris',
        'action' => 'submit',
        'isAdmin' => 1,
    ]
);

/**************************************
 ****************ADMIN*****************
 **************************************/

$router->add(
    '/admin/([0-9])/:params',
    [
        'controller' => 'admin',
        'action' => 'index',
        'isAdmin' => 1,
    ]
);

/**
 * INVENTARIS
 */

$router->add(
    '/admin/([0-9])/:params/createInv',
    [
        'controller' => 'admin',
        'action' => 'createInv',
        'isAdmin' => 1,
    ]
);

$router->add(
    '/admin/listInv/([0-9])/:params',
    [
        'controller' => 'admin',
        'action' => 'listInv',
        'isAdmin' => 1,
    ]
);

$router->add(
    '/admin/([0-9])/updateInv/([0-9])/:params',
    [
        'controller' => 'admin',
        'action' => 'updateInv',
        'isAdmin' => 1,
        'invenId' => 2,
    ]
);

$router->add(
    '/admin/([0-9])/deleteInv/([0-9])/:params',
    [
        'controller' => 'admin',
        'action' => 'deleteInv',
        'isAdmin' => 1,
        'invenId' => 2,
    ]
);

$router->add(
    '/admin/([0-9])/confirmInv/([0-9])/:params',
    [
        'controller' => 'admin',
        'action' => 'confirmInv',
        'isAdmin' => 1,
        'invenId' => 2,
    ]
);

$router->add(
    '/admin/([0-9])/declineInv/([0-9])/:params',
    [
        'controller' => 'admin',
        'action' => 'declineInv',
        'isAdmin' => 1,
        'invenId' => 2,
    ]
);

/**
 * PC
 */

$router->add(
    "/admin/updatePC/([0-9]+)/:params",
    array(
        "controller" => "pc",
        "action"     => "update",
        "id"       => 1, // ([0-9]
    )
);

$router->add(
    "/admin/editPC/([0-9]+)/:params",
    array(
        "controller" => "admin",
        "action"     => "editpc",
        "id"       => 1, // ([0-9]
    )
);

$router->add(
    "/admin/hapusPC/([0-9]+)/:params",
    array(
        "controller" => "pc",
        "action"     => "hapus",
        "id"       => 1, // ([0-9]
    )
);

$router->add(
    "/admin/confirmReservasiPC/([0-9]+)/:params",
    array(
        "controller" => "PermohonanPc",
        "action"     => "confirm",
        "id"       => 1, // ([0-9]
    )
);

/**
 * RUANGAN
 */

// $router->add(
//     "/admin/jadwalPemakaianRuangan/([0-9]+)/:params",
//     array(
//         // "controller" => "PermohonanRuangan",
//         // "action"     => "jadwallab",
//         // "id"       => 1, // ([0-9]
//         "controller" => "admin",
//         "action"     => "jadwalPemakaianRuangan",
//         "id"       => 1, // ([0-9]
//     )
// );

$router->add(
    "/admin/listPermohonanRuangan/([0-9]+)/:params",
    array(
        "controller" => "PermohonanRuangan",
        "action"     => "listpr",
        "id"       => 1, // ([0-9]
    )
);

$router->add(
    "/admin/confirmReservasiLab/([0-9]+)/:params",
    array(
        "controller" => "PermohonanRuangan",
        "action"     => "confirm",
        "id"       => 1, // ([0-9]
    )
);

/**************************************
 **************MAHASISWA***************
 **************************************/
/**
 * PC
 */

$router->add(
    "/mahasiswa/reservepc",
    array(
        "controller" => "PermohonanPc",
        "action"     => "reserve",
    )
);

/**
 * LAB
 */

$router->add(
    "/mahasiswa/reservelab",
    array(
        "controller" => "PermohonanRuangan",
        "action"     => "reservel",
    )
);

/**
 * INVENTARIS
 */

$router->add(
    '/mahasiswa/([0-9])/:params',
    [
        'controller' => 'mahasiswa',
        'action' => 'index',
        'userId' => 1,
    ]
);

$router->add(
    '/mahasiswa/([0-9])/listInv/:params',
    [
        'controller' => 'mahasiswa',
        'action' => 'listInv',
        'userId' => 1,
    ]
);

$router->add(
    '/mahasiswa/([0-9])/inv/([0-9])/:params',
    [
        'controller' => 'mahasiswa',
        'action' => 'requestInv',
        'userId' => 1,
        'invenId' => 2,
    ]
);