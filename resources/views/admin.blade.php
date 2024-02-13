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
<form method="POST" action="{{ route('admin-submit') }}" class="comment_form">
    @csrf
    <label for="book_bodies">Wipe and replace all the book bodies from files to sql</label>
    <input type="checkbox" id="book_bodies" name="book_bodies">
    <label for="pull">Pull changes to the website</label>
    <input type="checkbox" id="pull" name="pull">
    <input type="submit">

</form>
{{--possibly one day make a loop with check boxes that add or take away different books--}}
<button>Wipe and Replace all the book bodies</button>
<button onclick="">Pull changes</button>
</body>
</html>
