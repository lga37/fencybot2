@extends('layouts.adm')

@section('content')

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
</div>
@endif




<h1>Devices para usuario </h1>
<table class="table table-striped">
    <tr>
        <th>add</th>
        <th>
            <form method="POST" action="{{ route('device.store') }}">
                @csrf
                <select name="fences_id[]" class="form-control rounded-lg border border-secondary selectpicker"
                    multiple>
                    <option selected disabled>Selecione</option>
                    @forelse ($fences as $fence)
                    <option value="{{ $fence->id }}">{{ $fence->name }} </option>
                    @empty
                    @endforelse
                </select>
        </th>

        <th class="">
            <input type="text" name="name" class="form-control">
        </th>
        <th><input type="text" name="tel" class="form-control"></th>
        <th><input type="text" name="d" value="1" class="form-control"></th>
        <th><input type="text" name="r" value="10" class="form-control"></th>
        <th colspan="4" class="">
            <button class="btn btn-block btn-outline-success">add</button>
            </form>
        </th>
    </tr>
    <tr>
        <th>id</th>
        <th>cerca assoc</th>
        <th>name</th>
        <th>tel</th>
        <th>d</th>
        <th>r</th>
        <th>upd</th>
        <th>del</th>
        <th>get</th>
        <th>map</th>
    </tr>

    @forelse ($devices as $device)

    <tr class="">
        <td class="">{{ $device->id }}</td>
        <td class="">
            <form method="POST" action="{{ route('device.update',['device'=>$device->id]) }}">
                @method('PUT')
                @csrf
                <select name="fences_id[]" class="form-control border border-info selectpicker" multiple>
                    <?php
                    foreach ($fences as $fence):
                        $sel = '';
                        if(isset($device->fences)){
                            $sel = in_array($fence->id,$device->fences->pluck('id')->toArray())? 'selected':'';
                        }
                        echo sprintf("<option %s value='%d'>%s</option>",$sel,$fence->id,$fence->name);
                    endforeach;
                    ?>
                </select>
        </td>
        <td class="">
            <input type="text" name="name" value="{{ $device->name }}" class="form-control">
        </td>
        <td class="">
            <input type="text" name="tel" value="{{ $device->tel }}" class="form-control">
        </td>
        <td class="">
            <input type="text" name="d" value="{{ $device->d }}" class="form-control">
        </td>
        <td class="">
            <input type="text" name="r" value="{{ $device->r }}" class="form-control">
        </td>

        <td class="">
            <button class="btn btn-info">upd</button>
            </form>
        </td>

        <td class="">
            <form method="POST" action="{{ route('device.destroy',['device'=>$device]) }}">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger">del</button>
            </form>
        </td>
        <td>
            <a target="_blank" href="{{ route('fence.get',['tel'=>$device->tel]) }}"
            class="btn btn-warning">get</a>
        </td>
        <td>
            <a target="_blank" href="{{ route('device.show',['device'=>$device]) }}"
            class="btn btn-primary">map</a>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9">Nenhum Registro</td>
    </tr>
    @endforelse

</table>


<h1>Combinacoes - Devices registrados </h1>

<table class="table table-striped">
    <tr>
        <th>id</th>
        <th>fence</th>
        <th>device</th>
        <th>alerts</th>
        <th>del</th>
    </tr>
    @forelse ($fencedevices as $fencedevice)
    <tr class="hover:bg-gray-700 border-b border-gray-200">
        <td class="">{{ $fencedevice->id }} </td>

        <td class="">{{ $fencedevice->fence->name ?? '' }} </td>
        <td class="">{{ $fencedevice->device->name ?? '' }} </td>

        <td class="">-- nao tem mais fencedevice_id</td>

        <td class="">
            <form method="POST" action="{{ route('fencedevice.destroy',['fencedevice'=>$fencedevice]) }}">
                @method('DELETE')
                @csrf
                <button class="btn btn-danger">del</button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9">Nenhum Registro</td>
    </tr>
    @endforelse

</table>


<div class="card-deck">
    <div class="card">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
    <div class="card">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
    <div class="card">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
      </div>
    </div>
  </div>

  <div class="card border-success mb-3" style="max-width: 18rem;">
    <div class="card-header bg-transparent border-success">Header</div>
    <div class="card-body text-success">
      <h5 class="card-title">Success card title</h5>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    </div>
    <div class="card-footer bg-transparent border-success">Footer</div>
  </div>




@endsection
