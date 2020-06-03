@extends('layouts.adm')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<h2 class="shadow p-3 m-3 bg-white rounded-lg border border-info rounded">Telegram </h2>


@endsection
