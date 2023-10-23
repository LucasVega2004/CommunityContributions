<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes(['verify' => 'true']);




Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::get('/user/{name?}', function (?string $name = "There is no name selected") {
    return $name;
});

Route::post('/userPost', function (?string $name = "There is no name selected") {
    return 'Ruta Post';
});

Route::match(['get', 'post'], '/getpost/{name?}', function (?string $name = "There is no name selected") {
    return $name;
});

Route::get('/numero/{parametro}', function ($parametro) {
    if (is_numeric($parametro)) {
        return "El parámetro es numérico: " . $parametro;
    } else {
        return "El parámetro no es numérico";
    }
});

Route::get('/doble/{letras?}/{numeros?}', function ($letras, $numeros) {
    if (is_numeric($numeros) && ctype_alpha($letras)) {
        return "El primer parametro son solo letras y el segundo solo numeros";
    } else {
        return "No cumple los requisitos";
    }
});

Route::get('/host', function () {
    $dbHost = env('DB_HOST');
    return "La dirección IP de la base de datos es: " . $dbHost;
});

Route::get('/timezone', function () {
    $timezone = config('app.timezone');
    return "La zona horaria configurada es: " . $timezone;
});

Route::view('/inicio', 'home');

Route::view('fecha', 'fecha');


Route::get('/fecha', function () {
    // Obtén la fecha actual usando la función date() de PHP
    $fechaActual = date('Y-m-d');

    // Divide la fecha en componentes de día, mes y año
    list($anio, $mes, $dia) = explode('-', $fechaActual);

    // Pasa los datos a la vista "fecha.blade.php" como un arreglo asociativo
    return view('fecha', [
        'dia' => $dia,
        'mes' => $mes,
        'anio' => $anio,
    ]);
});

Route::get('/fechaCompact', function () {
    // Obtén la fecha actual usando la función date() de PHP
    $fechaActual = date('Y-m-d');

    // Divide la fecha en componentes de día, mes y año
    list($anio, $mes, $dia) = explode('-', $fechaActual);

    // Pasa los datos a la vista "fecha.blade.php" utilizando compact
    return view('fecha', compact('dia', 'mes', 'anio'));
});

Route::get('/fechaWith', function () {

    $fechaActual = date('Y-m-d');


    list($anio, $mes, $dia) = explode('-', $fechaActual);


    return view('fecha')->with('dia', $dia)->with('mes', $mes)->with('anio', $anio); //tienen que llamarse igual
});

Route::get('/imagen', function () {
    return view('imagen');
});

Route::get('community', [App\Http\Controllers\CommunityLinkController::class, 'index']);

Route::post('community', [App\Http\Controllers\CommunityLinkController::class, 'store'])
    ->middleware('auth');

Route::get('/returnresponse', function () {
    return response('Error', 404)
        ->header('Content-Type', 'text/plain');
});
Route::get('community/{channel:slug}', [App\Http\Controllers\CommunityLinkController::class, 'index']);

Route::get('/consultas1', function () {
    $usuarios = DB::table('users')
        ->where('name', 'like', '%Fer%')
        ->get();


    return $usuarios;
});

Route::get('/consultas2', function () {
    $usuarios = DB::table('users')
        ->where([
            ['email', 'like', '%laravel%.com'],
        ])
        ->get();

    return $usuarios;
});


Route::get('/consultas3', function () {
    $usuarios = DB::table('users')
        ->where('email', 'like', '%laravel%')
        ->orWhere('email', 'like', '%com%')
        ->get();

    return $usuarios;
});

Route::get('/consultas4', function () {
    DB::table('users')->insert([
        'name' => 'insert usuarioa-',
        'email' => 'insert@gmaila.com',
        'password' => 'contraseñaa'
    ]);

    return 'Usuario insertado correctamente.';
});

Route::get('/consultas5', function () {
    DB::table('users')->insert([
        ['name' => 'Usuario 1', 'email' => 'usuario1@ejemplo.com', 'password' => 'contra'],
        ['name' => 'Usuario 2', 'email' => 'usuario2@ejemplo.com', 'password' => 'contra'],
    ]);

    return 'Dos usuarios insertados correctamente.';
});

Route::get('/consultas6', function () {
    $id = DB::table('users')->insertGetId([
        'name' => 'inserta id',
        'email' => 'insertiad@gmail.com',
        'password' => 'contra',

    ]);

    return 'Usuario insertado con ID: ' . $id;
}); 
Route::get('/consultas7', function () {
    $affected = DB::table('users')
        ->where('id', 2)
        ->update(['email' => 'updateemail@gmail.com']);

    return 'Registros actualizados: ' . $affected;
});


Route::get('/consultas8', function () {
    $deleted = DB::table('users')
        ->where('id', 3)
        ->delete();

    return 'Registros eliminados: ' . $deleted;
});
