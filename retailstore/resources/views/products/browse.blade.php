@extends('layouts.app')

@section('title', 'Browse Products')

@section('content')

    <!-- Force-load browse.css here -->
    @php
        // Check three ways to include a stylesheet:
        // 1) Public compiled file under public/css/browse.css
        // 2) Vite (dev/compiled assets)
        // 3) Inline fallback reading from resources/css/browse.css (useful in dev before building)
        $publicCssPath = public_path('css/browse.css');
        $resourceCssPath = resource_path('css/browse.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/browse.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/browse.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

    <!-- Header / Navigation -->
    <header>
        @include('components.navbar')
    </header>

    <main>
        <div class="container">
            <h1 class="page-title">Browse Products</h1>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Top toolbar: Search, Sort, Cart -->
            <div class="product-toolbar">
                <!-- Update the search form (hidden in_stock is already preserved) -->
                <form method="GET" action="{{ \Illuminate\Support\Facades\Route::has('products.browse') ? route('products.browse') : url()->current() }}" class="search-form">
                    <!-- preserve sorting and filters on search -->
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                    <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                    <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                    <input type="text" name="query" placeholder="Search products, brands, categories..." value="{{ request('query') }}">
                    <button type="submit" class="btn-search">Search</button>
                </form>
                <div class="toolbar-controls">
                    <form method="GET" action="{{ \Illuminate\Support\Facades\Route::has('products.browse') ? route('products.browse') : url()->current() }}">
                        <!-- preserve current search and filters -->
                        <input type="hidden" name="query" value="{{ request('query') }}">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        <input type="hidden" name="in_stock" value="{{ request('in_stock') }}">
                        <select name="sort" onchange="this.form.submit()" class="sort-select">
                            <option value="">Sort: Featured</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </form>

                    {{-- Cart link removed — navbar already displays cart info --}}
                    {{-- <a class="cart-link" href="{{ \Illuminate\Support\Facades\Route::has('cart.index') ? route('cart.index') : '#' }}">
                        Cart (<span class="cart-count">{{ session('cart_count', 0) }}</span>)
                    </a> --}}
                </div>
            </div>

            <!-- Main content with filters + product grid -->
            <div class="product-page">
                <!-- Sidebar filters -->
                <aside class="filters">
                    <div class="filter-header">
                        <h3>Filter by Category</h3>
                        <button class="filter-toggle" onclick="document.querySelector('.filters').classList.toggle('open')">Toggle</button>
                    </div>
                    <ul class="category-list">
                        <li>
                            <a href="{{ \Illuminate\Support\Facades\Route::has('products.browse') ? route('products.browse', array_merge(request()->query(), ['category' => null])) : '#' }}" class="{{ !request('category') ? 'active' : '' }}">All Products</a>
                        </li>
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ \Illuminate\Support\Facades\Route::has('products.browse') ? route('products.browse', array_merge(request()->query(), ['category' => $category->category_id])) : '#' }}" class="{{ request('category') == $category->category_id ? 'active' : '' }}">
                                    {{ $category->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Additional basic filters -->
                    <div class="extra-filters">
                        <h4>Availability</h4>
                        <!-- Availability filter checkbox: make it reflect current state and toggle properly -->
                        <label>
                            <input
                                type="checkbox"
                                name="in_stock"
                                {{ request()->boolean('in_stock') ? 'checked' : '' }}
                                onchange="(function(el){ const u = new URL(location.href); if(el.checked) u.searchParams.set('in_stock','1'); else u.searchParams.delete('in_stock'); window.location = u.toString(); })(this)"
                            >
                            In stock only
                        </label>

                        <h4>Price</h4>
                        <div class="price-range">
                            <a href="{{ \Illuminate\Support\Facades\Route::has('products.browse') ? route('products.browse', array_merge(request()->query(), ['max_price' => 50])) : '#' }}">Under $50</a>
                            <a href="{{ \Illuminate\Support\Facades\Route::has('products.browse') ? route('products.browse', array_merge(request()->query(), ['max_price' => 100])) : '#' }}">Under $100</a>
                            <a href="{{ \Illuminate\Support\Facades\Route::has('products.browse') ? route('products.browse', array_merge(request()->query(), ['min_price' => 100])) : '#' }}">$100+</a>
                        </div>
                    </div>
                </aside>

                <!-- Product grid -->
                <section class="product-list">
                    <div class="grid">
                        @forelse ($products as $product)
                            <div class="product-card">
                                <a href="{{ \Illuminate\Support\Facades\Route::has('products.details') ? route('products.details', $product->product_id) : '#' }}" class="product-image-link">
                                    <div class="image-wrap">
                                        @php
                                            // fallback default image (plain web path)
                                            $defaultPath = '/images/generic-product.png';
                                            $imagePath = $defaultPath;

                                            // candidate file extensions
                                            $extensions = ['png','jpg','jpeg','webp','svg'];

                                            // raw product image value (may be filename or path)
                                            $imageRaw = $product->image_url ?? null;

                                            // Helper to test file under public and return a web path if found
                                            $tryPublicFile = function($relativePath) {
                                                $file = public_path(ltrim($relativePath, '/'));
                                                return file_exists($file) ? '/' . ltrim($relativePath, '/') : false;
                                            };

                                            // 1) Try explicit product image (absolute URL accepted as-is)
                                            if ($imageRaw) {
                                                if (preg_match('/^https?:\\/\\//i', $imageRaw)) {
                                                    $imagePath = $imageRaw; // keep external absolute URL if present
                                                } else {
                                                    $relative = ltrim($imageRaw, '/');

                                                    // If it already has an extension, test exact file under /images and root
                                                    if (preg_match('/\\.[a-zA-Z0-9]+$/', $relative)) {
                                                        // prefer images/...
                                                        $path = $tryPublicFile('images/' . $relative);
                                                        $imagePath = $path ?: ($tryPublicFile($relative) ?: $defaultPath);
                                                    } else {
                                                        // try adding common extensions under /images/
                                                        $found = false;
                                                        foreach ($extensions as $ext) {
                                                            $candidate = 'images/' . $relative . '.' . $ext;
                                                            if ($tryPublicFile($candidate)) {
                                                                $imagePath = '/' . $candidate;
                                                                $found = true;
                                                                break;
                                                            }
                                                        }
                                                        if (!$found) {
                                                            // try root public path
                                                            foreach ($extensions as $ext) {
                                                                $candidate = $relative . '.' . $ext;
                                                                if ($tryPublicFile($candidate)) {
                                                                    $imagePath = '/' . $candidate;
                                                                    $found = true;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            // 2) If no product image found, attempt category-specific images
                                            if (empty($imagePath) || $imagePath === $defaultPath) {
                                                $categoryName = $product->category->category_name ?? $product->category_name ?? $product->category_id ?? null;
                                                if ($categoryName) {
                                                    $slug = \Illuminate\Support\Str::slug((string)$categoryName);

                                                    // try images/categories/<slug>.<ext>
                                                    $found = false;
                                                    foreach ($extensions as $ext) {
                                                        $candidate = "images/categories/{$slug}.{$ext}";
                                                        if ($tryPublicFile($candidate)) {
                                                            $imagePath = '/' . $candidate;
                                                            $found = true;
                                                            break;
                                                        }
                                                    }

                                                    // try images/<slug>.<ext> if not found
                                                    if (!$found) {
                                                        foreach ($extensions as $ext) {
                                                            $candidate = "images/{$slug}.{$ext}";
                                                            if ($tryPublicFile($candidate)) {
                                                                $imagePath = '/' . $candidate;
                                                                $found = true;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            // final fallback will remain $defaultPath if nothing matches
                                        @endphp

                                        <img src="{{ $imagePath }}" alt="{{ $product->product_name ?? 'Product' }}" loading="lazy">
                                        @if(isset($product->discount_percent) && $product->discount_percent > 0)
                                            <span class="badge sale">-{{ $product->discount_percent }}%</span>
                                        @endif
                                        @if(isset($product->inventory->stock_quantity) && $product->inventory->stock_quantity <= 0)
                                            <span class="badge oos">Out of Stock</span>
                                        @endif
                                    </div>
                                </a>

                                <div class="card-body">
                                    <a href="{{ \Illuminate\Support\Facades\Route::has('products.details') ? route('products.details', $product->product_id) : '#' }}" class="product-title">{{ $product->product_name }}</a>
                                    <div class="product-desc">
                                        {{ strlen($product->description) > 100 ? substr($product->description, 0, 100) . '...' : $product->description }}
                                    </div>
                                    <div class="price-row">
                                        @if (isset($product->original_price) && $product->original_price > $product->unit_price)
                                            <span class="price-old">${{ number_format($product->original_price, 2) }}</span>
                                        @endif
                                        <span class="price">${{ number_format($product->unit_price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <p>No products available</p>
                                <p>Try clearing filters or searching for something else.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination if using a paginator -->
                    <div class="pagination pagination-wrapper">
                        {{ method_exists($products, 'links') ? $products->appends(request()->query())->links() : '' }}
                    </div>
                </section>
            </div>
        </div>
    </main>

    <!-- Small inline JS for filter toggle on mobile -->
    <script>
        // Very small helper: close / open filters for mobile
        (function () {
            var toggle = document.querySelector('.filter-toggle');
            if (toggle) toggle.addEventListener('click', function () {
                document.querySelector('.filters').classList.toggle('open');
            });
        }());
    </script>

@endsection
