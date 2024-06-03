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
        button {
            background-color: #cc0052;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
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
            width: 75%;
            margin: auto;
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
            justify-content: space-between;
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
        .stars {
            unicode-bidi: bidi-override;
            color: #ccc;
            font-size: 25px;
            height: 25px;
            width: 125px;
            margin: 10px 0;
            position: relative;
            padding: 0;
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
        .book-details {
            flex-grow: 1;
        }
        .checkmark {
            color: green;
            font-size: 20px;
            margin-left: 10px;
        }
        .read {
            text-decoration: line-through;
        }
    </style>
</head>
<body>
<div class="stylish-list-container">
    <ul class="stylish-list">
        <li>
            <span class="list-item-text" style="text-align:center;font-weight:700;">Summer Reading List!</span>
        </li>
        @if(empty($listItems))
            <li>
                <div class="book-details">
                    <span class="list-item-text" style="text-align:center;">Add a book to see list items here</span>
                </div>
            </li>
        @endif
        @foreach($listItems as $listItem)
            <li>
                <div class="book-details">
                    <span class="list-item-text {{ $listItem['read'] ? 'read' : '' }}">
                        {{$listItem['title']}}
                        @if($listItem['read'])
                            <span class="checkmark">&#10003;</span>
                        @endif
                    </span>
                    <div class="stars">
                        <span style="width: {{($listItem['rating'] / 10) * 100}}%;">★★★★★</span>
                    </div>
                </div>
                <div class="list-item-actions">
                    <button class="list-item-button" onclick="window.location.href='{{ url(route('reading.edit-item', ['listItemId'=>$listItem['id']])) }}'">Edit</button>
                    <button class="list-item-button">Delete</button>
                </div>
            </li>
        @endforeach
    </ul>
</div>
</body>
</html>
