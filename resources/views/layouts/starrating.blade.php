<link rel="stylesheet" href="{{asset('htmlData/css/rating.css')}}">

<form method="POST" action="{{ route('test.test-submit') }}" class="rating form">
    @csrf
    <fieldset class="rate">
        <input type="radio" id="rating10" name="rating" value="10" /><label for="rating10" title="5 stars"></label>
        <input type="radio" id="rating9" name="rating" value="9" /><label class="half" for="rating9" title="4 1/2 stars"></label>
        <input type="radio" id="rating8" name="rating" value="8" /><label for="rating8" title="4 stars"></label>
        <input type="radio" id="rating7" name="rating" value="7" /><label class="half" for="rating7" title="3 1/2 stars"></label>
        <input type="radio" id="rating6" name="rating" value="6" /><label for="rating6" title="3 stars"></label>
        <input type="radio" id="rating5" name="rating" value="5" /><label class="half" for="rating5" title="2 1/2 stars"></label>
        <input type="radio" id="rating4" name="rating" value="4" /><label for="rating4" title="2 stars"></label>
        <input type="radio" id="rating3" name="rating" value="3" /><label class="half" for="rating3" title="1 1/2 stars"></label>
        <input type="radio" id="rating2" name="rating" value="2" /><label for="rating2" title="1 star"></label>
        <input type="radio" id="rating1" name="rating" value="1" /><label class="half" for="rating1" title="1/2 star"></label>
    </fieldset>
    <input type="submit" class="form_real" id="input_button">
</form>
