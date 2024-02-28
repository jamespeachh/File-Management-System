<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>test</title>
</head>
<body>
<form id="myForm">
    <label for="name">Name:</label>
    <select id="name" name="name">
        @foreach(\Illuminate\Support\Facades\Cache::get('testiesss') as $item)
            <option value="{{$item['id']}}">{{$item['title']}}</option>
            <p>{{$item['title']}}</p>
        @endforeach
    </select>
</form>
<div id="result"></div>

<script>
    var nameInput = document.getElementById('name');
    var result = document.getElementById('result');

    nameInput.addEventListener("input", (event) => {
        result.textContent = `You like ${event.target.value}`;
        test = event.target.value;


        // console.log(array);
        for (var i = 0; i < array.length; i++){
            console.log(array[i]);
        }
    });

</script>

</body>
</html>
