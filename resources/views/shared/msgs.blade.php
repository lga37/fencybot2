@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif

@if (Session::has('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ Session::get('success') }}
</div>
@endif

@if (Session::has('errors'))
<div class="alert alert-danger">
    <i class="fas fa-check-circle"></i> {{ Session::get('errors') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger">
    <i class="fas fa-check-circle"></i> {{ Session::get('error') }}
</div>
@endif

@if ($errors->any())
<div class=”alert alert-danger”>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

