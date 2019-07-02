@if(count($topics))
  <ul class="list-unstyled">
    @foreach($topics as $topic)
      <li class="media">
        <div class="media-left">
          <a href="{{ route('users.show', [$topic->user_id]) }}">
            <img src="{{ $topic->user->avatar }}" alt="头像" title="{{ $topic->user->name }}"
                 style="width: 52px; height: 52px;" class="media-object img-thumbnail mr-3">
          </a>
        </div>

        <div class="media-body">
          {{-- 标题和回复数--}}
          <div class="media-heading mt-0 mb-1">
            <a href="{{ route('topics.show', [$topic->id]) }}" title="{{ $topic->title }}">
              {{ $topic->title }}
            </a>
            <a href="{{ route('topics.show', [$topic->id]) }}" class="float-right">
              <span class="badge badge-secondary badge-pill">{{ $topic->reply_count }}</span>
            </a>
          </div>

          {{-- --}}
          <small class="media-body meta text-secondary">
            <a href="{{ route('categories.show', [$topic->category_id]) }}" title="{{ $topic->category->name }}" class="text-secondary">
              <i class="far fa-folder"></i>
              {{ $topic->category->name }}
            </a>
            <span> · </span>
            <a href="{{ route('users.show', [$topic->user->id]) }}" title="{{ $topic->user->name }}"
               class="text-secondary">
              <i class="far fa-user"></i>
              {{ $topic->user->name }}
            </a>
            <span> · </span>
            <i class="far fa-clock"></i>
            <span class="timeago"
                  title="最后活跃于: {{ $topic->updated_at }}">{{ $topic->updated_at->diffForHumans() }}</span>
          </small>

        </div>
      </li>

      @if( ! $loop->last)
        <hr>
      @endif
    @endforeach
  </ul>
@else
  <div class="empty-block">暂无数据 ~_~</div>
@endif
