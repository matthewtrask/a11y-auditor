@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                <h1>{{ $repo->getFullName() }}</h1>
                <h3>Create Issue for Audit</h3>
                <form id="create-issue" class="create-issue" method="post" action="/{!! $repo->getName() !!}/issue/create">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-row">
                        <div class="col">
                            <label for="issue-title">Issue Title</label>
                            <input type="text" class="form-control" id="issue-title"  name="issue-title" placeholder="Issue Title">
                        </div>
                        <div class="col">
                            {{-- will be select field --}}
                            <label for="issue-project">Issue Project</label>
                            <input type="text" class="form-control" id="issue-project"  name="issue-project" placeholder="Associated Project">
                        </div>
                    </div>
                    <div class="form-row pt-4">
                        <div class="col">
                            <label for="issue-labels">Issue Tags</label>
                            <select class="form-control issue-labels" name="issue-labels[]" id="issue-labels" multiple size=5>
                                @foreach($labels as $label)
                                    <option value="{{ $label->getName() }}">{{ $label->getName() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row pt-4">
                        <label for="issue-description">Description</label>
                        <textarea name="issue-description" class="form-control" id="issue-description" cols="30" rows="10">
## Description

## Current Code

## Solution

## Suggested Code

## Affected Communities
* Vision
* Motor
* Hearing
* Cognitive

## Screenshots
If applicable, add screenshots to help explain your problem.

## Environment
- OS: [e.g. iOS]
- Browser [e.g. chrome, safari]
- Version [e.g. 22]
                        </textarea>
                    </div>
                    <div class="form-row pt-4">
                        <div class="col">
                            {{-- will be select field --}}
                            <label for="issue-milestone">Milestone</label>
                            {{--<input type="text" class="form-control" id="issue-milestone"  name="issue-milestone" placeholder="Issue Milestone">--}}
                            <select class="form-control custom-select" name="issue-milestone" id="issue-milestone">
                                @foreach($milestones as $milestone)
                                    <option value="{{ $milestone->getNumber() }}">{{ $milestone->getTitle() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-row pt-4">
                        <button class="btn btn-primary" type="submit">Save Issue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        $(".issue-labels").chosen();

        function submitForm() {
          var repo = JSON.parse('{!! json_encode($repo->getName()) !!}');
          var formData = new FormData(document.querySelector('form'));
          var request = new XMLHttpRequest();

          request.open('POST', `/${repo}/issue/create`);

          request.onreadystatechange = function() {//Call a function when the state changes.
            if(request.readyState === 4 && request.status === 200) {
              window.location.href = "/{!! json_encode($repo->getName()) !!}/issues";
            }
          };

          request.send(formData);
        }
    </script>
@endsection
