@extends('layouts.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <div class="col-lg-3 col-md-6">
        <select class="js-example-basic-multiple" name="states[]" multiple="multiple" style="width: 100%;">
            <option value="AL">Alabama</option>
            <option value="WY">Wyoming</option>
        </select>
    </div>

    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Then load Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Initialize Select2 -->
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection
