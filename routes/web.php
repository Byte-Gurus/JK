<?php


use App\Livewire\Components\CreditManagement\CreditTable;
use App\Livewire\Components\InventoryManagement\InventoryTable;
use App\Livewire\Components\Logout;
use App\Livewire\Components\PurchaseAndDeliveryManagement\PrintPurchaseOrderDetails;
use App\Livewire\Components\PurchaseAndDeliveryManagement\Purchase\PurchaseOrderForm;
use App\Livewire\Components\ReportManagement\BackorderedItemsReport;
use App\Livewire\Components\ReportManagement\CustomerCreditListReport;
use App\Livewire\Components\ReportManagement\DailySalesReport;
use App\Livewire\Components\ReportManagement\DamagedItemsReport;
use App\Livewire\Components\ReportManagement\ExpiredItemsReport;
use App\Livewire\Components\ReportManagement\FastMovingItemsReport;
use App\Livewire\Components\ReportManagement\MonthlySalesReport;
use App\Livewire\Components\ReportManagement\ReorderListReport;
use App\Livewire\Components\ReportManagement\SalesReturnReport;
use App\Livewire\Components\ReportManagement\SlowMovingItemsReport;
use App\Livewire\Components\ReportManagement\StockonhandReport;
use App\Livewire\Components\ReportManagement\VoidedTransactionsReport;
use App\Livewire\Components\ReportManagement\WeeklySalesReport;
use App\Livewire\Components\ReportManagement\YearlySalesReport;
use App\Livewire\Components\Sales\SalesTransactionHistory;
use App\Livewire\Pages\CashierPage;
use App\Livewire\Pages\CreditManagementPage;
use App\Livewire\Pages\CustomerManagementPage;
use App\Livewire\Pages\Dashboard;
use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\InventoryClerkPage;
use App\Livewire\Pages\InventoryManagementPage;
use App\Livewire\Pages\ItemManagementPage;
use App\Livewire\Pages\LoginPage;
use App\Livewire\Pages\PurchaseAndDeliveryManagementPage;
use App\Livewire\Pages\ReportManagement;
use App\Livewire\Pages\SupplierManagementPage;
use App\Livewire\Pages\TestPage;
use App\Livewire\Pages\UserManagementPage;
use Illuminate\Support\Facades\Route;

//login
Route::get('/logout', Logout::class)->name('logout');
Route::get('/', LoginPage::class)->name('login')->middleware(['CheckIfLoggedIn', 'ClearSession']);

Route::middleware(['auth', 'auth.session'])->group(function () {


    //test
    Route::get('/test', TestPage::class)->name('test');


    //redirect to page of the designated role
    Route::group(['middleware' => ['RedirectIfLoggedIn']], function () {

        //AdminHomePage
        Route::get('/admin', HomePage::class)->name('admin.index');

        //Dashboard

        Route::get('/admin/Dashboard', Dashboard::class)->name('dashboard.index');

        //UserManagamenent
        Route::get('/admin/UserManagement', UserManagementPage::class)->name('usermanagement.index');

        //SupplierManagement
        Route::get('admin/SupplierManagement', SupplierManagementPage::class)->name('suppliermanagement.index');

        //PurchaseAndDeliveryManagement
        Route::get('admin/PurchaseAndDeliveryManagement', PurchaseAndDeliveryManagementPage::class)->name('purchaseanddeliverymanagement.index');

        //PurchaseOrderForm
        Route::get('admin/PurchaseOrderForm', PurchaseOrderForm::class)->name('purchaseorderform.index');

        //ItemManagement
        Route::get('admin/ItemManagement', ItemManagementPage::class)->name('itemmanagement.index');

        //CustomerManagement
        Route::get('admin/CustomerManagement', CustomerManagementPage::class)->name('customermanagement.index');

        //InventoryManagement
        Route::get('admin/InventoryManagement/{sku_code?}', InventoryManagementPage::class)->name('inventorymanagement.index');


        // Route::get('admin/InventoryManagement/InventoryTable/{sku_code}', InventoryTable::class)->name('inventorytable.index');

        //InventoryManagement
        Route::get('admin/SalesTransaction', CashierPage::class)->name('cashierpage.index');

        //CreditManagement
        // Route::get('admin/CreditManagement', CreditManagementPage::class)->name('creditmanagement.index');
        Route::get('admin/CreditManagement/{credit_id?}', CreditManagementPage::class)->name('creditmanagement.index');

        //ReportManagement
        Route::get('admin/ReportManagement', ReportManagement::class)->name('reportmanagement.index');

        //CashierHomepage
        Route::get('/cashier', CashierPage::class)->name('cashier.index');

        //InventoryClerk Homepage
        Route::get('/inventoryClerk', InventoryClerkPage::class)->name('inventoryclerk.index');

        // Reports


        // Daily Reports
        // Route::get('/download-pdf', DailySalesReport::class);
        // Route::get('admin/ReportManagement/dailySalesReport', DailySalesReport::class)->name('daily.sales.report');

        // Weekly Reports

        Route::get('admin/ReportManagement/weeklySalesReport', WeeklySalesReport::class)->name('weekly.sales.report');

        // Monthly Reports

        Route::get('admin/ReportManagement/monthlySalesReport', MonthlySalesReport::class)->name('monthly.sales.report');

        // Yearly Reports

        Route::get('admin/ReportManagement/yearlySalesReport', YearlySalesReport::class)->name('yearly.sales.report');

        // Yearly Reports

        Route::get('admin/ReportManagement/voidedTransactions', VoidedTransactionsReport::class)->name('voidedtransactions.sales.report');

        // Sales Return Reports

        Route::get('admin/ReportManagement/salesReturnReport', SalesReturnReport::class)->name('salesreturn.sales.report');

        // Stock-on-hand Reports

        Route::get('admin/ReportManagement/stockonhandReport', StockonhandReport::class)->name('stockonhand.sales.report');

        // Slow-moving Items Reports

        Route::get('admin/ReportManagement/slowMovingItemsReport', SlowMovingItemsReport::class)->name('slowmovingitems.sales.report');

        // Fast-moving Items Reports

        Route::get('admin/ReportManagement/fastMovingItemsReport', FastMovingItemsReport::class)->name('fastmovingitems.sales.report');

        // Reorder List Reports

        Route::get('admin/ReportManagement/reorderListReport', ReorderListReport::class)->name('reorderlist.sales.report');

        // Backordered Items Reports

        Route::get('admin/ReportManagement/backorderedItemsReport', BackorderedItemsReport::class)->name('backordereditems.sales.report');

        // Expired Items List

        Route::get('admin/ReportManagement/expiredItemsReport', ExpiredItemsReport::class)->name('expireditems.sales.report');

        // Damaged Items List

        Route::get('admin/ReportManagement/damagedItemsReport', DamagedItemsReport::class)->name('damageditems.sales.report');

        // Customer Credit List

        Route::get('admin/ReportManagement/customerCreditListReport', CustomerCreditListReport::class)->name('customercreditlist.sales.report');

        // Print Purchase Order Details

        Route::get('admin/ReportManagement/printPurchaseOrderDetails', PrintPurchaseOrderDetails::class)->name('printpurchaseorderdetails.sales.report');

    });
});


//homepage
// Route::get('/admin', HomePage::class)->name('admin.index')->middleware('RedirectIfLoggedIn');

//Dashboard
// Route::get('/admin/Dashboard', Dashboard::class)->name('dashboard.index')->middleware('RedirectIfLoggedIn');

//UserManagamenent
// Route::get('/admin/UserManagement', UserManagementPage::class)->name('usermanagement.index')->middleware('RedirectIfLoggedIn');

//SupplierManagement
// Route::get('admin/SupplierManagement', SupplierManagementPage::class)->name('suppliermanagement.index')->middleware('RedirectIfLoggedIn');



//OrderAndDeliveryManagement
// Route::get('admin/PurchaseAndDeliveryManagement', PurchaseAndDeliveryManagementPage::class)->name('purchaseanddeliverymanagement.index')->middleware('RedirectIfLoggedIn');

//ItemManagement
// Route::get('admin/ItemManagement', ItemManagementPage::class)->name('itemmanagement.index')->middleware('RedirectIfLoggedIn');

//CustomerManagement
// Route::get('admin/CustomerManagement', CustomerManagementPage::class)->name('customermanagement.index')->middleware('RedirectIfLoggedIn');

//InventoryManagement
// Route::get('admin/InventoryManagement', InventoryManagementPage::class)->name('inventorymanagement.index')->middleware('RedirectIfLoggedIn');

// Route::get('/cashier', CashierPage::class)->name('cashier.index')->middleware('RedirectIfLoggedIn');
