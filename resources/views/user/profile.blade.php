@extends('layouts.adm')

@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => 'Profile'])

<form method="POST" action="{{ route('user.update') }}">
    @csrf
    <div class="form-group row">
        <label for="name" class="col-md-2 col-form-label text-md-right">{{ __('Name') }}</label>
        <div class="col-md-10">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                value="{{ $user->name ?? old('name') }}" required autocomplete="name" autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <input type="hidden" id="code" name="code" value="1">
        <label for="tel" class="col-md-2 col-form-label text-md-right">{{ __('Tel') }}</label>

        <div class="col-md-10">
            <input id="tel" type="text" id="tel"

            class="form-control @error('tel') is-invalid @enderror" name="tel"
                value="{{ $user->tel ?? old('tel') }}" required autocomplete="tel" autofocus>

            @error('tel')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
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
<br>

@include('shared.header', ['name' => 'Change Email'])

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
                Save
            </button>
        </div>
    </div>
</form>


@endsection


@section('js')

<script>
    var input = document.querySelector("#tel");
    //var input = $("#tel");
    window.intlTelInput(input, {

        preferredCountries: ["us", "br"],
            separateDialCode: true,
            initialCountry: "br",
            separateDialCode: true,

        })
        .on('countrychange', function (e, countryData) {
            $("#code").val((
                $("#tel")
            .intlTelInput("getSelectedCountryData").dialCode));

    });
</script>

@endsection
