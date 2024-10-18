<?php

namespace Database\Seeders;

use App\Models\Delivery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //// Get the existing purchase orders created in the last week, last month, and last 10 days
        $purchases = Purchase::whereIn('po_number', [
            'PO-0001-10' // Adjust these PO numbers based on your seeder data
        ])->get(); // Assuming you already have some PO numbers to match

        // Define delivery data
        $deliveries = [
            [
                'status' => 'In Progress',
                'date_delivered' => 'N/A',
                'purchase_id' => $purchases[0]->id, // Link to the first purchase
            ],
            [
                'status' => 'In Progress',
                'date_delivered' => 'N/A',// Date from last month
                'purchase_id' => $purchases[1]->id, // Link to the second purchase
            ],
            [
                'status' => 'In Progress',
                'date_delivered' => 'N/A', // Date from last 10 days
                'purchase_id' => $purchases[2]->id, // Link to the third purchase
            ],
        ];

        // Insert delivery records
        foreach ($deliveries as $deliveryData) {
            Delivery::create([
                'status' => $deliveryData['status'],
                'date_delivered' => $deliveryData['date_delivered'],
                'old_po_id' => null, // Set this as necessary, or you can assign an existing PO ID if required
                'purchase_id' => $deliveryData['purchase_id'],
            ]);
        }
    }
}
