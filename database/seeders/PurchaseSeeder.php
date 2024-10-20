<?php

namespace Database\Seeders;

use App\Models\Delivery;
use App\Models\Purchase;
use App\Models\PurchaseDetail; // Ensure this is correctly named as 'PurchaseDetail' not 'PurchaseDetails'
use App\Models\PurchaseDetails;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define purchase data with creation dates and item IDs
        $purchases = [
            [
                'created_at' => now()->subWeek(),
                'item_id' => 11, // Change to a valid item ID
                'quantity' => 150,
            ],
            [
                'created_at' => now()->subMonth(),
                'item_id' => 9, // Change to a valid item ID
                'quantity' => 50,
            ],
            [
                'created_at' => now()->subDays(10),
                'item_id' => 12, // Change to a valid item ID
                'quantity' => 100,
            ],
        ];

        // Loop through each purchase and create the purchase order and details
        foreach ($purchases as $purchaseData) {
            // Generate a unique PO number
            $po_number = $this->generatePurchaseOrderNumber();

            // Create the purchase order
            $purchase = Purchase::create([
                'po_number' => $po_number, // Unique PO number
                'supplier_id' => 3, // Set to a valid supplier ID
                'user_id' => 1, // Set to a valid user ID
                'created_at' => $purchaseData['created_at'], // Set created_at date
                'updated_at' => $purchaseData['created_at'], // Set updated_at date
            ]);

            // Create the purchase detail
            PurchaseDetails::create([
                'item_id' => $purchaseData['item_id'],
                'purchase_id' => $purchase->id,
                'po_number' => $purchase->po_number,
                'purchase_quantity' => $purchaseData['quantity'],
                'created_at' => $purchaseData['created_at'], // Set created_at date
                'updated_at' => $purchaseData['created_at'], // Set updated_at date
            ]);

            Delivery::create([
                'status' => "In Progress", // Set delivery status
                'date_delivered' => "N/A", // Random date within the last week
                'purchase_id' => $purchase->id,
                'created_at' => $purchaseData['created_at'], // Set created_at date same as purchase
                'updated_at' => $purchaseData['created_at'], // Set updated_at date same as purchase
            ]);
        }
    }

    /**
     * Generate a unique purchase order number.
     *
     * @return string
     */
    private function generatePurchaseOrderNumber()
    {
        do {
            $randomNumber = random_int(0, 9999);
            $formattedNumber = str_pad($randomNumber, 4, '0', STR_PAD_LEFT);
            $purchaseOrderNumber = 'PO-' . $formattedNumber . '-' . now()->format('mdY');

            // Check if the purchase order number already exists
            $exists = Purchase::where('po_number', $purchaseOrderNumber)->exists();
        } while ($exists);

        // Return the unique purchase order number
        return $purchaseOrderNumber;
    }
}
