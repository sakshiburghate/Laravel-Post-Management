@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create Post</a>
    @if(session('alert-success'))
    <div class="alert alert-success">
        {{ session('alert-success') }}
    </div>
@endif
@if(session('alert-danger'))
    <div class="alert alert-danger">
        {{ session('alert-danger') }}
    </div>
@endif

    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ $post->body }}</p>
                    <p class="card-text">Author:{{ $post->author }} </p>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="mt-3">
    {{ $posts->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
