
<!-- resources/views/display-text.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Book Directory</title>
    <link rel="stylesheet" href="{{asset('htmlData/css/dir.css')}}">
</head>
<body>
@include('bladeTemplates.header')
<div class="text-container">
    <div class="text-content">
        <div class="header-div">
            <h1>Pick a Book :3</h1>
        </div>
        @include('bladeTemplates.directory-body')
    </div>
</div>

<script>
    @if($alertExists)
        alertExists({{$alertMessage}});
    @endif
    function alertExists(alertMessage){
        switch(alertMessage) {
            case 1:
                alert("You need to chose a book to continue!!!\nRedirecting you to selection.");
                break;
        }
    }
</script>
</body>
</html>
