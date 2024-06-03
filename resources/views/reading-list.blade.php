<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Summer Reading</title>
    <style>
        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
            gap: 20px;
        }
        .form-container-grid {
            width: 25%;
        }
        .list-container-grid {
            width: 72%;
        }
        .form-container form {
            width: 100%;
        }
        .list-container table {
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-container-grid">
        @include("bladeTemplates.summer-reading-form")
    </div>
    <div class="list-container-grid">
        @include("bladeTemplates.summer-reading-list")
    </div>
</div>
</body>
</html>
