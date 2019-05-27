@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm">
                @if(Session::has('message'))
                    <p class="alert alert-info">{{ Session::get('message') }}</p>
                @endif
                <div>
                    <h2>Repositories</h2>
                    <p>Repository Count: {{ count($repos) }}</p>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" onclick="showNewRepositoryForm()">New Repo</button>
                </div>
                <div id="newRepository" class="newRepository pt-4 pb-4">
                    <fieldset>
                        <h3>Create New Repository In Github</h3>
                        <form id="newRepositoryForm">
                            <div class="form-group">
                                <label for="repository-name">Repository Name</label>
                                <input type="text" name="repository-name" class="form-control" id="repository-name" aria-describedby="repositoryNameHelp" placeholder="Repository Name">
                            </div>
                            <div class="form-group">
                                <label for="repository-description">Repository Description</label>
                                <input type="text" name="repository-description" class="form-control" id="repository-description" aria-describedby="repositorDescriptionHelp" placeholder="Repository Description">
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                            <button type="button" class="btn btn-primary" onclick="createNewRepository(); return false;">Save</button>
                        </form>
                    </fieldset>
                </div>
                <div class="row">
                    @if(count($repos) > 0)
                        @foreach($repos as $repo)
                            <div class="col-6 pb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row"></div>
                                        <a href="/{{ $repo->getName() }}"><h3>{{ $repo->getName() }}</h3></a>
                                        <p><span class="badge badge-primary">Open Issues: {{$repo->getIssueCount()}}</span></p>
                                        <p>{{ $repo->getDescription() }}</p>
                                        <div class="row">
                                            <div class="col-sm">
                                                <a href="/{{ $repo->getName() }}"><button class="btn btn-primary">View Details</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-6 pb-4">
                            <p>No repositories have been created yet.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>

        function goToRepository() {
            document.getElementById('repository-select').onchange = function() {
                window.location.href = this.children[this.selectedIndex].getAttribute('href');
            };
        }

        function showNewRepositoryForm() {
            return document.getElementById('newRepository').style.display = 'block';
        }

        function createNewRepository() {
            var formData = new FormData(document.querySelector('form'));
            var request = new XMLHttpRequest();
            request.open('POST', '/repository/create', true);

            request.onreadystatechange = function() {//Call a function when the state changes.
                if(request.readyState === 4 && request.status === 200) {
                  location.reload();
                }
            };

            request.send(formData);
        }
    </script>
@endsection
