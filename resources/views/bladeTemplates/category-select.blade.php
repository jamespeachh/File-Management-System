<div style="padding-left:15px;padding-top:15px;margin-bottom:-15px;">
    <h3 style="padding-bottom:6px;">Book Category</h3>
    <select id="selectList">
        <option value="">Select a category{{$name}}</option>
        <option value="all">All available</option>
        @foreach($items as $item)
            <option value="{{$item['title']}}">{{$item['title']}}</option>
        @endforeach
    </select>
</div>



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
