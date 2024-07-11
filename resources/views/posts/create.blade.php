@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            {{ isset($post) ? 'Edit Post' : 'Create New Post' }}
        </div>
        <div class="card-body">
            <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST">
                @csrf
                @isset($post)
                    @method('PUT')
                @endisset
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title ?? '') }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="body">Description</label>
                    <textarea class="form-control @error('body') is-invalid @enderror" id="body" name="body">{{ old('body', $post->body ?? '') }}</textarea>
                    @error('body')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update' : 'Create' }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
