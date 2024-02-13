<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN</title>
</head>
<body>
<form method="POST" action="{{ route('admin-submit') }}">
    @csrf
    <label for="book_bodies">Wipe and replace all the book bodies from files to sql</label>
    <input type="checkbox" id="book_bodies" name="book_bodies"><br>
    <hr>
    <label for="pull">Pull changes to the website</label>
    <input type="checkbox" id="pull" name="pull"><br>
    <input type="submit">

</form>


<hr>
<hr>
<form method="POST" action="{{ route('test-submit') }}" enctype="multipart/form-data">

    <label for="add_book_final_check">CHECK THIS BOX ONCE YOU ARE SURE YOU WANT TO ADD THIS BOOK</label>
    <input type="checkbox" id="add_book_final_check" name="add_book_final_check"><br>

    <label for="bookTitle">Book Title(shortened that will show up in sftp)</label><br>
    <input type="text" id="bookTitle" name="bookTitle"><br>

    <label for="full_book">Full Book Text File</label><br>
    <input type="file" id="full_book" name="full_book"><br>

    <label for="sub_title_file">Sub-title file</label><br>
    <input type="file" id="sub_title_file" name="sub_title_file"><br>




    <input type="submit">

</form>
{{--possibly one day make a loop with check boxes that add or take away different books--}}
</body>
</html>