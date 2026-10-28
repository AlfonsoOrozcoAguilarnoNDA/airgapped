# ¿Qué es este documento?

Esta es la guía "maestra" de las librerías de terceros que deben estar instaladas en los servidores PHP que administro (principalmente PHP 8.x, y en algunos casos 7.x). Estos sistemas manejan información sensible y operan en entornos desconectados de Internet (**air-gapped**), por lo que todas las librerías se sirven localmente.

Las versiones aquí listadas **no son las más recientes**, sino las que a **mayo de 2025** están autorizadas para su uso. Existen incompatibilidades menores con Bootstrap 5 en los componentes y librerías actuales, por lo que lo más sensato es mantener Bootstrap 4.6.2 y, mientras tanto, documentar lo necesario para actualizar lo que sí puede hacerse hoy. La migración a Bootstrap 5 queda pendiente hasta que se defina un esquema de pago por ese trabajo.

Este es el stack utilizado en proyectos gubernamentales entre 2020 y 2025. Algunos sistemas heredados ni siquiera usan Bootstrap y se migrarán, junto con el resto, cuando se defina el esquema de pago correspondiente. Esta es una documentación interna de los pasos a seguir, pero el uso de boostrap 4.6.2 es necesario por ser lo documentado en varios documentos de especificaciones hechos en su momento.

# Guía de Instalación para Entorno Air-Gapped

Esta guía contiene todos los recursos necesarios para ejecutar el sistema en un entorno desconectado de internet (air-gapped).

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener:
- Acceso a una máquina con internet para descargar los archivos
- Un medio de transferencia seguro (USB, red local, etc.)
- Servidor PHP configurado

## ⚠️ Dependencia Crítica: jQuery

**IMPORTANTE:** Tanto Bootstrap 4 como DataTables requieren jQuery para funcionar.

- **jQuery 3.7.1** (última versión de la rama 3.x, compatible con Bootstrap 4.6.2 y DataTables 1.13.x)
  - Descargar: [jquery-3.7.1.min.js](https://code.jquery.com/jquery-3.7.1.min.js)
  - *Instrucciones: Clic derecho → Guardar enlace como...*

**Justificación de la versión:** jQuery 3.7.1 es la última versión publicada de la rama 3.x. Incluye las correcciones de seguridad de 3.5.0 (XSS en `htmlPrefilter`) y las correcciones de errores posteriores, sin requerir cambios de código respecto a 3.6.0.

---

## 📦 Descarga de Recursos

### 1. Bootstrap 4.6.2

Descarga el paquete compilado oficial (incluye CSS, JS y Popper.js):

- **Archivo:** `bootstrap-4.6.2-dist.zip`
- **Enlace:** [Descargar Bootstrap 4.6.2](https://github.com/twbs/bootstrap/releases/download/v4.6.2/bootstrap-4.6.2-dist.zip)

### 2. Font Awesome 5.15.4

Descarga el paquete "For the Web" (Free) que incluye CSS y la carpeta `webfonts`:

- **Archivo:** `fontawesome-free-5.15.4-web.zip`
- **Enlace:** [Descargar Font Awesome 5.15.4](https://use.fontawesome.com/releases/v5.15.4/fontawesome-free-5.15.4-web.zip)

### 3. DataTables (con integración Bootstrap 4)

#### Opción A: Download Builder (Recomendado)

1. Ir a [DataTables Download Builder](https://datatables.net/download/)
2. En **Styling**, seleccionar: `Bootstrap 4`
3. En **Extensions**, marcar las necesarias (ej: Buttons, Responsive, FixedHeader)
4. En **Package**, descargar: `ZIP`

#### Opción B: Archivos Base (Core)

Si prefieres descargar manualmente los archivos base:

1. [dataTables.bootstrap4.min.css](https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css)
2. [jquery.dataTables.min.js](https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js)
3. [dataTables.bootstrap4.min.js](https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js)

> Se usa la rama 1.x de DataTables porque es la que tiene integración con Bootstrap 4 y jQuery. Se recomienda usar el último parche disponible de la 1.13.x.

### 4. Traducción de DataTables al Español

- **Archivo:** `es-ES.json`
- **Enlace:** [Descargar traducción](https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json)
- *Guardar como: `es.json`*

---

## 📂 Estructura de Carpetas Recomendada

Organiza los archivos descargados en la siguiente estructura dentro de tu proyecto PHP:

```
proyecto/
└── assets/
    └── vendor/
        ├── jquery/
        │   └── jquery-3.7.1.min.js
        ├── bootstrap/
        │   ├── css/bootstrap.min.css
        │   └── js/bootstrap.bundle.min.js
        ├── fontawesome/
        │   ├── css/all.min.css
        │   └── webfonts/
        └── datatables/
            ├── css/dataTables.bootstrap4.min.css
            ├── js/jquery.dataTables.min.js
            ├── js/dataTables.bootstrap4.min.js
            └── i18n/es.json
```

---

## 🔐 Verificación de Integridad

Después de descargar en la máquina con internet, genera los hashes y transfiérelos junto con los archivos. En el servidor air-gapped, verifica que coincidan:

```bash
# En la máquina con internet
cd assets/vendor && find . -type f -exec sha256sum {} \; > SHA256SUMS.txt

# En el servidor air-gapped
cd assets/vendor && sha256sum -c SHA256SUMS.txt
```

---

## 📑 Licencias

| Librería | Versión | Licencia |
|---|---|---|
| Bootstrap | 4.6.2 | MIT |
| jQuery | 3.7.1 | MIT |
| DataTables | 1.13.x | MIT |
| Font Awesome Free | 5.15.4 | Iconos: CC BY 4.0 · Fuentes: SIL OFL 1.1 · Código: MIT |

Conserva los comentarios de cabecera de copyright en los archivos CSS/JS (no los elimines al minificar).

---

## ⚖️ Riesgo Aceptado y Controles Compensatorios

**Decisión:** Se mantiene **Bootstrap 4.6.2** por compatibilidad con los componentes y librerías existentes del sistema. La migración a Bootstrap 5 implica una reescritura que está fuera del alcance y del presupuesto del proyecto.

**Riesgo identificado:** Bootstrap 4 llegó al fin de su vida útil (enero de 2023) y ya no recibe parches. Existen vulnerabilidades XSS conocidas en componentes específicos (tooltip, popover, carousel) que no serán corregidas en esta rama.

**Controles compensatorios:**
1. **Entorno aislado (air-gapped):** elimina la explotación remota y los ataques de cadena de suministro en tiempo de ejecución (sin CDN).
2. **Recursos servidos localmente** con versiones fijadas y verificadas mediante hashes SHA-256.
3. **Dependencias actualizadas dentro de su rama:** jQuery 3.7.1 y DataTables en la última versión 1.13.x.
4. **Escape de salida en el servidor** (`htmlspecialchars` con `ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'`) en todo dato que se imprima, lo que neutraliza los XSS independientemente de la versión de la librería.
5. **Content-Security-Policy estricta** (por ejemplo `script-src 'self'`; sin `unsafe-inline` donde sea posible).
6. **Restricción de uso:** los componentes tooltip, popover y carousel no deben recibir HTML proporcionado por usuarios. La opción `sanitize` de Bootstrap se mantiene activa.

**Plan de migración diferido:** la actualización a Bootstrap 5 se evaluará cuando exista presupuesto o cuando se reescriban los módulos afectados, pantalla por pantalla.

**Estado:** riesgo aceptado y documentado.
