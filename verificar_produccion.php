<?php
/**
 * VERIFICADOR INTEGRAL DE PRODUCCIÓN - CALDERA
 *
 * Subir a: public_html/caldera/verificar_produccion.php
 * Uso: https://tu-dominio.com/caldera/verificar_produccion.php?key=caldera2026
 *
 * Opcional:
 *   &clear=1      -> intenta limpiar caches viejos (bootstrap/cache + views compiladas)
 *   &show=1       -> muestra extractos de archivos sensibles de configuración
 *
 * BORRAR DESPUÉS DE USAR.
 */

$PASSWORD = 'caldera2026';
if (!isset($_GET['key']) || $_GET['key'] !== $PASSWORD) {
    http_response_code(403);
    die('<h2>Acceso denegado</h2><p>Usá ?key=caldera2026</p>');
}

function h($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function row($icon, $message, $class = '')
{
    echo "<tr class='{$class}'><td class='icon'>{$icon}</td><td>{$message}</td></tr>";
}

function ok($message) { row('✅', $message, 'ok'); }
function warn($message) { row('⚠️', $message, 'warn'); }
function fail($message) { row('❌', $message, 'fail'); }
function infoLine($message) { row('ℹ️', $message, 'info'); }

function startSection($title)
{
    echo "</table><h3>" . h($title) . "</h3><table>";
}

function startsWith($haystack, $needle)
{
    return substr((string) $haystack, 0, strlen((string) $needle)) === (string) $needle;
}

function containsText($haystack, $needle)
{
    return strpos((string) $haystack, (string) $needle) !== false;
}

function readEnvFile($path)
{
    $env = [];
    if (!is_file($path)) {
        return $env;
    }

    foreach (file($path) as $line) {
        $line = trim($line);
        if ($line === '' || startsWith($line, '#') || !containsText($line, '=')) {
            continue;
        }

        [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
        $env[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
    }

    return $env;
}

function extractAppBasePathFromIndex($indexFile)
{
    if (!is_file($indexFile)) {
        return null;
    }

    $content = file_get_contents($indexFile);
    if ($content === false) {
        return null;
    }

    if (preg_match("/define\(\s*'APP_BASE_PATH'\s*,\s*'([^']+)'\s*\)/", $content, $matches)) {
        return $matches[1];
    }

    if (preg_match('/define\(\s*"APP_BASE_PATH"\s*,\s*"([^"]+)"\s*\)/', $content, $matches)) {
        return $matches[1];
    }

    return null;
}

function findControllerImports($routesFile)
{
    if (!is_file($routesFile)) {
        return [];
    }

    $content = file_get_contents($routesFile) ?: '';
    preg_match_all('/use\\s+App\\\\Http\\\\Controllers\\\\([^;]+);/', $content, $matches);

    return array_values(array_unique($matches[1] ?? []));
}

function globSafe($pattern)
{
    $result = glob($pattern);
    return is_array($result) ? $result : [];
}

$publicDir = __DIR__;
$indexFile = $publicDir . '/index.php';
$basePath = extractAppBasePathFromIndex($indexFile);

if (!$basePath) {
    $basePath = dirname(__DIR__);
}

$envFile = rtrim($basePath, '/') . '/.env';
$env = readEnvFile($envFile);
$showDetails = isset($_GET['show']) && $_GET['show'] === '1';
$clearCaches = isset($_GET['clear']) && $_GET['clear'] === '1';

$bootstrapCacheDir = rtrim($basePath, '/') . '/bootstrap/cache';
$viewsCacheDir = rtrim($basePath, '/') . '/storage/framework/views';
$storageLogsDir = rtrim($basePath, '/') . '/storage/logs';
$routesFile = rtrim($basePath, '/') . '/routes/web.php';
$configDir = rtrim($basePath, '/') . '/config';
$vendorAutoload = rtrim($basePath, '/') . '/vendor/autoload.php';
$appBootstrap = rtrim($basePath, '/') . '/bootstrap/app.php';

$cacheFilesCleared = [];
$cacheFilesFailed = [];
if ($clearCaches) {
    foreach (globSafe($bootstrapCacheDir . '/*.php') as $file) {
        if (@unlink($file)) {
            $cacheFilesCleared[] = $file;
        } else {
            $cacheFilesFailed[] = $file;
        }
    }

    foreach (globSafe($viewsCacheDir . '/*.php') as $file) {
        if (@unlink($file)) {
            $cacheFilesCleared[] = $file;
        } else {
            $cacheFilesFailed[] = $file;
        }
    }
}

$suspectOldFiles = [
    'app/Http/Controllers/VacanteController.php',
    'app/Http/Controllers/CandidatosController.php',
    'app/Http/Controllers/ApartamentoController.php',
    'app/Http/Controllers/ReciboController.php',
    'app/Http/Controllers/SocioController.php',
    'app/Http/Controllers/LocalController.php',
    'app/Http/Controllers/ItemController.php',
    'app/Models/Vacante.php',
    'app/Models/Candidato.php',
    'app/Models/Apartamento.php',
    'app/Models/Local.php',
    'resources/views/vacantes',
    'resources/views/candidatos',
    'resources/views/apartamentos',
    'resources/views/locales',
    'resources/views/recibos',
    'resources/views/socios',
];

?><!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verificador Producción Caldera</title>
<style>
body{font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;max-width:1100px;margin:24px auto;padding:0 18px;color:#0f172a;background:#f8fafc}
h1,h2,h3{color:#312e81}h1{margin-bottom:8px}h3{margin-top:28px;border-bottom:2px solid #c7d2fe;padding-bottom:6px}
table{width:100%;border-collapse:collapse;background:#fff;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden}td{padding:9px 10px;font-size:14px;border-bottom:1px solid #eef2f7;vertical-align:top}.icon{width:44px;text-align:center;font-size:18px}.ok td{background:#f0fdf4}.warn td{background:#fffbeb}.fail td{background:#fef2f2}.info td{background:#f8fafc}.badge{display:inline-block;background:#e0e7ff;color:#3730a3;border-radius:999px;padding:2px 8px;font-size:12px;font-family:ui-monospace,Menlo,monospace}.mono{font-family:ui-monospace,Menlo,monospace}.box{background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px 16px;margin:16px 0}.danger{background:#fff7ed;border-color:#fdba74}.small{font-size:12px;color:#64748b}pre{background:#0f172a;color:#e2e8f0;padding:12px;border-radius:8px;overflow:auto;font-size:12px}
a{color:#4338ca}.grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}@media(max-width:900px){.grid{grid-template-columns:1fr}}
</style>
</head>
<body>
<h1>🩺 Verificador integral de producción</h1>
<p class="small">Hora servidor: <?= h(date('d/m/Y H:i:s')) ?> · Host: <span class="badge"><?= h($_SERVER['HTTP_HOST'] ?? '-') ?></span></p>
<div class="box danger"><strong>Borrá este archivo cuando termines.</strong> Si querés limpiar caches desde aquí, agregá <span class="mono">&clear=1</span>.</div>

<table>
<?php
infoLine('Public dir: <span class="badge mono">' . h($publicDir) . '</span>');
infoLine('Index público: <span class="badge mono">' . h($indexFile) . '</span>');
if (is_file($indexFile)) {
    ok('index.php público encontrado');
} else {
    fail('Falta public_html/caldera/index.php');
}

if ($basePath !== '') {
    ok('APP_BASE_PATH detectado: <span class="badge mono">' . h($basePath) . '</span>');
} else {
    fail('APP_BASE_PATH quedó vacío');
}

if (is_dir($basePath)) {
    ok('La carpeta base existe');
} else {
    fail('La carpeta base NO existe: <span class="badge mono">' . h($basePath) . '</span>');
}

if (is_dir($configDir)) {
    ok('Config dir existe: <span class="badge mono">' . h($configDir) . '</span>');
} else {
    fail('Config dir no existe: <span class="badge mono">' . h($configDir) . '</span>');
}

if (is_file($vendorAutoload)) {
    ok('vendor/autoload.php existe');
} else {
    fail('Falta vendor/autoload.php');
}

if (is_file($appBootstrap)) {
    ok('bootstrap/app.php existe');
} else {
    fail('Falta bootstrap/app.php');
}
?>
</table>

<?php startSection('Variables .env y logging'); ?>
<?php
if (is_file($envFile)) {
    ok('.env encontrado: <span class="badge mono">' . h($envFile) . '</span>');
} else {
    fail('.env NO encontrado: <span class="badge mono">' . h($envFile) . '</span>');
}

$requiredEnv = [
    'APP_ENV', 'APP_KEY', 'APP_URL', 'LOG_CHANNEL', 'DB_CONNECTION', 'DB_HOST', 'DB_DATABASE', 'DB_USERNAME'
];

foreach ($requiredEnv as $key) {
    $value = $env[$key] ?? null;
    if ($value === null) {
        fail("Falta {$key} en .env");
    } elseif ($value === '') {
        fail("{$key} está vacío");
    } else {
        ok("{$key} = <span class='badge mono'>" . h($value) . '</span>');
    }
}

$logChannel = $env['LOG_CHANNEL'] ?? null;
$validLogChannels = ['stack', 'single', 'daily', 'slack', 'syslog', 'errorlog', 'stderr', 'null'];
if ($logChannel === null || $logChannel === '') {
    fail('LOG_CHANNEL vacío: esto explica el error <span class="mono">Log [] is not defined</span>');
} elseif (!in_array($logChannel, $validLogChannels, true)) {
    warn('LOG_CHANNEL no parece estándar: <span class="badge mono">' . h($logChannel) . '</span>');
} else {
    ok('LOG_CHANNEL válido');
}

if (($env['APP_ENV'] ?? '') !== 'production') {
    warn('APP_ENV no está en production');
}

if (($env['APP_DEBUG'] ?? '') !== 'false' && ($env['APP_DEBUG'] ?? '') !== '0') {
    warn('APP_DEBUG no está en false');
}
?>
</table>

<?php startSection('Cachés viejos y compilados'); ?>
<?php
$bootstrapCacheFiles = globSafe($bootstrapCacheDir . '/*.php');
$viewCacheFiles = globSafe($viewsCacheDir . '/*.php');

if (is_dir($bootstrapCacheDir)) {
    infoLine('bootstrap/cache: <span class="badge mono">' . h($bootstrapCacheDir) . '</span>');
    if (empty($bootstrapCacheFiles)) {
        ok('No hay archivos PHP cacheados en bootstrap/cache');
    } else {
        warn('Hay ' . count($bootstrapCacheFiles) . ' archivos cacheados en bootstrap/cache');
        foreach ($bootstrapCacheFiles as $file) {
            infoLine('Cache: <span class="badge mono">' . h(basename($file)) . '</span>');
        }
    }
} else {
    fail('No existe bootstrap/cache');
}

if (is_dir($viewsCacheDir)) {
    infoLine('views cache dir: <span class="badge mono">' . h($viewsCacheDir) . '</span>');
    if (empty($viewCacheFiles)) {
        ok('No hay vistas compiladas viejas');
    } else {
        warn('Hay ' . count($viewCacheFiles) . ' vistas compiladas');
    }
} else {
    fail('No existe storage/framework/views');
}

if ($clearCaches) {
    if ($cacheFilesCleared) {
        ok('Se limpiaron ' . count($cacheFilesCleared) . ' archivos cacheados');
    }
    if ($cacheFilesFailed) {
        fail('No se pudieron borrar ' . count($cacheFilesFailed) . ' archivos cacheados');
        foreach ($cacheFilesFailed as $failedFile) {
            infoLine('Falló: <span class="badge mono">' . h($failedFile) . '</span>');
        }
    }
}
?>
</table>

<?php startSection('Storage, logs y permisos'); ?>
<?php
$dirsToCheck = [
    'storage/framework',
    'storage/framework/views',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/logs',
    'bootstrap/cache',
];

foreach ($dirsToCheck as $relative) {
    $full = rtrim($basePath, '/') . '/' . $relative;
    if (!is_dir($full)) {
        fail('No existe <span class="badge mono">' . h($relative) . '</span>');
        continue;
    }

    if (is_writable($full)) {
        ok('Escribible: <span class="badge mono">' . h($relative) . '</span>');
    } else {
        fail('Sin permisos de escritura: <span class="badge mono">' . h($relative) . '</span>');
    }
}

$logFile = $storageLogsDir . '/laravel.log';
if (is_file($logFile)) {
    ok('Existe storage/logs/laravel.log');
    infoLine('Tamaño log: <span class="badge mono">' . h((string) filesize($logFile)) . ' bytes</span>');
} else {
    warn('No existe storage/logs/laravel.log todavía');
}
?>
</table>

<?php startSection('Controladores referenciados por routes/web.php'); ?>
<?php
if (is_file($routesFile)) {
    ok('routes/web.php existe');
    $controllers = findControllerImports($routesFile);
    if (empty($controllers)) {
        warn('No pude extraer imports de controladores');
    } else {
        foreach ($controllers as $controller) {
            $controllerPath = rtrim($basePath, '/') . '/app/Http/Controllers/' . str_replace('\\', '/', $controller) . '.php';
            if (is_file($controllerPath)) {
                ok('Existe ' . h($controller));
            } else {
                fail('Falta controlador importado: <span class="badge mono">' . h($controller) . '</span>');
            }
        }
    }
} else {
    fail('No existe routes/web.php');
}
?>
</table>

<?php startSection('Posibles residuos viejos del deploy'); ?>
<?php
$foundOldFiles = 0;
foreach ($suspectOldFiles as $relative) {
    $full = rtrim($basePath, '/') . '/' . $relative;
    if (file_exists($full)) {
        $foundOldFiles++;
        warn('Residuo viejo detectado: <span class="badge mono">' . h($relative) . '</span>');
    }
}

if ($foundOldFiles === 0) {
    ok('No encontré residuos viejos de los módulos removidos');
}
?>
</table>

<?php startSection('Assets y public'); ?>
<?php
$hotFile = $publicDir . '/hot';
$manifestFile = $publicDir . '/build/manifest.json';
if (is_file($hotFile)) {
    fail('Existe archivo public/hot: fuerza assets de desarrollo');
} else {
    ok('No existe public/hot');
}

if (is_file($manifestFile)) {
    ok('Existe build/manifest.json');
} else {
    warn('No existe build/manifest.json');
}
?>
</table>

<?php if ($showDetails): ?>
    <div class="grid">
        <div class="box">
            <h3>index.php público</h3>
            <pre><?= h((string) @file_get_contents($indexFile)) ?></pre>
        </div>
        <div class="box">
            <h3>.env leído</h3>
            <pre><?php foreach ($env as $key => $value) { echo h($key . '=' . $value) . "\n"; } ?></pre>
        </div>
    </div>
<?php endif; ?>

<div class="box danger">
    <strong>Interpretación rápida:</strong>
    <ul>
        <li>Si ves <span class="mono">APP_BASE_PATH</span> mal o vacío, el problema está en <span class="mono">public_html/caldera/index.php</span>.</li>
        <li>Si ves <span class="mono">LOG_CHANNEL</span> vacío, corregí el <span class="mono">.env</span>.</li>
        <li>Si ves controladores importados faltantes, todavía quedó un <span class="mono">routes/web.php</span> viejo.</li>
        <li>Si ves caches viejos, repetí con <span class="mono">&clear=1</span>.</li>
    </ul>
    <p class="small">Borrá este archivo al terminar.</p>
</div>
</body>
</html>
