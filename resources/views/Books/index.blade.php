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
            <div>
                <h1 class="book-title">{{$bookTitle}}:</h1>
            </div>
            <div>
                <p id="file-content">{{$fileContents}}</p>
            </div>
            <hr>
            <div id="index" class="button-container">
                <button onclick="window.location.href='{{ url($url . ($pageNum-1)) }}'" class="button-fnb">Previous Chapter</button>
                <button onclick="window.location.href='{{ url($url . ($pageNum+1)) }}'" class="button-fnb">Next Chapter</button>
            </div>
            <button onclick="topFunction()" style="padding: 10px;font-size:20px;color: black;">Scroll to top</button>
            <br>
            <br>
            @include('bladeTemplates.comments-chapter')
            <footer>I love you &lt;3</footer>
        </div>
    </div>
</body>
</html>
