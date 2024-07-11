@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST">
        @csrf
        @isset($post)
            @method('PUT')
        @endisset
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title ?? '') }}">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea class="form-control" id="body" name="body">{{ old('body', $post->body ?? '') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update' : 'Create' }}</button>
    </form>
</div>
@endsection
