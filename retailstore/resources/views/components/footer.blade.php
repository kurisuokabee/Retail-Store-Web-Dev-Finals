<footer class="site-footer" role="contentinfo">
	<div class="footer-inner">
		<div class="footer-col footer-about">
			<a class="footer-brand" href="{{ route('products.browse') }}">
				<img src="{{ asset('images/logo.png') }}" alt="Budega logo" class="footer-logo">
				{{-- <span class="footer-brand-text">Budega</span> --}}
			</a>
			<p class="footer-tag">Your one-stop shop for everyday essentials.</p>
			<div class="footer-small">© {{ date('Y') }} Budega. All rights reserved.</div>
		</div>

		<div class="footer-col footer-payments">
			<h4>Payment Methods</h4>
			<p class="muted">We accept</p>
			<div class="payment-icons">
				{{-- Place your payment images in public/images/payments/, e.g. visa.png, mastercard.png --}}
				<img src="{{ asset('images/payments/visa.png') }}" alt="Visa" loading="lazy">
				<img src="{{ asset('images/payments/mastercard.png') }}" alt="Mastercard" loading="lazy">
				<img src="{{ asset('images/payments/paypal.png') }}" alt="PayPal" loading="lazy">
				<img src="{{ asset('images/payments/gcash.png') }}" alt="GCash" loading="lazy">
				{{-- Add/remove images as needed --}}
			</div>
		</div>

		<!-- NEW: Logistics partners column (place images in public/images/logistics/) -->
		<div class="footer-col footer-logistics">
			<h4>Logistics Partners</h4>
			<p class="muted">We ship with</p>
			<div class="logistics-icons">
				{{-- Place your logistics images in public/images/logistics/, e.g. jandt.png, lbc.png --}}
				<img src="{{ asset('images/logistics/jandt.png') }}" alt="J&T Express" loading="lazy">
				<img src="{{ asset('images/logistics/lbc.png') }}" alt="LBC" loading="lazy">
				<img src="{{ asset('images/logistics/ninja.png') }}" alt="Ninja Van" loading="lazy">
				<img src="{{ asset('images/logistics/2go.png') }}" alt="2GO" loading="lazy">
				{{-- Add/remove images as needed --}}
			</div>
		</div>

		<div class="footer-col footer-founders">
			<h4>Founders</h4>
			<ul>
				<li>Vince Angelo Tactay</li>
				<li>Sev Jand Daniel Torreon</li>
				<li>Cian Stephen Lee</li>
				<li>Rico Nathaniel Tan</li>
				<li>Tyler John Uri</li>
			</ul>
		</div>

		<div class="footer-col footer-links">
			<h4>Quick Links</h4>
			<ul>
				<li><a href="{{ route('products.browse') }}">Shop</a></li>
				<li><a href="{{ route('auth.login') }}">Login</a></li>
				<li><a href="{{ route('auth.register') }}">Register</a></li>
				<li><a href="{{ url('/terms-conditions') }}">Terms & Conditions</a></li>
				<li><a href="{{ url('/privacy') }}">Privacy Policy</a></li>
			</ul>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="container">
			<div class="left">Made with ♥ for online shopping.</div>
			<div class="right muted">Contact Us: <a href="mailto:support@budega.example">support@budega.example</a></div>
		</div>
	</div>
</footer>
