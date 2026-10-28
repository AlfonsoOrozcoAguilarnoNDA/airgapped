# Guía de Instalación para Entorno Air-Gapped

Esta guía contiene todos los recursos necesarios para ejecutar el sistema en un entorno desconectado de internet (air-gapped).

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener:
- Acceso a una máquina con internet para descargar los archivos
- Un medio de transferencia seguro (USB, red local, etc.)
- Servidor PHP configurado

## ⚠️ Dependencia Crítica: jQuery

**IMPORTANTE:** Tanto Bootstrap 4 como DataTables requieren jQuery para funcionar.

- **jQuery 3.6.0** (Compatible con Bootstrap 4.6.2)
  - Descargar: [jquery-3.6.0.min.js](https://code.jquery.com/jquery-3.6.0.min.js)
  - *Instrucciones: Clic derecho → Guardar enlace como...*

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

### 4. Traducción de DataTables al Español

- **Archivo:** `es-ES.json`
- **Enlace:** [Descargar traducción](https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json)
- *Guardar como: `es.json`*

---

## 📂 Estructura de Carpetas Recomendada

Organiza los archivos descargados en la siguiente estructura dentro de tu proyecto PHP:
