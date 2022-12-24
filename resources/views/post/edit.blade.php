@extends('layouts.main')

@section('content')
    <h2>Редактирование сообщений</h2>
    <form action="{{ route('post.update', $post->id) }}" method="post">
        @csrf @method('patch')
        <div class="mb-3">
            <label for="title" class="form-label">Заголовок:</label>
            <input type="text" name="title" value="{{ $post->title }}" class="form-control" id="title" placeholder="Введите заголовок">
            @error('title')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Содержимое:</label>
            <textarea name="content" class="form-control" id="content"
                      placeholder="Текст сообщения">{{ $post->content }}</textarea>
            @error('content')
            <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="text" name="image" value="{{ $post->image }}" class="form-control" id="image" placeholder="Введите адрес картинки">
        </div>
        <div class="mb-3">
            <label class="form-label">Категория:</label>
            <select name="category_id" aria-label="category_id" class="form-select form-select-lg mb-3">
                @foreach($categories as $category)
                    <option {{ $post->category->id == $category->id ? ' selected ' : '' }}
                            value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="tags">Теги:</label>
            <select multiple name="tags[]" id="tags" class="form-control">
                @foreach($tags as $tag)
                    <option
                        @foreach($post->tags as $postTag)
                            {{ !empty($postTag) && $tag->id == $postTag->id ? ' selected ' : '' }}
                        @endforeach
                        value="{{ $tag->id }}">{{ $tag->title }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
@endsection