<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<div class="wrapper" id="app">
    <h1>Create a card</h1>

    <form>
        <label>Type</label>
        <select name="type">
            @foreach($types as $name => $type)
                <option value={{ $type }}>{{ $name }}</option>
            @endforeach
        </select>

        <example-component></example-component>
    </form>
</div>