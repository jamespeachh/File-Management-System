<link rel="stylesheet" href="{{asset('Comments/css/style.css')}}">
<ul class="comment_section">
    <h1 class="comment_header">What did you think about this chapter?</h1>
    @foreach($data['books'] as $item)
            <li class="comment">
                <div class="comment_block">
                    <img class="comment_user_pfp" src="{{asset('Comments/assets/pfp.png')}}" alt="pfp">
                    <div class="name_and_body">
                        <h3>USERNAME</h3>
                        <hr>
                        <p class="comment_text"></p>
                    </div>
                </div>
            </li>
    @endforeach

    <!-- comment form -->
    <div class="you_comment">
        <h3 style="padding-left: 20px;">Write a comment</h3>
        <form action="submit" class="comment_form">
            <textarea class="form_real" id="input_text" wrap="soft" required></textarea>
            <input type="submit" class="form_real" id="input_button">
        </form>
    </div>
</ul>



