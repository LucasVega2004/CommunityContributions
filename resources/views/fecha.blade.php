@extends('layouts.app')

@section('content')

    <body>
        <h1>Fecha Actual</h1>
        <p>Día: {{ $dia }}</p>
        <p>Mes: {{ $mes }}</p>
        <p>Año: {{ $anio }}</p>
    </body>
@endsection
