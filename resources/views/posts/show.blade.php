@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->body }}</p>
            <p><strong>Author:</strong> {{ $post->author }}</p>
           <p><strong>Slug:</strong> {{ $post->slug }}</p>
  
            <a href="{{ route('posts.index') }}" class="btn btn-primary">Back to Posts</a>
        </div>
    </div>
</div>
@endsection
