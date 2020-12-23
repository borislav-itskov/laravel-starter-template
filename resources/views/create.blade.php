<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<div class="wrapper" id="app">
    <h1>Create a card</h1>

    <create-component
        :types="{{ json_encode($types) }}"
    ></create-component>
</div>