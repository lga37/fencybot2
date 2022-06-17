@extends('layouts.adm')

@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => __('Inform')])



<form method="POST" action="{{ route('alert.warn') }}">
    @csrf

    <div class="form-group row">
        <label for="phone" class="col-md-2 col-form-label text-md-right">{{ __('Tel') }}</label>

        <div class="col-md-10">
            <input type="text" id="phone"
            class="form-control @error('phone') is-invalid @enderror" name="phone"
                value="{{ old('phone') }}" required autocomplete="phone" autofocus>

            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-10 offset-md-2">
            <button class="btn btn-lg btn-outline-primary">
                {{ __('Save') }}
            </button>
        </div>
    </div>
</form>

@endsection
