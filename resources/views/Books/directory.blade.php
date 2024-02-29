
<!-- resources/views/display-text.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Book Directory</title>
    <link rel="stylesheet" href="{{asset('htmlData/css/dir.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
@include('bladeTemplates.header')
<div class="text-container">
    <div class="text-content">
        <div class="header-div">
            <h1>Pick a Book :3</h1>
        </div>
        <div style="padding-left:15px;padding-top:15px">
            <h3>Book Category</h3>
            <div class="checkbox-wrapper-65">
        </div>

            <label for="cbk1-65">
{{--                <input type="checkbox" id="cbk1-65">--}}
                <select id="selectList">
                    <option value="">Select a category</option>
                    <option value="all">All available</option>
                    @foreach($items as $item)
                        <option value="{{$item['title']}}">{{$item['title']}}</option>
                    @endforeach
                </select>
{{--                <span class="cbx">--}}
{{--                    <svg width="12px" height="11px" viewBox="0 0 12 11">--}}
{{--                      <polyline points="1 6.29411765 4.5 10 11 1"></polyline>--}}
{{--                    </svg>--}}
{{--                </span>--}}
{{--                <span>Grid View?</span>--}}
            </label>
        </div>
        <div class="container">
            <ul class="link-list">
                <div class="grid" id="grid">
                    @foreach($data['books'] as $item)

                        <li class="grid-item">
                            <a href="{{ url(route('book', ['bookID' => $item['id'], 'pageNumber' => 1])) }}" class="link">
                                <div class="list-item">
                                    <img src="{{ asset('BookCover/' . $item['img']['src']) }}"
                                         alt="{{$item['img']['alt']}}"
                                         class="test-img">{{--<br>--}}
                                    {{$item['title']}}
                                </div>
                            </a>
                        </li>
                    @endforeach

                </div>
            </ul>
        </div>
        <script src="script.js"></script>
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
            case 2:
                alert("No books in that category:<\nPick another or view all books.");
                break;
        }
    }
</script>
<script>
    $(document).ready(function(){
        $('#selectList').change(function(){
            var selectedOption = $(this).val();
            var redirectUrl = '';

            // Construct the redirect URL based on the selected option
            switch(selectedOption) {
                @foreach($items as $item)
                case '{{$item['title']}}':
                    redirectUrl = '?selected_cat_id={{$item['id']}}'
                    break;
                @endforeach
                case 'all':
                    redirectUrl = '/directory';
                    break;
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
<script src="{{asset('htmlData/scripts/checkbox.js')}}"></script>
</body>
</html>
