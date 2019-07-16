@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                @if(Session::has('message'))
                    <p class="alert alert-info">{{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </p>
                @endif
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <h2>Issues</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 pb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row"></div>
                        <h3>{{ $issue->getTitle() }}</h3>
                        <p>{!! $issue->getCombinedDescription() !!}</p>
                        <div class="row">
                            <div class="col-sm">
                                @foreach(json_decode(json_encode($issue->getTags()), true) as $tag)
                                    <span class="badge badge-secondary" style="background-color: #{{ $tag['color'] }}">
                                                {{ $tag['name'] }} {{ $tag['description'] }}
                                            </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <h2>Issue Milestone</h2>
                                @if($issue->getMilestone())
                                    <p><b>Milestone</b>:  {{ $issue->getMilestone()['title'] }}</p>
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
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <h2>Comments</h2>
                <button class="btn btn-primary">Add Comment</button>

                <form action="/{{ $repo->getName() }}/issues/{{ $issue->getNumber() }}/comment" method="post" class="pt-2 pb-2">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <input type="text" name="comment" class="form-control" id="comment" aria-describedby="comment" placeholder="Comment">
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
        @foreach($comments as $comment)
            <div class="row pt-2">
                <div class="col-12 pb-4">
                    <div class="card">
                        <div class="card-body">
                            <p>{{ $comment->getBody() }}</p>
                            <p>{{ $comment->getUser() }} - {{ Carbon\Carbon::parse($comment->getPostedAt())->format('m-d-Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection