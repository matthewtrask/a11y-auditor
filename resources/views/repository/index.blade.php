@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                @if(Session::has('message'))
                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
                <h1>{{ $repo->getName() }}</h1>
                <a href="{{ $repo->getGithubLink() }}">Vew on Github</a>
            </div>
        </div>
        <div class="pt-2 row justify-content-center">
            <div class="col-sm-2">
                <a href="/{{ $repo->getName() }}/issues/create">
                    <button class="btn btn-primary">Create Issue</button>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="/{{ $repo->getName() }}/edit">
                    <button class="btn btn-primary">Edit Repo</button>
                </a>
            </div>
            <div class="col-sm-8"></div>
        </div>
        <div class="pt-2 row justify-content-center">
            <div class="col">
                <h2>Issues</h2>
            </div>
        </div>
        <div class="pt-2 row">
            @if(count($issues) > 0)
                @foreach($issues as $issue)
                    <div class="col-6 pb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row"></div>
                                <h1>{{ $issue->getTitle() }}</h1>
                                <hr>
                                <p>{!! $issue->getDescription() !!}</p>
                                <div class="row">
                                    <div class="col-sm">
                                        @foreach(json_decode(json_encode($issue->getTags()), true) as $tag)
                                            <span class="badge badge-primary" style="background-color: {{ $tag['color'] }}">
                                                {{ $tag['name'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        @if($issue->getMilestone())
                                           <p>Milestone:  {{ $issue->getMilestone()['title'] }}</p>
                                        @endif
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
                <div class="col-6 pb-4">
                    <p>There are no open issues for this repository. :)</p>
                </div>
            @endif
        </div>
    </div>
@endsection