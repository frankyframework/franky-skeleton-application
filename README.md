# franky-skeleton-application
Aplicacion inicial de proyecto franky


# Convertir a imagenes de próxima generación

Librerias necesarias para convertir imagenes de próxima generación.

sudo apt-get install imagemagick webp libjxr-tools

Comando para convertir a imagenes de proxima generacionm unicamente offline y se suben las imagenes al servidor.

franky b:img

# configurar Browser sync

browser-sync start --proxy "local.franky" --files "public/skin/default/css/*.css, public/skin/default/css/franky-font/*.css, public/skin/catalog/css/*.css, public/skin/ecommerce/css/*.css, public/skin/blog/css/*.css, public/skin/galeria/css/*.css, public/skin/slider/css/*.css"