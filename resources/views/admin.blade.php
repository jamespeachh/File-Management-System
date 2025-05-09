<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN</title>
    <style>
        .commit-info {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-family: monospace;
        }
        .commit-info h3 {
            margin-top: 0;
            color: #333;
        }
        .commit-info p {
            margin: 5px 0;
        }
        .commit-hash {
            color: #666;
            font-size: 0.9em;
        }
        .form-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .form-section h2 {
            margin-top: 0;
            color: #333;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    @if(isset($latestCommit))
    <div class="commit-info">
        <h3>Latest Commit Information</h3>
        <p><strong>Message:</strong> {{ $latestCommit['message'] }}</p>
        <p><strong>Author:</strong> {{ $latestCommit['author'] }}</p>
        <p><strong>Date:</strong> {{ $latestCommit['date'] }}</p>
        <p class="commit-hash"><strong>Hash:</strong> {{ $latestCommit['hash'] }}</p>
    </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="form-section">
        <h2>Add EPUB Book</h2>
        <form method="POST" action="{{ route('admin.add-epub') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="title">Book Title:</label><br>
                <input type="text" id="title" name="title" required><br>
            </div>
            <div>
                <label for="author">Author:</label><br>
                <input type="text" id="author" name="author" required><br>
            </div>
            <div>
                <label for="epub_file">EPUB File:</label><br>
                <input type="file" id="epub_file" name="epub_file" accept=".epub" required><br>
            </div>
            <div style="margin-top: 10px;">
                <input type="submit" value="Add Book">
            </div>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.submit') }}">
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
    <form method="POST" action="{{ route('admin.submit') }}" enctype="multipart/form-data">
        @csrf
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
    <br><br><hr><br><br><br>
    <form method="POST" action="{{ route('admin.submit') }}" enctype="multipart/form-data">
        @csrf
        <label for="create_link">create link!</label>
        <input type="checkbox" id="create_link" name="create_link"><br>

        <label for="life">Lifetime</label>
        <select id="life" name="life">
            <option value="1">30 Minutes</option>
            <option value="2">Permanent</option>
        </select><br>

        <label for="userID">UserID</label><br>
        <input type="text" name="userID" id="userID" placeholder="userID"><br>
        <label for="passwordID">PasswordID</label><br>
        <input type="text" name="passwordID" id="passwordID" placeholder="passwordID">

        <input type="submit">
    </form>

    <br><br><hr><br>
    {{--password--}}
    <form method="POST" action="{{ route('admin.submitNewPassword') }}">
        @csrf
        <label for="password">Password</label>
        <input type="text" id="password" name="password"><br>
        <label for="username">username</label>
        <input type="text" id="username" name="username"><br>
        <label for="website">website</label>
        <input type="text" id="website" name="website"><br>
        <input type="submit">
    </form>

    {{--possibly one day make a loop with check boxes that add or take away different books--}}
</body>
</html>
