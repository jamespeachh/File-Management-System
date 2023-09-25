<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <ul>
        @foreach($data['books'] as $item)
            <li>
                <a href="{{ url(route('book', ['bookName' => $item['unformatted'], 'pageNumber' => 1])) }}" class="link">
                <div class="list-item">
                    <img src="{{ $item['img']['src']}}"
                        alt="{{$item['img']['alt']}}"
                        class="test-img">
                    {{$item['title']}}
                </div>
            </li>
        @endforeach
    </ul>
</body>
</html>
