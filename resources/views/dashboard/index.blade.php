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
                </div>
                <div class="form-group">
                    <button class="btn btn-success" onclick="showNewRepositoryForm()">New Repo</button>
                </div>
                <div class="row">
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
                </div>
                <div id="newRepository" class="newRepository">
                    <h2>Create New Repository In Github</h2>
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
            request.open('POST', '/repository/create');
            request.send(formData);
        }
    </script>
@endsection
