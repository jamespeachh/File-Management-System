<!DOCTYPE html>
<html>
<head>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=REM&family=Wavefont:wght@200&display=swap" rel="stylesheet">



    <title>{{$bookTitle}}</title>
    <link rel="stylesheet" href="{{ asset('htmlData/css/books.css') }}">

</head>
<body>
    @include('bladeTemplates.header')
    <div class="text-container">
        <div class="text-content">
{{--            @include('bladeTemplates.chapter-select')--}}
            <a href="{{ url(route('book', ['bookID'=>$bookID,'pageNumber'=>$pageNum, 'reported'=>1])) }}">
                Report page
            </a>
            @if(request()->has('reported'))
                <p>Thank you for reporting this page!  I will look into it.  If you want to help, leave a comment!</p>
            @endif
            <div>
                <h1 class="book-title">{{$bookTitle}}:</h1>
            </div>
            <div>
                <p id="file-content">{{$fileContents}}</p>
            </div>
            <hr>
            <div id="index" class="button-container">
                <button onclick="window.location.href='{{ url($url . '&pageNumber=' . ($pageNum - 1)) }}'" class="button-fnb">Previous Chapter</button>
                <button onclick="window.location.href='{{ url($url .'&pageNumber=' . ($pageNum + 1)) }}'" class="button-fnb">Next Chapter</button>
            </div>
            <button onclick="topFunction()" style="padding: 10px;font-size:20px;color: black;">Scroll to top</button>
            <br>
            <br>
            @include('bladeTemplates.comments-chapter')
{{--            <footer>I love you &lt;3</footer>--}}
        </div>
    </div>
<script>
    function topFunction() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Optional: smooth scrolling behavior
        });
    }
</script>
</body>
</html>
