@extends('layouts.app')

@section('title', 'Modifier la publication')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-slate-900">Modifier la publication</h1>

    <form method="post" action="{{ route('publications.update', $publication) }}" enctype="multipart/form-data"
          class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('publications._form', ['publication' => $publication])
    </form>
@endsection
