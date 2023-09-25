<!-- resources/views/display-text.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Book Directory</title>
    <link rel="stylesheet" href="{{asset('htmlData/css/dir.css')}}">
    <link rel="stylesheet" href="{{ asset('css/LucidaSans/style.css') }}">
</head>
<body>
@include('bladeTemplates.header')
<div class="text-container">
    <div class="text-content">
            <h1>upload: DO NOT UPLOAD YET, IT IS NOT READY AND IT WILL HURT MY HEAD PLEASE</h1>
    </div>
    <form action="{{ route('upload.process') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="folder-name">
        <input type="file" multiple name="files[]">
        <button type="submit">Upload Folder</button>
    </form>
</div>
</body>
</html>
