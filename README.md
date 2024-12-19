## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

This project is developed by EdvardKS (https://edvardks.com)
You can contact with me in (info@edvardks.com)

Cómo instalar por EdvardKS

composer require laravel/sail --dev

php artisan sail:install


# nauticas_torrevieja_app
El repositorio creado para Actividades Náuticas Torrevieja tiene como objetivo llevar un control de versiones para el desarrollo de la aplicación.
 
Para Actividades Nauticas Torrevieja se crea este repositorio con el objetivo de llevar un versionado de la aplicación a desarrollar.
La app consiste en un Laravel, SSRendering. MYSQL. Backend Laravel. Frontend Laravel con motor Vite.
El proyecto parte de otro realizado "Asadorlamorenica.com". Este, desarrollado en 2023 por Edvard Khachatryan Sahakyan (info@edvardks.com).
Para desplegar en local:
  Instalar composer (vendor).
  Instalar node,npm (node_modules).
  Ejecutar contenedores (Docker).
  Entrar en el de laravel, ejecutar las migraciones.
  Salir de laravel y ejecutar Vite en modo desarrollo.

Test: Production work correctly with git


# Comandos de Interes

Primero Tendrás que abrir Docker, y ejecutar los contenedores: `docker-compose up-d`

Para desarrollar deberás ejecutar en la raiz del proyecto: `npm run dev`

Entrar al contenedor de laravel:` docker exec -it laravel-nautica bash`

Los comandos de laravel hay que ejecutarlo dentro del contenedor:
  - `php artisan migrate `
            Este ejecuta solo las migraciones manteniendo lo anterior en BD, puedes crear nuevas tablas sin tener que eliminar los datos anteriores
            
  - `php artisan migrate:refresh --seed`
            Este elimina toda la BD, la vuelve a crear e inserta los datos
            En /database/seeders/DatabaseSeeder.php Tienes para comentar o descomentar la línea de código para importar los datos de Booking

