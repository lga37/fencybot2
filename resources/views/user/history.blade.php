@extends('layouts.adm')

@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => __('Historicos/Logs')])




<table class="table table-striped table-sm">
    <tr>
        <th><input type="checkbox" class="" value="1" id="checkAll" name="checkAll">{{ __('select all')}}</th>
        <th>id</th>

        <th>{{ __('column')}}</th>
        <th>{{ __('from')}}</th>
        <th>{{ __('to')}}</th>
        <th>{{ __('at')}}</th>
        <th>{{ __('map')}}</th>


    </tr>
    @forelse ($histories as $history)
    <tr>
        <td><input type="checkbox" value="{{$history->id}}" name="ids[]"></td>
        <td>{{ $history->id }}</td>

        <td>{{ $history->changed_column ?? '-' }}</td>
        <td>{{ $history->changed_value_from ?? '-' }}</td>
        <td>{{ $history->changed_value_to ?? '-' }}</td>
        <td>{{ $history->updated_at }}</td>
        <td class="">
            <a class="btn btn-sm btn-info">{{ __('Revert')}}
            </a>
        </td>
    </tr>

    @if ($loop->last)
    <tr>
        <td colspan="2">
            <button class="btn btn-sm btn-outline-danger">{{ __('del selected')}}</button>
        </td>
        <td colspan="9"></td>
    </tr>
    @endif

    @empty
    <p><b>{{ __('No records')}}</b></p>
    @endforelse
</table>




@endsection
