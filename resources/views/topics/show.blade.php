@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->excerpt)
@section('content')

  <div class="row">
    {{-- 左侧头像部分 --}}
    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
      <div class="card">
        <div class="card-body">
          <div class="text-center">
            作者: {{ $topic->user->name }}
          </div>
          <hr>
          <div class="media">
            <div align="center">
              <a href="{{ route('users.show', $topic->user->id) }}">
                <img src="{{ $topic->user->avatar }}" alt="头像" width="300px" height="300px" class="thumbnail img-fluid">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- 右侧内容 --}}
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
      <div class="card">
        <div class="card-body">
          <h1 class="text-center mt-3 mb-3">
            {{ $topic->title }}
          </h1>

          <div class="article-meta text-center text-secondary">
            {{ $topic->created_at->diffForHumans() }}
            ·
            <i class="far fa-comment"></i>
            {{ $topic->reply_count }}
          </div>

          <div class="topic-body mt-4 mb-4">
            {!! $topic->body !!}
          </div>

          <div class="operate">
            <hr>
            <a href="{{ route('topics.edit', $topic->id) }}" role="button" class="btn btn-outline-secondary btn-sm">
              <i class="far fa-edit"></i> 编辑
            </a>

            <form action="{{ route('topics.destroy', $topic->id) }}" class="d-inline-block" method="POST" accept-charset="UTF-8" onsubmit="return confirm('确定要删除吗?')">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button type="submit" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-trash-alt"></i> 删除
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>

@endsection
