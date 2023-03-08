@extends('layouts.app')

@section('content')
    <div> 
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif                                          
    </div>
    <div>
    <form action="{{ route('categories.store') }}" method='post'>
        @csrf
        <div>
            <label for="content">カテゴリ追加</label>
            <input type="text" class='form-control' name='category_name'>
        </div>
        
        <button type='submit'>メッセージ投稿</button>
    </form> 
    </div>
   <div class='col-2'>
        @component('components.sidebar', ['categories' => $categories])
        @endcomponent
   </div>
    



@endsection
