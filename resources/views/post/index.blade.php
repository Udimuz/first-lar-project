@extends('layouts.main')

@section('content')
    <table style="width:600px">
        <tr>
            <td><h2>Сообщения</h2></td>
            <td><a href="{{ route('post.create') }}" class="btn btn-primary">Добавить новое</a></td>
        </tr>
    </table>
    @foreach($posts as $post)
        <hr>
        <div>{{ $post->id }}. <a href="{{ route('post.show', $post->id) }}"><b>{{ $post->title }}</b></a></div>
        <div>{{ $post->content }}</div>
        <div>Категория: {{ !empty($post->category_id) ? $post->category_id." - ".$post->category->title : '' }}</div>
        @if(count($post->tags) > 0)
            <div>Теги:
                @foreach($post->tags as $postTag)
                    <a href="#">{{ $postTag->title }}</a>
                @endforeach
            </div>
        @endif
        <div>Likes: {{ $post->likes }}</div>
    @endforeach
    <div class="mt-4">{{ $posts->links() }}</div>
@endsection