@extends('layouts.main')

@section('content')
    <h2>Новое сообщение</h2>
    <div>
        <form action="{{ route('post.store') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Заголовок:</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" id="title" placeholder="Введите заголовок">
                @error('title')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Содержимое:</label>
                <textarea name="content" class="form-control" id="content" placeholder="Текст сообщения">{{ old('content') }}</textarea>
                @error('content')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="text" name="image" class="form-control" id="image" placeholder="Введите адрес картинки">
            </div>
            <div class="mb-3">
                <label class="form-label">Категория:</label>
                <select name="category_id" aria-label="category_id" class="form-select form-select-lg mb-3">
                    @foreach($categories as $category)
                        <option
                            {{ old('category_id') == $category->id ? ' selected ' : '' }}
                            value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="tags">Теги:</label>
                <select multiple name="tags[]" id="tags" class="form-control">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Создать</button>
        </form>
    </div>
@endsection