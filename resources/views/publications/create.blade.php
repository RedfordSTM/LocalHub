@extends('layouts.app')

@section('title', 'Nouvelle publication')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold text-slate-900">Nouvelle publication</h1>

    <form method="post" action="{{ route('publications.store') }}" enctype="multipart/form-data"
          class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @include('publications._form', ['publication' => null])
    </form>
@endsection
