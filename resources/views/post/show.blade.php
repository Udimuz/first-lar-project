@extends('layouts.main')

@section('content')
    <div><a href="{{ route('post.index') }}">Все сообщения</a></div>
    <div>
        <div>{{ $post->id }}. <b>{{ $post->title }}</b></div>
        <div>{{ $post->content }}</div>
        <div>Категория: {{ $post->category_id }} {{ !empty($category) ? "- ".$category->title : "" }}</div>
        <div>Теги:
            @foreach($post->tags as $postTag)
                <a href="#">{{ $postTag->title }}</a>
            @endforeach
        </div>
        <div>Likes: {{ $post->likes }}</div>
    </div>
    <div><a href="{{ route('post.edit', $post->id) }}">Изменить</a></div>
    <form style="margin-top:15px" action="{{ route('post.delete', $post->id) }}" method="post">
        @csrf @method('delete')
        <input type="submit" class="btn btn-danger" value="Delete">
    </form>
@endsection