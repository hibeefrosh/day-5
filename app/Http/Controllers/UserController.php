<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;

class UserController extends Controller
{


    public function index()
    {
 
        $user = auth()->user();

        $subscriptionPlans = Subscription::all();

        return view('dashboard', compact('user', 'subscriptionPlans'));
    }

    public function addRecord(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'record_data' => 'required|string',
        ]);

        if ($user->subscription) {
            $recordLimit = $user->subscription->limit;

            // Check if the user has reached the record limit for the day
            if ($user->records()->whereDate('created_at', now())->count() >= $recordLimit) {
                return redirect()->back()->with('error', 'You have reached your daily record limit.');
            }
            // Create a new record for the user
            $user->records()->create(['data' =>$validatedData['record_data']]);

            return redirect()->back()->with('success', 'Record added successfully.');
        }

        return redirect()->route('dashboard')->with('error', 'You need to purchase a subscription plan to add records.');
    }

    public function purchaseSubscription(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'subscription_plan' => 'required|exists:subscriptions,id',
        ]);

        $subscriptionPlan = Subscription::findOrFail($validatedData['subscription_plan']);

        // Update the user's subscription plan
        $user->update(['subscription_id' => $subscriptionPlan->id]);

        return redirect()->route('dashboard')->with('success', 'Subscription purchased successfully.');
    }

}
