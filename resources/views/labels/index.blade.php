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
                <h2>Labels</h2>
                {{--<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Label</button>--}}
            </div>
        </div>
        <div class="row justify-content-center pt-4">
            @foreach($labels as $label)
                <div class="col-lg-3 pt-2 pb-2">
                    <div class="card" style="background-color: #{{ $label->color }}">
                        <div class="card-body">
                            {{ $label->getName() }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Label</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/labels/add" method="post">
                        <div class="form-group">
                                <label for="repository-name">Label</label>
                                <input type="text" name="label-name" class="form-control" id="label" aria-describedby="labelName" placeholder="Label">
                            </div>
                            <div class="form-group">
                                <select class="form-control custom-select" name="label-color" id="issue-milestone">
                                    <option value="d0ffad">Green</option>
                                    <option value="077b9e">Blue</option>
                                    <option value="ea98e1">Purple</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script type="text/javascript"></script>
@endsection