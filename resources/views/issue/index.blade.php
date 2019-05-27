@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                @if(Session::has('message'))
                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
                <h1>{{ $repo->getName() }}</h1> | <p>Open Issues: {{ count($issues) }}</p>
                <a href="{{ $repo->getGithubLink() }}">Vew on Github</a>
                <button class="btn btn-primary">Create Issue</button>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <h2>Issues</h2>
            </div>
        </div>
        <div class="row">
            @if(count($issues) > 0)
                @foreach($issues as $issue)
                    <div class="col-6 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row"></div>
                                <h3>{{ $issue->getTitle() }}</h3>
                                <p>{!! $issue->getDescription() !!}</p>
                                <div class="row">
                                    <div class="col-sm">
                                        @foreach(json_decode(json_encode($issue->getTags()), true) as $tag)
                                            <span class="badge badge-secondary" style="background-color: {{ $tag['color'] }}">
                                                {{ $tag['name'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        {{--                                    {{ dump(json_decode(json_encode($issue)), true) }}--}}
                                        {{--@if($issue->getMilestone())--}}
                                        {{--@foreach(json_decode(json_encode($issue->getMilestone()), true) as $data)--}}
                                        {{--@foreach($data as $milestone)--}}
                                        {{--@endforeach--}}
                                        {{--@endforeach--}}
                                        {{--@endif--}}
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-sm">
                                        <a href="/{{ $repo->getName() }}/issue/{{ $issue->getNumber() }}"><button class="btn btn-primary">Edit</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>There are no issues for this repository :)</p>
            @endif
        </div>
    </div>
@endsection