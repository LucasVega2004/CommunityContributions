@extends('layouts.app')

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('./css/style.css') }}">
</head>

@section('content')
    <div class="container">
        @include('flash-message')
        <div class="row">
            {{-- Left column to show all the links in the DB --}}
            @if (count($links) > 0)
                <div class="col-md-8">
                    @php
                        $selectedChannel = request('channel.slug');
                    @endphp
                    @if ($selectedChannel)
                        <h1>Listado de Links de {{ $selectedChannel }}</h1>
                    @else
                        <h1>Listado de Links</h1>
                    @endif
                    <h3><a class="text-decoration-none" href="http://communitycontributions.test/community">Community</a></h3>
                    @foreach ($links as $link)
                        <li id="linkli">
                            <a class="text-decoration-none" href="/community/{{ $link->channel->slug }}">
                                <span class="label label-default" style="background: {{ $link->channel->color }}">
                                    {{ $link->channel->title }}
                                </span>
                            </a>
                            <a href="{{ $link->link }}" target="_blank">
                                {{ $link->title }}
                            </a>
                            <small>Contributed by: {{ $link->creator->name }}
                                {{ $link->updated_at->diffForHumans() }}</small>
                        </li>
                    @endforeach
                </div>
            @else
                <div class="col-md-8">
                    <h1>No hay contribuciones validadas</h1>
                </div>
            @endif
            {{-- Right column to show the form to upload a link --}}
            @include('add-link')
            {{ $links->links() }}
        </div>
    </div>
@stop
