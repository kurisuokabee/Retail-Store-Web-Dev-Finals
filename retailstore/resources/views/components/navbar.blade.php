<nav class="site-navbar" role="navigation">
    <style>
        /* Local component styling - move into a central CSS file for global use */
        .site-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 20px;
        }
        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1920px;
            margin: 0 auto;
        }
        .brand {
            font-weight: 700;
            color: #000000;
            text-decoration: none;
            font-size: 1.55rem;
            display: inline-flex; /* align image + text */
            align-items: center;
        }
        /* Add styles for the logo image */
        .brand img {
            height: 34px;
            width: auto;
            margin-right: 5px;
            object-fit: contain;
            display: inline-block;
            vertical-align: middle;
        }
        /* Move the text slightly upward relative to the logo */
        .brand-text {
            display: inline-block;
            transform: translateY(-2px); /* tweak this value to raise/lower */
            line-height: 1;
        }
        .nav-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .nav-list a, .nav-list button {
            color: #333;
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 4px;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;

            /* ensure uniform typography for anchors and buttons */
            font-family: inherit;
            font-weight: 600;        /* match link weight */
            line-height: 1;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .nav-list a:hover, .nav-list button:hover {
            background: #e9ecef;
        }
        .logout-form {
            display: inline;
            margin: 0;
        }
        @media (max-width: 600px) {
            .navbar-inner {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            .nav-list {
                justify-content: center;
                flex-wrap: wrap;
            }
            .brand img {
                height: 34px;
            }
            .brand-text {
                transform: translateY(-2px);
            }
        }
    </style>

    <div class="navbar-inner">
        <a class="brand" href="{{ route('products.browse') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Budega logo" />
            <span class="brand-text">Budega</span>
        </a>

        <ul class="nav-list">
            @auth
                <li><a href="{{ route('orders.history') }}">My Orders</a></li>
                <li><a href="{{ route('customers.show', Auth::user()->customer_id) }}">My Profile</a></li>
                @php $cartCount = count(session('cart', [])); @endphp
                <li><a href="{{ route('orders.checkout') }}">Cart ({{ $cartCount }})</a></li>
                <li>
                    <form method="POST" action="{{ route('auth.logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" aria-label="Logout">Logout</button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Register</a></li>
            @endauth
        </ul>
    </div>
</nav>
