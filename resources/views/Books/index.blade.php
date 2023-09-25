<!DOCTYPE html>
<html>
<head>


<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=REM&family=Wavefont:wght@200&display=swap" rel="stylesheet">



    <title>{{$bookTitle}}</title>
    <style>
        h1{
            font-size: 100px;
            text-align: center;
        }
        .text-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: fit-content; /* Set the height of the container to fill the viewport */
            background-color: #f1f1f1;
        }

        .text-content {
            max-width: 90%;
            white-space: pre-wrap; /* Preserve line breaks and wrap long lines */
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        #file-content{
            font-family: 'REM', sans-serif;
            font-size: 15pt;
            white-space: pre-wrap;
            padding: 27px;
        }
        footer{
            font-family: 'REM', sans-serif;
        }

        .button-container {
            font-family: 'REM', sans-serif;
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }
        .button-fnb {
            color: black;
            border-radius: 15px;
            background-color: light-grey;
            width: 200px;
            height: 100px;
        }
        @media (max-width:1000px) {
            #file-content{
                font-family: 'REM', sans-serif;
                font-size: 35px;
                color: #2E2E2E;
                white-space: pre-wrap;
                padding: 22px;
            }
        }

    </style>




</head>
<body>

@include('bladeTemplates.header')
<!-- @include('bladeTemplates.progressbar') -->
<!-- <div class="text-container"> -->
    <!-- <div class="text-content"> -->
        <div>
            <h1>{{$bookTitle}}:</h1>
        </div>
        <div>
            <p id="file-content">{{$fileContents}}</p>
        </div>
        <div id="index" class="button-container">
            <button onclick="window.location.href='{{ url($url . ($pageNum-1)) }}'" class="button-fnb">Previous Chapter</button>
            <button onclick="window.location.href='{{ url($url . ($pageNum+1)) }}'" class="button-fnb">Next Chapter</button>
        </div>
        <br>
        <br>
        <footer>I love you &lt;3</footer>
    <!-- </div> -->
<!-- </div> -->
</body>
</html>
