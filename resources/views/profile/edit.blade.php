@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Auth::user()->profile != null)
            <img src="{{ url('storage/' . Auth::user()->profile->imageUpload) }}" alt="imagen ususario"
                style="height: 50px;width:50px">
        @endif
        <form action="/profile/store" method="POST" id="updateImage" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="image">Seleccionar archivo:</label>
                <input class="form-control @error('imageUpload') is-invalid @enderror" type="file" name="imageUpload"
                    id="file">
            </div>
            <div class="form-group pt-3">
                <button class="btn btn-primary">Sube una imagen</button>
            </div>
            @error('imageUpload')
                <div class="alert alert-danger">Fallo al subir archivo. No cumple los requisitos, sube un archivo con extension
                    .jpg .png o .jpeg</div>
            @enderror
        </form>
    </div>
@endsection
