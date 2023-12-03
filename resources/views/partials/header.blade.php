<header>
    <h1><a href="{{ url('/') }}">LeiloArte</a></h1>
    <nav class="navigation">
        <div>
            <a class = "button" href="{{ route('home') }}"> Home </a>
            <a class = "button" href="{{ route('aboutUs')}}"> About us </a>
            <a class = "button" href="{{ route('faqs')}}"> FAQs </a>
        </div>

        <div class="search-container">
            <form method="GET" action="{{ url('/') }}">
                {{ csrf_field() }}
                <input id="searchBar" type="text" name="search" placeholder="Search..">
                <button class= "button" id="searchButton"> Search </button>
            </form>
        </div>

        @if (Auth::check())
            <div class="user-controls">
                <a class="button" href="{{ route('notificationsCenter', ['id'=>Auth::user()->id])}}"> Notifications </a>
                <form method="POST" action="{{ route('logout') }}">
                    {{ csrf_field() }}
                    <button class="button"> Logout </button>
                </form>
                <span class="transparent-box"><a href="{{ route('user', ['id'=>Auth::user()->id]) }}" class="user-link">{{ Auth::user()->name }}</a></span>
            </div>
        @endif

        @if (!Auth::check())
            <div>
                <a class="button" href="{{ url('/login') }}"> Login </a>
                <a class="button" href="{{ url('/register') }}"> Register </a>
            </div>
        @endif
    </nav>
</header>
