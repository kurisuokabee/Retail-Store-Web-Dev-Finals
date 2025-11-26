<div>
    <h1>Customer Details</h1>
    <div>
        <h2>{{$customer->username }}</h2>
        <p>Email: {{$customer->email }}</p>
        <p>First Name: {{$customer->first_name }}</p>
        <p>Last Name: {{$customer->last_name }}</p>
        <p>Date Of Birth: {{$customer->date_of_birth }}</p>
        <p>Phone: {{$customer->phone }}</p>
        <p>Address: {{$customer->address }}</p>
        <p>Created At: {{$customer->created_at }}</p>
    </div>
    <form action="{{ route('customers.destroy', $customer->customer_id) }}" method="POST" 
        onsubmit="return confirm('Delete account?');">
        @csrf
        @method('DELETE')
        <button type="Submit">Delete your account?</button>
    </form>
    <a href="{{ route('customers.edit', $customer->customer_id) }}">Edit information</a>

    <div style="margin-top: 20px;">
        <a href="{{ route('products.browse') }}">Continue Shopping</a>
    </div>
</div>
</div>
