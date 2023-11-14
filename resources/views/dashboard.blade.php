@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
            @endif

            <div class="card">
                <div class="card-header">Subscription Plan</div>
                <div class="card-body">
                    @if ($user->subscription)
                    <h5 class="card-title">{{ $user->subscription->name }}</h5>
                    <p class="card-text">Limit: {{ $user->subscription->limit }} records per day</p>
                    <p class="card-text">Price: ${{ $user->subscription->price }}</p>
                    <a href="#" data-toggle="modal" data-target="#purchaseSubscriptionModal">Change Subscription Plan</a>
                    @else
                    <p class="card-text">
                        No subscription plan. You have to purchase a plan to use this app.
                        <a href="#" data-toggle="modal" data-target="#purchaseSubscriptionModal">Purchase a Plan</a>
                    </p>
                    @endif
                </div>

            </div>

            <div class="mt-3">
                <h3>Records</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Data</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->records as $key => $record)
                        <tr>
                            <td>{{ $key + 1 }}</td> <!-- Use loop counter to display numbers starting from 1 -->
                            <td>{{ $record->data }}</td>
                            <td>{{ \Carbon\Carbon::parse($record->created_at)->format('F j, Y h:i A') }}</td> <!-- Format timestamp into human-readable date -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="col-md-4">
            @if(auth()->user()->subscription_id)
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addRecordModal">Add Record</button>
            @endif
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="btn btn-danger " type="submit">Logout</button>
            </form>

            <!-- Purchase Subscription Modal -->
            <div class="modal fade" id="purchaseSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="purchaseSubscriptionModalLabel" aria-hidden="true">
                <!-- Purchase Subscription Modal -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="purchaseSubscriptionModalLabel">Purchase Subscription</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('purchase-subscription', ['user' => auth()->user()]) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="subscription_plan">Select Subscription Plan:</label>
                                    <select name="subscription_plan" id="subscription_plan" class="form-control" required>
                                        @foreach ($subscriptionPlans as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->name }} - ${{ $plan->price }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="card_number">Card Number:</label>
                                    <input type="text" name="card_number" id="card_number" class="form-control" placeholder="Card Number" required>
                                </div>

                                <div class="form-group">
                                    <label for="expiration_date">Expiration Date:</label>
                                    <input type="text" name="expiration_date" id="expiration_date" class="form-control" placeholder="MM/YYYY" required>
                                </div>

                                <div class="form-group">
                                    <label for="cvv">CVV:</label>
                                    <input type="text" name="cvv" id="cvv" class="form-control" placeholder="CVV" required>
                                </div>

                                <div class="form-group">
                                    <label for="bank_name">Bank Name:</label>
                                    <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Bank Name" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Purchase</button>
                            </form>

                        </div>
                    </div>
                </div>


            </div>

            <!-- Add Record Modal -->
            <div class="modal fade" id="addRecordModal" tabindex="-1" role="dialog" aria-labelledby="addRecordModalLabel" aria-hidden="true">
                <!-- Add Record Modal -->
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addRecordModalLabel">Add Record</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('add-record', ['user' => auth()->user()]) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="record_data">Record Data:</label>
                                    <textarea name="record_data" id="record_data" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Record</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection