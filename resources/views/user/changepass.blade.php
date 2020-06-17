@extends('layouts.adm')

@section('content')


@include('shared.msgs')
@include('shared.header', ['name' => 'Change Password'])



<form method="POST" action="{{ route('user.savepass') }}">
    @csrf
    <div class="form-group row">
        <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('New Password') }}</label>

        <div class="col-md-10">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="new-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password-confirm" class="col-md-2 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

        <div class="col-md-10">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password">

        </div>
    </div>

    <div class="form-group row mb-0">
        <div class="col-md-10 offset-md-2">
            <button class="btn btn-lg btn-outline-primary">
                Save
            </button>
        </div>
    </div>
</form>

@endsection
