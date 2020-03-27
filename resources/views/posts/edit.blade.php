@extends('layouts.app')

@section('content')
<p>Hi {{$user->name}}, <br> Edit your Post title and description</p>
<form method="POST" action="{{route('posts.update',['post' => $post->id])}}">
    @csrf
    @method('put')
    <div class="form-group">
      <label >Title</label>
      <input name="title" value="{{$post->title}}" type="text" class="form-control" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
      <label for="{{$post->description}}">Description</label>
      <textarea name="description" class="form-control" value="">
          {{$post->description}}
      </textarea>
    </div>
    <div class="form-group">
      <label for="{{$user->name}}">Users</label>
      <select name="user_id" class="form-control">
          <option value="{{$user->id}}">{{$user->name}}</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">update</button>
  </form>
@endsection