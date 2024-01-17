<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Form</title>
    <link rel="stylesheet" href="{{ asset('htmlData/css/import.css') }}">

</head>
<body>
<form method="POST" action="{{ route('submit-form') }}" class="import-form">
    @csrf
    <input type="text" placeholder="bookName" name="bookName" class="form-inputs" required><br>
    <input type="text" placeholder="url" name="url" class="form-inputs" required><br>
    <input type="text" placeholder="title formatted" name="title_formatted" class="form-inputs" required><br>
    <input type="text" placeholder="pages" name="pages" class="form-inputs" required><br>
    <input type="text" placeholder="img src" name="img_src" class="form-inputs" required><br>
    <input type="text" placeholder="img alt" name="img_alt" class="form-inputs" required><br>
    <input type="file" placeholder="Cover image" name="cover_img" class="form-inputs" accept=".png,.jpeg,.jpg" required><br>
    <input type="text" placeholder="password" name="password" class="form-inputs" required><br>
    <button>submit</button>
</form>
</body>
</html>
