{{-- <div>
    <!-- Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead -->
    <div>
        <a href={{ route('customers.create') }}>Create New Customer</a>
    </div>
    @foreach ($customers as $customer)
    <div>
        <h2><a href="{{ route('customers.show', $customer->customer_id) }}">{{ $customer->username }}</a></h2>
        <p>Email: {{ $customer->email }}</p>
        <p>Phone: {{ $customer->phone }}</p>
    </div>
    @endforeach

    ignore this muna
    
</div> --}}
