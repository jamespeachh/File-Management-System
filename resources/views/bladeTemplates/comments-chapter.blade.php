<link rel="stylesheet" href="{{asset('Comments/css/style.css')}}">
<ul class="comment_section">
    <h1 class="comment_header">What did you think about this chapter?</h1>
    @foreach(Cache::get('cur_comments') as $item)
        @if($item['active_comment']==1)
            <li class="comment">
                <div class="comment_block">
                    <img class="comment_user_pfp" src="{{asset('accountImages/'.$item['profile_picture'])}}" alt="pfp">
                    <div class="name_and_body">
                        <h3>{{$item['name']}}</h3>
                        <hr>
                        <p class="comment_text">{{$item['comment_body']}}</p>
                    </div>
                    @if($item['user_id'] == \Illuminate\Support\Facades\Auth::id())
                        <a
                            href="{{ url(route('deleteComment', ['comment'=>$item['id'],'bookID'=>$bookID,'pageNumber'=>$pageNum])) }}"
                            style="border-style: solid;text-align:center;border-radius: 10px"
                        >delete</a>
                    @endif
                </div>
            </li>
        @endif
    @endforeach

    <!-- comment form -->
    <div class="you_comment">
        <h3 style="padding-left: 20px;">Write a comment</h3>
        <form method="POST" action="{{ route('submit-comment') }}" class="comment_form">
            @csrf
            <textarea class="form_real" id="input_text" wrap="soft" name="body" required></textarea>
            <input type="hidden" class="form_real" id="bookName" name="bookID" value="{{$bookID}}">
            <input type="hidden" class="form_real" id="pageNumber" name="pageNumber" value="{{$pageNum}}">
            <input type="submit" class="form_real" id="input_button">
        </form>
    </div>
</ul>



