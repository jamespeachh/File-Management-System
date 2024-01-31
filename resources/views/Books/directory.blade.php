
<!-- resources/views/display-text.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Book Directory</title>
    <link rel="stylesheet" href="{{asset('htmlData/css/dir.css')}}">
</head>
<body>
@include('bladeTemplates.header')
<div class="text-container">
    <div class="text-content">
        <div class="header-div">
            <h1>Pick a Book :3</h1>
        </div>
        <div>
            <ul class="link-list">
                @foreach($data['books'] as $item)
                    <li>
                        <a href="{{ url(route('book', ['bookName' => $item['unformatted']])) }}" class="link">
                        <div class="list-item">
                            <img src="{{ asset('BookCover/' . $item['img']['src']) }}"
                                alt="{{$item['img']['alt']}}"
                                class="test-img">
                            {{$item['title']}}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</body>
</html>
