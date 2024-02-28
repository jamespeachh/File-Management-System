
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

        <div class="checkbox-wrapper-65">
            <label for="cbk1-65">
{{--                <input type="checkbox" id="cbk1-65" onclick="toggleGridLayout(), adjustItemWidth()">--}}
                <span class="cbx">
                    <svg width="12px" height="11px" viewBox="0 0 12 11">
                      <polyline points="1 6.29411765 4.5 10 11 1"></polyline>
                    </svg>
                </span>
                <span>Grid View?</span>
            </label>
        </div>
        <div class="container">
            <ul class="link-list">
                <div class="grid" id="grid">
                    @foreach($data['books'] as $item)

                        <li class="grid-item">
                            <a href="{{ url(route('book', ['bookID' => $item['id'], 'pageNumber' => 1])) }}" class="link">
                                <div class="list-item">
                                    <img src="{{ asset('BookCover/' . $item['img']['src']) }}"
                                         alt="{{$item['img']['alt']}}"
                                         class="test-img"><br>
                                    {{$item['title']}}
                                </div>
                            </a>
                        </li>
                    @endforeach

                </div>
            </ul>
        </div>
        <script src="script.js"></script>
    </div>
</div>

<script>
    @if($alertExists)
        alertExists({{$alertMessage}});
    @endif
    function alertExists(alertMessage){
        switch(alertMessage) {
            case 1:
                alert("You need to chose a book to continue!!!\nRedirecting you to selection.");
                break;
        }
    }
</script>
<script src="{{asset('htmlData/scripts/checkbox.js')}}"></script>
</body>
</html>
