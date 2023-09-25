
<!-- resources/views/display-text.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Book Directory</title>
    <!-- <link rel="stylesheet" href="{{asset('css/dir.css')}}"> -->
    <link rel="stylesheet" href="{{ asset('css/fonts/LucidaSans/style.css') }}">
    <style>
        .header-div{
            background: #fff;
            font-family: Montserrat, sans-serif;;
            font-size: 24px;
            line-height: 30px;
            font-weight: bold;
            color: #009688;
            padding: 40px;
            box-shadow:
	            inset #009688 0 0 0 5px, 
                inset #059c8e 0 0 0 1px, 
                inset #0cab9c 0 0 0 10px, 
                inset #1fbdae 0 0 0 11px, 
                inset #8ce9ff 0 0 0 16px, 
                inset #48e4d6 0 0 0 17px, 
                inset #e5f9f7 0 0 0 21px, 
                inset #bfecf7 0 0 0 22px;
            text-shadow: 3px 3px 1px #bfecf7;
            text-align: center;
        }

        h1{
            font-size: 50px;
        }
        .test-img {
                width: 60px;
                height: auto;
                margin-right: 10px;
            } 
        .link {
            font-size: 25px;
        }
        /* Reset some default styles for lists */
        ul {
            list-style-type: none;
            padding: 0;
        }

        /* Style for each list item */
        .list-item {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 5px;
        }

        /* Style for the links */
        .list-item a {
            text-decoration: none;
            color: #333;
        }

        /* Expand the div on hover */
        .list-item:hover {
            border-width: 2px;
            padding: 15px;
        }

        @media (max-width:1000px) {
            h1{
                font-size: 100px;
                text-align: center;
            }
            .test-img {
                width: 100px;
                height: auto;
                margin-right: 10px;
            }
            .link {
                font-size: 30px;
            }
        }
    </style>
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
                        <a href="{{ url(route('book', ['bookName' => $item['unformatted'], 'pageNumber' => 1])) }}" class="link">
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
