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


@endsection
