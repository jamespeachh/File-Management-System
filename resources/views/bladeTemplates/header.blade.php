<style>
    .header_body {
        font-family: Helvetica, serif;
        margin: 0;
    }
    a {
        text-decoration: none;
        color: #000;
    }
    .site-header {
        border-bottom: 2px solid #ccc;
        padding: .5em 1em;
        display: flex;
        justify-content: space-between;
    }

    .site-identity h1 {
        font-size: 40px;
        margin: .6em 0;
        display: inline-block;
        border-style: double;
        padding: 3px;
    }


    .site-navigation ul,
    .site-navigation li {
        margin: 0;
        font-size: 25px;

    }

    .site-navigation li {
        display: inline-block;
        margin: 1.4em 1em 1em 1em;
        padding: 3px;
        border-style: double;
    }
</style>

<style>
    span {
        cursor: pointer;
    }
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }
    
    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }
    
    .sidenav a:hover {
        color: #f1f1f1;
    }
    
    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }
    
    @media (max-width:1000px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 40px;}
        .closebtn {opacity: 0;}
    }
</style>

<header class="site-header">
    <div class="site-identity">
        <h1><span onclick="switch_on_off()">GBIP</span></h1>
    </div>

    <nav class="site-navigation">
        <ul class="nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{ route('directory') }}">Directory</a></li>
        </ul>
    </nav>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ url(route('home')) }}">Home</a>
        <a href="{{ url(route('directory')) }}">Directory</a></br></br>
        @foreach($data['books'] as $item)
            <a href="{{ url(route('book', ['bookName' => $item['unformatted'], 'pageNumber' => 1])) }}" class="link">
                {{ $item['title'] }}
            </a>
        @endforeach
    </div>


    <script>
        var on_off = false;
        var sidenav = document.querySelector(".sidenav");
        var dir_button = document.querySelector("span");

        function switch_on_off() {
            if (on_off == false){
                on_off = true;
                openNav();
            }else {
                on_off = false;
                closeNav();
            }
        }
        function openNav() {
          document.getElementById("mySidenav").style.width = "250px";
        }
        
        function closeNav() {
          document.getElementById("mySidenav").style.width = "0";
        }

        document.onclick = function(e){
            if (on_off == true && !sidenav.contains(e.target) && !dir_button.contains(e.target)) switch_on_off();
        }
    </script>
</header>
