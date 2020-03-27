@extends('layouts.app')

@section('content')
<div class="container m-5">
  <a href="{{route('posts.create')}}" class="btn btn-success mb-5">Create Post</a>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Title</th>
        <th scope="col">Description</th>
        <th scope="col">User Name</th>
        <th scope="col">Created At</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($posts as $post)
      <tr>
        <th scope="row">{{ $post->id }}</th>
        <td>{{ $post->title }}</td>
        <td>{{ $post->description }}</td>
        <!-- username need to be handled somehow-->
        <!-- display id of username for now -->
        <td>{{ $post->user_id  ?  $post->user_id : 'not exist'}}</td>
        <td>{{Carbon\Carbon::parse($post->created_at)->format('Y-m-d') }}</td>
        <td>
          <a href="{{route('posts.show',['post' => $post->id])}}" class="btn btn-primary">Show</a>
        </td>
        <td><a href="/posts/{{$post->id}}/edit" class="btn btn-warning">Edit</a></td>
        <td>
          <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-id="{{$post->id}}" data-target="#dd{{$post->id}}">Delete</button>
        </td>
      </tr>
      <div id="dd{{$post->id}}" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
              <p>Be Carefull, you're about to delete this post</p>
            </div>
            <div class="modal-footer">
              <form method="POST" action="/posts/{{$post->id}}">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-primary">Yes, Delete it</button>
              </form>
              <button type="button" class="btn btn-default" data-dismiss="modal">No, keep It</button>
            </div>
          </div>
        </div>
      </div>
</div>
@endforeach
</tbody>
</table>
{{$posts->links()}}
@endsection