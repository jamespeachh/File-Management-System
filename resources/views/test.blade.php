<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<select id="selectList">
    <option value="">Select an option</option>
    @foreach($items as $item)
        <option value="{{$item['title']}}">{{$item['title']}}</option>
    @endforeach
</select>

<script>
    $(document).ready(function(){
        $('#selectList').change(function(){
            var selectedOption = $(this).val();
            var redirectUrl = '';

            // Construct the redirect URL based on the selected option
            switch(selectedOption) {
                @foreach($items as $item)
                    case '{{$item['title']}}':
                        redirectUrl = '?id={{$item['id']}}'
                    break;
                @endforeach
                default:
                    // Default redirect if no option is selected
                    redirectUrl = '/';
                    break;

            }

            // Redirect to the constructed URL
            window.location.href = redirectUrl;
        });
    });
</script>

</body>
</html>
