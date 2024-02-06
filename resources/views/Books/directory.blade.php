
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
</body>
</html>
