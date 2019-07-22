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
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <h2>{{ $issue->getTitle() }}</h2>
                <p><a target="_blank" href="{{ $issue->getHtmlUrl() }}">View on Github</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 pb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row"></div>
                        <p>{!! $issue->getCombinedDescription() !!}</p>
                        <div class="row">
                            <div class="col-sm">
                                <h2>Issue Labels</h2>
                            </div>
                        </div>
                        <div class="row">
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
                <button class="btn btn-primary showCommentForm" id="showCommentForm">Add Comment</button>

                <form action="/{{ $repo->getName() }}/issues/{{ $issue->getNumber() }}/comment" method="post" class="pt-2 pb-2 commentForm" id="commentForm">
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