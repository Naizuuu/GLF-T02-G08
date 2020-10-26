# Repo Grafos UTEM - Tarea 2
Este es el repositorio de la segunda tarea del ramo de Grafos y Lenguajes Formales.

---

## ¿Qué se pide?

Diseñar una aplicación web (página web) que, en base a los contenidos de la asignatura, permita:
- Ingresar 2 autómatas a la aplicación (pueden ser AFD y/o AFND)
- A partir de los autómatas ingresados, debe:
    - Obtener el AFD equivalente (si es AFND) y simplificarlos.
    - Obtener el autómata a partir del complemento, unión, concatenación e intersección entre ambos autómatas.
    - Pasar los autómatas del punto anterior a AFD y simplificarlos.
    
## ¿Cómo hacer correr el proyecto en tu máquina?

Lo primero que se necesita es tener instalado Xampp, en específico la [versión PHP 7.3.22](https://www.apachefriends.org/xampp-files/7.3.22/xampp-windows-x64-7.3.22-0-VC15-installer.exe).
También es necesario tener instalado [Composer](https://getcomposer.org/Composer-Setup.exe)

Luego de instalar ambas cosas, se debe hacer lo siguiente:
1. Abrir el bash de windows o git dentro de la carpeta xampp/htdocs
2. Escribir en la terminal: git clone (link del repo)
3. composer install
4. copy .env.example .env (en caso de hacerlo con la git bash: cp .env.example .env)
5. php artisan key:generate

Con esto ya se podrá visualizar el contenido de la página web.