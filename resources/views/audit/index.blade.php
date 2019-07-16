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
                                    <option value="{{ $label->getName() }}">{{ $label->getName() }} {{ $label->getDescription() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row pt-4">
                        <label for="issue-description">Description</label>
                        <textarea name="issue-description" class="form-control" id="issue-description" cols="30" rows="10">
## Description

                        </textarea>
                    </div>
                    <div class="form-row pt-4">
                        <label for="issue-current-code">Current Code</label>
                        <textarea name="issue-current-code" class="form-control" id="issue-current-code" cols="30" rows="10">
## Current Code

                        </textarea>
                    </div>
                    <div class="form-row pt-4">
                        <label for="issue-solution">Issue Solution</label>
                        <textarea name="issue-solution" class="form-control" id="issue-solution" cols="30" rows="10">
## Solution

                        </textarea>
                    </div>
                    <div class="form-row pt-4">
                        <label for="issue-suggested-code">Suggested Code</label>
                        <textarea name="issue-suggested-code" class="form-control" id="issue-suggested-code" cols="30" rows="10">
### Suggested Code

                        </textarea>
                    </div>
                    <div class="form-row pt-4">
                        <label for="issue-affected-communities">Affected Communities</label>
                        <textarea name="issue-affected-communities" class="form-control" id="issue-affected-communities" cols="30" rows="10">
## Affected Communities
* Vision
* Motor
* Hearing
* Cognitive

                        </textarea>
                    </div>
                    <div class="form-row pt-4">
                        <label for="issue-environment">Environment</label>
                        <textarea name="issue-environment" class="form-control" id="issue-environment" cols="30" rows="10">
## Environment
- OS: [e.g. iOS]
- Browser [e.g. chrome, safari]
- Version [e.g. 22]

                        </textarea>
                    </div>
                    <div class="form-row pt-4">
                        <div class="col">
                            <label for="issue-milestone">Milestone</label>
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
