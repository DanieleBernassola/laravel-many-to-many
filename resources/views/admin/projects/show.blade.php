@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="header-page d-flex justify-content-between align-items-center">
            <h2>{{ $project->title }}</h2>
            {{-- <div>
                <button class="btn btn-primary">Crea nuovo progetto</button>
            </div> --}}
        </div>
        <p>{{ $project->content }}</p>

        <p>Tipo progetto: {{ $project->type?->title ?: 'Tipo non definito' }}</p>

        @if ($project->technologies->isNotEmpty())
            <ul>Tecnologie:
                @foreach ($project->technologies as $technology)
                    <li>{{ $technology->title }}</li>
                @endforeach
            </ul>
        @endif

        <a class="btn btn-primary" href="{{ route('admin.projects.index') }}">Torna alla lista progetti</a>
    </div>
@endsection
