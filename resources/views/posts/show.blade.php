@extends('layouts.app')

@section('content')
<div class="container">
  <div class="card mt-5">
  <div class="card-header">
    Post Info
  </div>
    <div class="card-body">
      <p class="card-title"><b>Title: </b>{{$post->title}}</p>
      <p class="card-text"><b>Description:</b> {{$post->description}}</p>
      <p>
    </div>
  </div>
  <div class="card mt-5">
  <div class="card-header">
    User Info
  </div>
    <div class="card-body">
      <p><b>Name:</b> {{$post->user->name ? $post->user->name : "not exist"}} </p>
      <p><b>e-mail:</b> {{$post->user->email}} </p>
      <p><b>At:</b> {{$post->created_at->format('l jS \\of F Y h:i:s A')}} </p>
    </div>
  </div>
</div>

@endsection