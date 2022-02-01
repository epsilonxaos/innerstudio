const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js');
mix.js('resources/js/inicio.js', 'public/js');
mix.js('resources/js/perfil.js', 'public/js');
mix.js('resources/js/terminos.js', 'public/js');
mix.js('resources/js/clases.js', 'public/js');
mix.js('resources/js/teamdetalle.js', 'public/js');
mix.js('resources/js/blog.js', 'public/js');
mix.js('resources/js/ubicacion.js', 'public/js');
mix.js('resources/js/blogdetalle.js', 'public/js');


mix.js('resources/js/reservacion_detail.js', 'public/js');
mix.js('resources/js/pagofacil3ds.js', 'public/js');
mix.js('resources/js/compra.js', 'public/js');

mix.sass('resources/sass/app-plugins.scss', 'public/css');
mix.sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/sass/inicio-plugins.scss', 'public/css');
mix.sass('resources/sass/inicio.scss', 'public/css');
mix.sass('resources/sass/comprar.scss', 'public/css');
mix.sass('resources/sass/paquetes.scss', 'public/css');
mix.sass('resources/sass/perfil-plugins.scss', 'public/css');
mix.sass('resources/sass/perfil.scss', 'public/css');
mix.sass('resources/sass/reservacion.scss', 'public/css');
mix.sass('resources/sass/terminos.scss', 'public/css');
mix.sass('resources/sass/clases.scss', 'public/css');
mix.sass('resources/sass/ubicacion.scss', 'public/css');

mix.sass('resources/sass/team.scss', 'public/css');
mix.sass('resources/sass/teamdetalle.scss', 'public/css');
mix.sass('resources/sass/blog.scss', 'public/css');
mix.sass('resources/sass/blogdetalle.scss', 'public/css');


/*PANEL DE CONTROL*/
mix.js('resources/js/admin/custom_data_tables.js', 'public/admin/js/custom/custom_data_tables.js');
mix.js('resources/js/admin/customer/functions.js', 'public/admin/js/custom/customer.js');
mix.js('resources/js/admin/instructor/functions.js', 'public/admin/js/custom/instructor.js');
mix.js('resources/js/admin/instructor/functions_create.js', 'public/admin/js/custom/instructor_create.js');
mix.js('resources/js/admin/package/functions.js', 'public/admin/js/custom/package.js');
mix.js('resources/js/admin/lesson/functions.js', 'public/admin/js/custom/lesson.js');
mix.js('resources/js/admin/mat/functions.js', 'public/admin/js/custom/mat.js');
mix.js('resources/js/admin/purchase/functions.js', 'public/admin/js/custom/purchase.js');
mix.js('resources/js/admin/cupon/functions.js', 'public/admin/js/custom/cupon.js');
mix.js('resources/js/admin/reservations/functions.js', 'public/admin/js/custom/reservations.js');
mix.js('resources/js/admin/users/functions.js', 'public/admin/js/custom/users.js');
mix.js('resources/js/admin/rol/functions.js', 'public/admin/js/custom/rol.js');
mix.js('resources/js/admin/reservations/functions_create.js', 'public/admin/js/custom/reservations_create.js');
mix.js('resources/js/admin/calendar/functions.js', 'public/admin/js/custom/calendar.js');
mix.js('resources/js/admin/calendar/asistencia.js', 'public/admin/js/custom/asistencia.js');
mix.sass('resources/sass/admin/general.scss', 'public/admin/css/custom/general.css');
mix.sass('resources/sass/admin/lesson.scss', 'public/admin/css/custom/lesson.css');
mix.sass('resources/sass/admin/components/datepicker.scss', 'public/admin/css/custom/components');
mix.sass('resources/sass/admin/components/fullCalendar.scss', 'public/admin/css/custom/components');

