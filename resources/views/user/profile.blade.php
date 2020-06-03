@extends('layouts.adm')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

<h1>Usuario </h1>

<form method="POST" action="{{ route('user.update') }}">
    @csrf
    <div class="form-group row">
        <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>
        <div class="col-md-10">
            <input id="name" type="text"
            class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ $user->name ?? old('name') }}" required autocomplete="name" autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="tel" class="col-md-2 col-form-label text-md-right">{{ __('Tel') }}</label>

        <div class="col-md-10">
            <input id="tel" type="text" class="form-control @error('tel') is-invalid @enderror" name="tel"
                value="{{ $user->tel ?? old('tel') }}" required autocomplete="tel" autofocus>

            @error('tel')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="chat_id" class="col-md-2 col-form-label text-md-right">chat_id</label>
        <div class="col-md-10">
            <input id="chat_id" type="text" class="form-control @error('chat_id') is-invalid @enderror" name="chat_id"
                value="{{ $user->chat_id ?? old('chat_id') }}" required autocomplete="chat_id">

            @error('chat_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-10 offset-md-2">
            <button class="btn btn-lg btn-outline-primary">
                {{ __('Register') }}
            </button>
        </div>
    </div>
</form>

<h1>Change Email </h1>

<form method="POST" action="{{ route('user.emailchange') }}">
    @csrf

    <div class="form-group row">
        <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

        <div class="col-md-10">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ $user->email ?? old('email') }}" required autocomplete="email">

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="form-group row mb-0">
        <div class="col-md-10 offset-md-2">
            <button class="btn btn-lg btn-outline-primary">
                {{ __('Register') }}
            </button>
        </div>
    </div>
</form>


@endsection
