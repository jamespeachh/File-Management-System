<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stylish List</title>
    <style>
        input[type="text"],
        textarea,
        select {
            width: calc(100% - 12px);
            padding: 5px;
            border: 1px solid #cc0052;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        textarea {
            resize: vertical;
        }
        input[type="checkbox"] {
            margin-right: 5px;
        }
        input[type="range"] {
            width: 100%;
        }
        .stars span {
            display: block;
            left: 0;
            overflow: hidden;
            position: absolute;
            top: 0;
        }
        .stars span:before {
            content: "★★★★★";
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            color: gold;
            text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; /* Black border */
        }
        button {
            background-color: #cc0052;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #99003d;
        }

        /* Stylish List */
        .stylish-list-container {
            background-color: #fff;
            border: 2px solid #cc0052;
            border-radius: 15px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #800000;
        }
        .stylish-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .stylish-list li {
            background-color: #ffe6e6;
            border: 1px solid #cc0052;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .stylish-list li:last-child {
            margin-bottom: 0;
        }
        .list-item-text {
            flex-grow: 1;
        }
        .list-item-actions {
            display: flex;
            gap: 5px;
        }
        .list-item-button {
            background-color: #cc0052;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
        }
        .list-item-button:hover {
            background-color: #99003d;
        }
    </style>
</head>
<body>
<div class="stylish-list-container">
    <ul class="stylish-list">
        <li>
            <span class="list-item-text" style="text-align:center;font-weight:700;">Summer Reading List!</span>
        </li>
        @foreach($listItems as $listItem)
            <li>
                <span class="list-item-text">{{$listItem['title']}}</span>
                <div class="list-item-actions">
                    <button class="list-item-button" onclick="window.location.href='{{ url(route('reading.edit-item', ['listItemId'=>$listItem['id']])) }}'">Edit</button>
                    <button class="list-item-button">Delete</button>
                </div>
            </li>
        @endforeach
{{--        <li>--}}
{{--            <span class="list-item-text">Item 1</span>--}}
{{--            <div class="list-item-actions">--}}
{{--                <button class="list-item-button" onclick="window.location.href='{{ url(route('reading.edit-item', ['listItemId'=>2])) }}'">Edit</button>--}}
{{--                <button class="list-item-button">Delete</button>--}}
{{--            </div>--}}
{{--        </li>--}}
    </ul>
</div>
</body>
</html>
