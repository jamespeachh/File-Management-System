<label>
    <select name="numbers" onchange="redirectToPage(this.value)">
        @for ($i = 1; $i <= $data['pages']; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>
</label>

<script>
    function redirectToPage(selectedValue) {
        window.location.href = {{$url}}+'&pageNumber='+selectedValue;
    }
</script>
