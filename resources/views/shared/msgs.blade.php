@if (session('status'))
<div class="mt-2 alert alert-info" role="alert">
    {{ session('status') }}
</div>
@endif

@if (Session::has('success'))
<div class="mt-2 alert alert-success">
    <i class="fas fa-check-circle"></i> {{ __(Session::get('success')) }}
</div>
@endif

@if (Session::has('error'))
<div class="mt-2 alert alert-danger">
    <i class="fas fa-check-circle"></i> {{ Session::get('error') }}
</div>
@endif

@if ($errors->any())

<div class="mt-2 alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
