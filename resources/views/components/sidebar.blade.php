<div class='container'>
    <div>
        <h4>カテゴリーを選択</h4>        
    </div>
    @foreach($categories as $category)
    <div>
        <a href="{{ route('posts.show', $category) }}">
            {{ $category->name }}
        </a>
    </div>
    @endforeach
</div>