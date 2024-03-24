<link rel="stylesheet" href="{{asset('htmlData/css/templates/header.css')}}">

<header class="site-header">
    <div class="site-identity">
        <h1><span onclick="switch_on_off()">Books</span></h1>
    </div>

    <nav class="site-navigation">
        <ul class="nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('directory') }}">Directory</a></li>
        </ul>
    </nav>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="switch_on_off()">&times;</a>
        <a href="{{ url(route('home')) }}">Home</a>
        <a href="{{ url(route('directory')) }}">Directory</a></br></br>
        @foreach($data['books'] as $item)
            <a href="{{ url(route('book.book', ['bookID' => $item['id']])) }}" class="link">
                {{ $item['title'] }}
            </a>
        @endforeach
    </div>

    <script src="{{asset('htmlData/scripts/header.js')}}"></script>
</header>
