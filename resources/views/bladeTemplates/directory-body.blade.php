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
