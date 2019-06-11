@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                @if(Session::has('message'))
                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <h2>Milestones for {{ $repo }}</h2>
                <p><a href="/{{ $repo }}">Back to Repository Page</a></p>
            </div>
        </div>
        <div class="row justify-content-center pt-4">
            @foreach($milestones as $milestone)
                <div class="col-lg-6 pt-2 pb-2">
                    <div class="card">
                        <div class="card-body">
                            <h2>{{ $milestone->getTitle() }}</h2>
                            <p>{{ $milestone->getDescription() }}</p>
                            <p>Open Issues: <span class="badge badge-secondary">{{ $milestone->getOpenIssues() }}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection