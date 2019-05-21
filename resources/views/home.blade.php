@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach($repos as $respo)
            <div class="col-md-8">
                {{ $repo->getName }}
            </div>
        @endforeach
    </div>
</div>
@endsection
