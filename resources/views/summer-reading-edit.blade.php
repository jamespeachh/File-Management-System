<style>
    .form-container {
        background-color: #fff;
        border: 2px solid #cc0052; /* Dark pink */
        border-radius: 15px;
        padding: 20px;
        width: 300px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: #800000; /* Maroon */
    }
    .form-section {
        background-color: #ffe6e6;
        border: 1px solid #cc0052;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .review-form-label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"],
    textarea,
    select {
        width: calc(100% - 12px);
        padding: 5px;
        border: 1px solid #cc0052;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    textarea {
        resize: vertical;
    }
    input[type="checkbox"] {
        margin-right: 5px;
    }
    input[type="range"] {
        width: 100%;
    }
    .stars {
        unicode-bidi: bidi-override;
        color: #ccc;
        font-size: 25px;
        height: 25px;
        width: 125px;
        margin: 0 auto 15px auto;
        position: relative;
        padding: 0;
    }
    .stars span {
        display: block;
        left: 0;
        overflow: hidden;
        position: absolute;
        top: 0;
    }
    .stars span:before {
        content: "★★★★★";
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
        color: gold;
        text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; /* Black border */
    }
    .tooltip {
        display: none;
        position: absolute;
        background-color: #800000; /* Maroon */
        color: #fff;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
        z-index: 2;
        white-space: nowrap;
        left: 50%;
        transform: translateX(-50%);
    }

    .stars:hover .tooltip {
        display: block;
    }
    button {
        background-color: #cc0052;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        width: 100%;
    }
    button:hover {
        background-color: #99003d;
    }
    .hidden {
        display: none;
    }
    @media (max-width: 600px) {
        body {
            margin: 0;
            padding: 0;
            font-size: 16px;
        }
        .container {
            flex-direction: column;
            padding: 10px;
            gap: 10px;
        }
        .form-container,
        .form-container-grid,
        .list-container-grid {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #cc0052; /* Dark pink */
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .form-container form,
        .list-container table {
            width: 100%;
        }
        .form-section {
            padding: 10px;
            margin-bottom: 10px;
        }
        .form-section p {
            font-size: 16px;
        }
        .review-form-label {
            margin-bottom: 3px;
            font-size: 14px;
        }
        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 5px;
            margin-bottom: 8px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
        }
        input[type="checkbox"] {
            margin-right: 5px;
            transform: scale(1.2);
        }
        input[type="range"] {
            width: 100%;
        }
        .stars {
            font-size: 20px;
            height: 20px;
            width: 100px;
            margin: 5px auto;
        }
        button {
            padding: 8px 10px;
            font-size: 14px;
        }
        .tooltip {
            font-size: 10px;
            padding: 3px;
        }
    }
</style>

<div class="form-container">
    <form method="POST" action="{{ route('reading.submit-edit-item') }}">
        @csrf

        @if($item['onSiteValue'] == 'Yes')
            <div class="form-section">
                <p style="text-align:center;font-weight:700;">{{$item['bookTitle']}}</p>
            </div>
        @endif
        @if($item['onSiteValue'] == 'No')
            <!-- If No, provide book details -->
            <div id="bookDetails" class="form-section">
                <label for="title" class="review-form-label">Title:</label>
                <input type="text" id="title" name="title" style="background-color:#B9B9B9;font-weight:700;" value="{{$item['bookTitle']}}" readonly>

                <label for="author" class="review-form-label">Author:</label>
                <input type="text" id="author" name="author" value="{{$item['bookAuthor']}}">

                <label for="summary" class="review-form-label">Summary:</label>
                <textarea id="summary" name="summary">{{$item['bookSummary']}}</textarea>

                <label for="addBook" class="review-form-label">
                    <input
                        type="checkbox"
                        id="addBook"
                        name="addBook"
                        @if($item['wantBookAdded'])
                            checked
                        @endif
                    >
                    Would you like this book added?
                </label>
            </div>
        @endif
        <!-- Read? -->
        <div id="readSection" class="form-section">
            <label for="read" class="review-form-label">
                <input
                    type="checkbox"
                    id="read"
                    name="read"
                    onchange="toggleRating()"
                    @if($item['status'])
                        checked
                    @endif
                >
                Have you read this book yet?
            </label>
            <div id="ratingQuestion" class="">
                <label for="rateqm" class="review-form-label">
                    <input
                        type="checkbox"
                        id="rateqm"
                        name="rateqm"
                        onchange="toggleSlider()"
                        @if($item['rating'] != Null)
                            checked
                        @endif
                    >

                    Would you like to rate this book?
                </label>
            </div>
        </div>

        <!-- Rate this book -->
        <div id="ratingSection" class="form-section">
            <label for="rate" class="review-form-label">Rating:</label>
            <input type="range" id="rate" name="rate" min="1" max="10" step="1" oninput="updateStars(this.value)" value="{{$item['rating']}}">
            <div id="starRating" class="stars">
                <span style="width: {{($item['rating'] / 10) * 100}}%;">★★★★★</span><br>
                <div class="tooltip" id="tooltip">Rating: {{$item['rating']/2}}/5</div>
            </div>
        </div>
{{--        HIDDEN FIELDS --}}
        <input type="hidden" id="onSite" name="onSite" value="{{$item['onSiteValue']}}">
        <input type="hidden" id="listID" name="listID" value="{{$item['listId']}}">
        <button type="submit">Submit</button>
    </form>
</div>

<script>
    function toggleFields() {
        const onSite = document.getElementById('onSite').value;
        document.getElementById('bookChoice').classList.toggle('hidden', onSite !== 'yes');
        document.getElementById('readSection').classList.toggle('hidden', onSite !== 'yes' && onSite !== 'no');
        document.getElementById('bookDetails').classList.toggle('hidden', onSite !== 'no');
    }

    function toggleRating() {
        const readCheckbox = document.getElementById('read').checked;
        document.getElementById('ratingQuestion').classList.toggle('hidden', !readCheckbox);
    }

    function toggleSlider() {
        const rateCheckbox = document.getElementById('rateqm').checked;
        document.getElementById('ratingSection').classList.toggle('hidden', !rateCheckbox);
    }

    function updateStars(value) {
        const percentage = (value / 10) * 100;
        document.querySelector('#starRating span').style.width = `${percentage}%`;
        document.getElementById('tooltip').textContent = `Rating: ${value / 2}/5`;
    }
</script>


