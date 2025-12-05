@extends('layouts.app')

@section('title', 'Budega Philippines | Product Details')

@section('content')

    <!-- Force-load details.css here (same pattern as browse) -->
    @php
        $publicCssPath = public_path('css/details.css');
        $resourceCssPath = resource_path('css/details.css');
    @endphp

    @if (file_exists($publicCssPath))
        <link rel="stylesheet" href="{{ asset('css/details.css') }}">
    @elseif (function_exists('vite'))
        @vite(['resources/css/details.css'])
    @elseif (Illuminate\Support\Facades\File::exists($resourceCssPath))
        <style>
            {!! Illuminate\Support\Facades\File::get($resourceCssPath) !!}
        </style>
    @endif

<header>
    @include('components.navbar')
</header>

<div class="container product-details">
    <div class="product-page">
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
        @endphp

        <!-- Left: Product image (big) -->
        <div class="image-column">
            <div class="image-card">
                <div class="image-wrap">
                    <img src="{{ $imagePath }}" alt="{{ $product->product_name ?? 'Product' }}" loading="lazy">
                    @if(isset($product->discount_percent) && $product->discount_percent > 0)
                        <span class="badge sale">-{{ $product->discount_percent }}%</span>
                    @endif
                    @if(isset($product->inventory->stock_quantity) && $product->inventory->stock_quantity <= 0)
                        <span class="badge oos">Out of Stock</span>
                    @endif
                </div>
            </div>

            <!-- Optional: small gallery thumbnails (if product has multiple images array) -->
            {{-- ...existing code... --}}
        </div>

        <!-- Right: Product info -->
        <div class="info-column">
            <!-- Title -->
            <h1 class="product-page-title">{{ $product->product_name }}</h1>

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
                {{-- Replace default alert with a more polished toast/pill --}}
                <div class="cart-toast success-toast" id="cart-toast" role="status" aria-live="polite">
                    <img src="{{ $imagePath }}" alt="{{ $product->product_name ?? 'Product' }}" class="cart-thumb" loading="lazy">
                    <div class="cart-toast-body">
                        <div class="cart-toast-title">Added to Cart</div>
                        <div class="cart-toast-text">{{ session('success') }}</div>
                        <div class="cart-toast-actions">
                            <a href="{{ route('orders.checkout') }}" class="btn btn-view mini">View Cart</a>
                            <a href="{{ route('products.browse') }}" class="btn btn-view mini">Continue Shopping</a>
                        </div>
                    </div>
                    <button type="button" class="cart-toast-close" aria-label="Close">✕</button>
                </div>
            @endif

            <!-- Price and seller -->
            <div class="price-row details-price-row">
                @if (isset($product->original_price) && $product->original_price > $product->unit_price)
                    <span class="price-old">${{ number_format($product->original_price, 2) }}</span>
                @endif
                <span class="price price-large">${{ number_format($product->unit_price, 2) }}</span>
                <div class="small-meta">
                    <span class="muted"> • {{ $product->category->category_name ?? 'Uncategorized' }}</span>
                    @if($product->supplier)
                        <span class="muted"> • Sold by: {{ $product->supplier->supplier_name }}</span>
                    @endif
                </div>
            </div>

            <!-- Stock and quick info -->
            <div class="quick-info">
                <p><strong>Stock:</strong> {{ $product->inventory->stock_quantity ?? 0 }} available</p>
                <p><strong>SKU:</strong> {{ $product->product_code ?? $product->product_id }}</p>
            </div>

            <!-- Description -->
            <div class="product-long-desc">
                <h3>Product Details</h3>
                <p>{{ $product->description }}</p>
            </div>

            <!-- Add to Cart (use browse button style) -->
            <div class="cta-row">
                @if ($product->inventory && $product->inventory->stock_quantity > 0)
                    <form method="POST" action="{{ route('products.addToCart', $product->product_id) }}" class="add-to-cart-form">
                        @csrf

                        <!-- quantity row -->
                        <div class="qty-row">
                            <label for="quantity">Quantity: </label>

                            <div class="qty-control" role="group" aria-label="Quantity control">
                                <button type="button" class="qty-btn qty-decrement" aria-label="Decrease quantity">−</button>

                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    min="1"
                                    step="1"
                                    max="{{ $product->inventory->stock_quantity }}"
                                    value="1"
                                    required
                                    class="qty-input"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                >

                                <button type="button" class="qty-btn qty-increment" aria-label="Increase quantity">+</button>
                            </div>
                        </div>

                        <!-- buttons row placed below quantity -->
                        <div class="button-row">
                            <button type="submit" class="btn btn-cart">Add to Cart</button>
                            <a href="{{ route('products.browse') }}" class="btn btn-view">Back to Products</a>
                        </div>
                    </form>
                @else
                    <p class="out-of-stock-label">This product is currently out of stock.</p>
                @endif
            </div>

            {{-- ...existing code... --}}
        </div>
    </div>
</div>

<!-- Inline JS to handle increment/decrement for the qty control -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.add-to-cart-form').forEach(function (form) {
            var input = form.querySelector('.qty-input');
            if (!input) return;

            var dec = form.querySelector('.qty-decrement');
            var inc = form.querySelector('.qty-increment');

            var min = parseInt(input.getAttribute('min') || '1', 10);
            var max = parseInt(input.getAttribute('max') || Number.MAX_SAFE_INTEGER, 10);

            function setVal(v) {
                v = Math.max(min, Math.min(max, Math.round(Number(v) || min)));
                input.value = v;
                dec.disabled = v <= min;
                inc.disabled = v >= max;
            }

            // Set initial states
            setVal(parseInt(input.value || min, 10));

            // click handlers
            dec.addEventListener('click', function () { setVal(Number(input.value) - 1); });
            inc.addEventListener('click', function () { setVal(Number(input.value) + 1); });

            // Ensure typed values remain integers/witin range
            input.addEventListener('input', function () {
                // sanitize non-numeric input
                var v = parseInt(this.value, 10);
                if (isNaN(v)) v = min;
                setVal(v);
            });

            // Keep controls accurate if invalid changes occur on blur
            input.addEventListener('blur', function () {
                setVal(parseInt(this.value || min, 10));
            });
        });
    });

    // Toast behavior for product added message
    document.addEventListener('DOMContentLoaded', function () {
        var toast = document.getElementById('cart-toast');
        if (!toast) return;

        // Slide-in
        toast.classList.add('cart-toast-enter');
        // Auto-dismiss after 4.5s
        var dismissTimeout = setTimeout(function () {
            toast.classList.add('cart-toast-exit');
            setTimeout(function () { toast.remove(); }, 300); // match CSS animation duration
        }, 4500);

        // Close button
        var close = toast.querySelector('.cart-toast-close');
        if (close) {
            close.addEventListener('click', function () {
                clearTimeout(dismissTimeout);
                toast.classList.add('cart-toast-exit');
                setTimeout(function () { toast.remove(); }, 200);
            });
        }

        // If user clicks view cart/continue, dismiss toast immediately
        toast.querySelectorAll('.cart-toast-actions a').forEach(function (btn) {
            btn.addEventListener('click', function () {
                clearTimeout(dismissTimeout);
                toast.classList.add('cart-toast-exit');
                setTimeout(function () { toast.remove(); }, 200);
            });
        });
    });
</script>

@endsection
