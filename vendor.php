<?php
/**
 * vendor.php — carga centralizada de librerías locales (entorno air-gapped).
 *
 * Uso en cada página:
 *
 *   require_once __DIR__ . '/vendor.php';
 *   headervendor('Título de la página');
 *   ... contenido HTML ...
 *   footvendor();
 *
 * Opciones de ambas funciones: ver los docblocks.
 */

// ---------------------------------------------------------------------------
// CONFIGURACIÓN — ajusta solo esta sección
// ---------------------------------------------------------------------------

// URL base (desde la raíz del sitio) donde están las librerías.
if (!defined('VENDOR_URL')) {
    define('VENDOR_URL', '/assets/vendor');
}

// URL de tu JS propio de inicialización (se carga al final, si el archivo existe).
if (!defined('VENDOR_INIT_JS')) {
    define('VENDOR_INIT_JS', '/assets/js/app-init.js');
}

// Archivos CSS, en orden de carga (relativos a VENDOR_URL).
function _vendor_css(): array
{
    return [
        '/bootstrap/css/bootstrap.min.css',
        '/fontawesome/css/all.min.css',
        '/datatables/datatables.min.css',   // bundle del Download Builder (Bootstrap 4)
    ];
}

// Archivos JS, en orden de carga (relativos a VENDOR_URL). jQuery SIEMPRE primero.
function _vendor_js(): array
{
    return [
        '/jquery/jquery-3.7.1.min.js',
        '/bootstrap/js/bootstrap.bundle.min.js', // incluye Popper
        '/datatables/datatables.min.js',         // bundle del Download Builder
    ];
}

// ---------------------------------------------------------------------------
// FUNCIONES INTERNAS
// ---------------------------------------------------------------------------

/**
 * Devuelve la URL con ?v=<mtime> para que el navegador recargue
 * el archivo cuando cambie. Si el archivo no existe, devuelve null.
 */
function _vendor_url(string $url): ?string
{
    $root = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
    $path = $root . $url;
    if (!is_file($path)) {
        return null;
    }
    return htmlspecialchars($url . '?v=' . filemtime($path), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Registra un aviso visible si falta un archivo (útil al instalar). */
function _vendor_missing(string $url): string
{
    return '<!-- vendor.php: NO ENCONTRADO ' . htmlspecialchars($url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . ' -->' . "\n";
}

// ---------------------------------------------------------------------------
// FUNCIONES PÚBLICAS
// ---------------------------------------------------------------------------

/**
 * Inicializa la página: cabeceras de seguridad, <head>, CSS y apertura de <body>.
 *
 * @param string $titulo  Título de la página (<title>).
 * @param array  $opts    [
 *     'lang'      => 'es',            // atributo lang de <html>
 *     'css_extra' => ['/css/x.css'],  // CSS propios (URL completa desde la raíz del sitio)
 *     'body_class'=> '',              // clases para <body>
 *     'csp'       => true,            // enviar Content-Security-Policy
 * ]
 */
function headervendor(string $titulo = '', array $opts = []): void
{
    $opts += [
        'lang'       => 'es',
        'css_extra'  => [],
        'body_class' => '',
        'csp'        => true,
    ];

    if (!headers_sent()) {
        header('Content-Type: text/html; charset=UTF-8');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: same-origin');

        if ($opts['csp']) {
            // Todo se sirve desde el mismo origen. 'unsafe-inline' solo en estilos
            // (Bootstrap 4 y DataTables lo necesitan); scripts inline quedan bloqueados.
            header("Content-Security-Policy: "
                . "default-src 'self'; "
                . "script-src 'self'; "
                . "style-src 'self' 'unsafe-inline'; "
                . "img-src 'self' data:; "
                . "font-src 'self'; "
                . "connect-src 'self'; "
                . "object-src 'none'; "
                . "base-uri 'self'; "
                . "form-action 'self'; "
                . "frame-ancestors 'self'");
        }
    }

    $lang  = htmlspecialchars($opts['lang'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $title = htmlspecialchars($titulo, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $bodyc = htmlspecialchars($opts['body_class'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    echo "<!DOCTYPE html>\n";
    echo "<html lang=\"{$lang}\">\n<head>\n";
    echo "<meta charset=\"UTF-8\">\n";
    echo "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">\n";
    echo "<title>{$title}</title>\n";

    foreach (_vendor_css() as $rel) {
        $url = VENDOR_URL . $rel;
        $v = _vendor_url($url);
        echo $v ? "<link rel=\"stylesheet\" href=\"{$v}\">\n" : _vendor_missing($url);
    }
    foreach ($opts['css_extra'] as $url) {
        $v = _vendor_url($url);
        echo $v ? "<link rel=\"stylesheet\" href=\"{$v}\">\n" : _vendor_missing($url);
    }

    echo "</head>\n";
    echo $bodyc !== '' ? "<body class=\"{$bodyc}\">\n" : "<body>\n";
}

/**
 * Carga los scripts y cierra <body> y <html>.
 *
 * @param array $js_extra  Scripts propios adicionales (URL desde la raíz del sitio),
 *                         se cargan después de las librerías y antes del init.
 */
function footvendor(array $js_extra = []): void
{
    foreach (_vendor_js() as $rel) {
        $url = VENDOR_URL . $rel;
        $v = _vendor_url($url);
        echo $v ? "<script src=\"{$v}\"></script>\n" : _vendor_missing($url);
    }
    foreach ($js_extra as $url) {
        $v = _vendor_url($url);
        echo $v ? "<script src=\"{$v}\"></script>\n" : _vendor_missing($url);
    }

    // Init global (opcional): solo se carga si el archivo existe.
    $init = _vendor_url(VENDOR_INIT_JS);
    if ($init) {
        echo "<script src=\"{$init}\"></script>\n";
    }

    echo "</body>\n</html>\n";
}
