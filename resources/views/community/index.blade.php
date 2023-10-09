@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- Left colum to show all the links in the DB --}}
            <div class="col-md-8">
                <h1>Listado de Links</h1>
                @foreach ($links as $link)
                    <li>
                        <a href="{{ $link->link }}" target="_blank">
                            {{ $link->title }}
                        </a>
                        <span class="label label-default" style="background: {{ $link->channel->color }}">
                            {{ $link->channel->title }}
                        </span>
                        <small>Contributed by: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}</small>
                    </li>
                @endforeach
            </div>

            {{-- Right colum to show the form to upload a link --}}
            @include('add-link')

            {{ $links->links() }}
        </div>
    @stop
