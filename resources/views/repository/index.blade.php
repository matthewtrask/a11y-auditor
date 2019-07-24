@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                @if(Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <h1>{{ $repo->getName() }}</h1>
                <a target="_blank" href="{{ $repo->getGithubLink() }}">Vew on Github</a>
            </div>
        </div>
        <div class="pt-2 row justify-content-center">
            <div class="col-sm-2">
                <a href="/{{ $repo->getName() }}/issues/create">
                    <button class="btn btn-primary">Create Issue</button>
                </a>
            </div>
            {{--<div class="col-sm-2">--}}
                {{--<a href="/{{ $repo->getName() }}/edit">--}}
                    {{--<button class="btn btn-primary">Edit Repo</button>--}}
                {{--</a>--}}
            {{--</div>--}}
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
                                <p>{!! $issue->getCombinedDescription() !!}</p>
                                <hr>
                                <div class="row">
                                    <div class="col-sm">
                                        <h2>Issue Labels</h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                        @foreach(json_decode(json_encode($issue->getTags()), true) as $tag)
                                            <div class="col-1">
                                                <h4>
                                                    <span class="badge badge-secondary" style="background-color: #{{ $tag['color'] }}">
                                                        {{ $tag['name'] }}
                                                    </span>
                                                </h4>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm">
                                        <h2>Issue Milestone</h2>
                                        @if($issue->getMilestone())
                                           <p><b>Milestone</b>:  {{ $issue->getMilestone()['title'] }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row pt-4">
                                    <div class="col-sm-2">
                                        <form action="/{{ $repo->getName() }}/issues/{{ $issue->getNumber() }}/close" method="post">
                                            <button type="submit" class="btn btn-danger">Close</button>
                                        </form>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="/{{ $repo->getName() }}/issues/{{ $issue->getNumber() }}"><button class="btn btn-primary">View Issue</button></a>
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