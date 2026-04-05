<?php

/**
 * index.php MODIFICADO para producción en subdirectorio cPanel
 *
 * Este archivo reemplaza public/index.php en el servidor.
 *
 * Estructura en el servidor:
 *   /home/TU_USUARIO/caldera_core/        ← carpeta privada (fuera de public_html)
 *   /home/TU_USUARIO/public_html/caldera/ ← esta carpeta (contenido de public/)
 *
 * ANTES DE SUBIR: reemplazá TU_USUARIO por tu usuario real de cPanel.
 */

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Ruta absoluta a la carpeta privada con el código Laravel
define('APP_BASE_PATH', '/home/enlacec/caldera_core');

// Propagar base path al entorno por compatibilidad con bootstrap/app.php
putenv('APP_BASE_PATH=' . APP_BASE_PATH);
$_ENV['APP_BASE_PATH'] = APP_BASE_PATH;
$_SERVER['APP_BASE_PATH'] = APP_BASE_PATH;

// Modo mantenimiento
if (file_exists(APP_BASE_PATH . '/storage/framework/maintenance.php')) {
    require APP_BASE_PATH . '/storage/framework/maintenance.php';
}

// Autoloader
require APP_BASE_PATH . '/vendor/autoload.php';

// Bootstrap de la app
$app = require_once APP_BASE_PATH . '/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
