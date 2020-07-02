@extends('layouts.adm')


@section('content')

@include('shared.msgs')
@include('shared.header', ['name' => 'Types'])


{{ $types }}

@endsection

@section('js')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('API_GOOGLE')}}&libraries=places" async defer></script>


<script>


    /*
    The "status" field within the search response object contains the status of the request, and may contain debugging information to help you track down why the request failed. The "status" field may contain the following values:
    OK indicates that no errors occurred; the place was successfully detected and at least one result was returned.
    ZERO_RESULTS indicates that the search was successful but returned no results. This may occur if the search was passed a latlng in a remote location.
    OVER_QUERY_LIMIT indicates that you are over your quota.
    REQUEST_DENIED indicates that your request was denied, generally because of lack of an invalid key parameter.
    INVALID_REQUEST generally indicates that a required query parameter (location or radius) is missing.
    UNKNOWN_ERROR
    */

</script>
@endsection
