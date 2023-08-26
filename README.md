# Real IP Revealer

Real IP Revealer es un plugin de WordPress diseñado para descubrir y asignar la verdadera dirección IP del cliente en entornos con Cloudflare o proxies inversos.

## Descripción

Este plugin verifica una serie de encabezados en un orden específico para identificar la primera IP pública válida encontrada. Si no se detecta ninguna IP válida en los encabezados, el plugin registrará un error y establecerá la dirección IP del servidor como la dirección IP del cliente.

Además, el plugin muestra una notificación en el panel de administración de WordPress indicando la dirección IP del usuario actual. Si WooCommerce está activo, el plugin se asegura de que la dirección IP real se establezca correctamente antes de que WooCommerce la recopile durante el proceso de pago.

## Requisitos

- WordPress 5.2 o superior
- PHP 7.4 o superior

## Instalación

1. Descarga el archivo ZIP del plugin.
2. Accede a la sección de plugins en tu panel de administración de WordPress y haz clic en "Añadir nuevo".
3. Haz clic en "Subir plugin" y selecciona el archivo ZIP que descargaste.
4. Haz clic en "Instalar ahora" y luego en "Activar".

## Uso

Una vez que el plugin esté instalado y activado, comenzará a funcionar automáticamente, sin necesidad de configuraciones adicionales.

## Licencia

Este plugin está licenciado bajo la [GPLv3 o posterior](https://www.gnu.org/licenses/gpl-3.0.html).

## Autor

Michael Barrera - [Perfil de GitHub](https://github.com/michael2rain/)
