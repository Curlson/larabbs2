@extends('layouts.app')

@section('styles')
  <link rel="stylesheet" href="text/css" href="{{ asset('css/simditor.css') }}">
@stop

@section('content')

  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card ">

        <div class="card-body">
          <h2>
            <i class="far fa-edit"></i>
            @if($topic->id)
              编辑话题
            @else
              新建话题
            @endif
          </h2>

          <hr>

          @if($topic->id)
            <form action="{{ route('topics.store', $topic->id) }}" method="POST" accept-charset="UTF-8">
              <input type="hidden" name="_method" value="PUT">
              @else
                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                  @endif

                  @include('shared._error')

                  {{ csrf_field() }}

                  <div class="form-group">
                    <input class="form-control" type="text" name="title"
                           value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required/>
                  </div>

                  <div class="form-group">
                    <select name="category_id" required class="form-control">
                      <option value="" hidden disabled selected>请选择分类</option>
                      @foreach($categories as $category)
                        <option value="{{ $category->id }}"> {{ $category->name }} </option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <textarea name="body" id="editor" rows="6" class="form-control" placeholder="请填入至少三个字符的内容."
                              required>
                      {{ old('body', $topic->body) }}
                    </textarea>
                  </div>

                  <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">
                      <i class="far fa-save mr-2" aria-hidden="true"></i>
                      保存
                    </button>
                  </div>
                </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

  <script>
    $(document).ready(function() {
      var editor = new Simditor({
        textarea: $('#editor'),
      });
    });
  </script>
@stop
