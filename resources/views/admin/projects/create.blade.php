@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="header-page d-flex justify-content-between align-items-center mb-4">
            <h2>Crea un nuovo progetto</h2>
        </div>
        <a class="btn btn-light" href="{{ route('admin.projects.index') }}">Torna alla lista progetti</a>

        @include('shared.errors')

        <form action="{{ route('admin.projects.store') }}" method="POST">
            @csrf
            {{-- TITOLO --}}
            <div class="mb-3">
                <label for="project-title" class="form-label">Titolo progetto</label>
                <input type="text" class="form-control" id="project-title" name="title">
            </div>
            {{-- CONTENUTO --}}
            <div class="mb-3">
                <label for="project-content" class="form-label">Contenuto del progetto</label>
                <textarea class="form-control" id="project-content" rows="5" name="content"></textarea>
            </div>
            {{-- TIPO --}}
            <div class="mb-3">
                <label for="project-type" class="form-label">Tipo del progetto - {{ old('type_id') }}</label>
                <select class="form-select" id="project-type" aria-label="Default select example" name="type_id">
                    <option value="">Seleziona Tipo</option>
                    <@foreach ($types as $type)
                        <option value="{{ $type->id }}" @if (old('type_id') == $type->id) selected @endif>
                            {{ $type->title }}</option>
                        @endforeach
                </select>
            </div>
            {{-- TECNOLOGIE --}}
            <div class="mb-3">
                <label for="project-content" class="form-label me-2">Tecnologie del progetto:</label>
                @foreach ($technologies as $technology)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="technology-{{ $technology->id }}"
                            value="{{ $technology->id }}" name="technologies[]"
                            {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="technology-{{ $technology->id }}">{{ $technology->title }}</label>
                    </div>
                @endforeach
            </div>

            <button class="btn btn-primary">Crea nuovo progetto</button>
        </form>
    </div>
@endsection
