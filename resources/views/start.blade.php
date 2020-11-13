@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>LARAVEL VUE</h1>
        <div data-spy="scroll" data-target="#navbar-example2" data-offset="0" class="scrollspy-example">
            <h4 id="">#1 Example component</h4>
            <p>
                <example-component></example-component>
            </p>
            <h4 id="">#2 Передача данных в Vue из Blade</h4>
            <p>
                <prop-component :urldata="{{ json_encode($url_data) }}"></prop-component>
            </p>
            <h4 id="">#3 Ajax</h4>
            <p>
                <ajax-component></ajax-component>
            </p>
            <h4 id="">#4 ChartJS(Line) & VueJs*ajax</h4>
            <p>
                <chartline-component></chartline-component>
            </p>
            <h4 id="">#5 ChartJS(Pie) & VueJs*ajax</h4>
            <p>
                <chartpie-component></chartpie-component>
            </p>

            <h4 id="">#6 ChartJS(Line) & VueJs*ajax+trigger+reload</h4>
            <p>
                <chartrandom-component></chartrandom-component>
            </p>

            <h4 id="">#7 REALTIME ChartJS(Line) & VueJs*ajax+trigger+reload</h4>
            <p>
                <socket-component></socket-component>
            </p>

            <h4 id="">#8 REALTIME Chat VueJs*ajax+trigger+reload</h4>
            <p>
            @if (Auth::check())
                <h4 class="text-center">пользователь: {{ Auth::user()->email }}</h4>
            @endif
            <socket-chat-component></socket-chat-component>
            </p>

            <h4 id="">#9 REALTIME Chat Private VueJs*ajax+trigger+reload</h4>
            <p>
            @php
               // dd(Auth::check());
                @endphp
            @if (Auth::check())
                <h4 class="text-center">пользователь: {{ Auth::user()->email }}</h4>
                <socket-private-component :users="{{\App\Models\User::select('email','id')->where('id','!=', Auth::id())
                    ->get() }}" :user="{{Auth::user()}}"></socket-private-component>
            @endif
            </p>

        </div>
    </div>

@endsection
