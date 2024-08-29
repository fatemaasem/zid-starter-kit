<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Handle the webhook payload here
        $payload = $request->all();

        // Process the webhook event
        // Example: Log the event
       // Log::info('Webhook received:', $payload);

        // Respond to Zid
        return response()->json(['status' => 'Webhook received']);
    }
}
