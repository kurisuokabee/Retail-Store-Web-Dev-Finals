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
        onsubmit="return confirm('Y u du dis?');">
        @csrf
        @method('DELETE')
        <button type="Submit">Smite thine Customer</button>
    </form>
    <a href="{{ route('customers.edit', $customer->customer_id) }}">Edit Customer</a>
    <a href="{{ route('customers.index') }}">Back To Customers List</a>
</div>
</div>
