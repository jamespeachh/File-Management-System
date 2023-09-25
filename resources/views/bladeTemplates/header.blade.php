<!-- <link rel="stylesheet" href="{{asset('htmlData/templates/header.css')}}"> -->

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

<header class="site-header">
    <div class="site-identity">
        <h1><a href="{{ route('home') }}">GBIP</a></h1>
    </div>

    <nav class="site-navigation">
        <ul class="nav">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="{{route('directory')}}">Directory</a></li>
        </ul>
    </nav>
</header>
