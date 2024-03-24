
<!-- resources/views/display-text.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Book Directory</title>
    <link rel="stylesheet" href="{{asset('htmlData/css/dir.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
@include('bladeTemplates.header')
<div class="text-container">
    <div class="text-content">
        <div class="header-div">
            <h1>Pick a Book</h1>
        </div>
        @include("bladeTemplates.category-select")
        <div class="container">
            <ul class="link-list">
                <div class="grid" id="grid">
                    @foreach($data['books'] as $item)

                        <li class="grid-item">
                            <a href="{{ url(route('book.book', ['bookID' => $item['id']])) }}" class="link">
                                {{$item['id']}}
                                {{url(route('book.book', ['bookID' => $item['id']]))}}
                                <div class="list-item">
                                    <img src="{{ asset('BookCover/' . $item['img']['src']) }}"
                                         alt="{{$item['img']['alt']}}"
                                         class="test-img">{{--<br>--}}
                                    {{$item['title']}}
                                    test
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
            case 2:
                alert("No books in that category:<\nPick another or view all books.");
                break;
        }
    }
</script>
</body>
</html>
