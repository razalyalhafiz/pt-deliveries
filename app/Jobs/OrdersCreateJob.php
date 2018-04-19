<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Delivery;
use App\Models\DeliveryHour;
use App\Models\Market;
use App\Models\Shop;
use \OhMyBrew\ShopifyApp\Facades\ShopifyApp;
use \OhMyBrew\BasicShopifyAPI;
use Carbon\Carbon;

class OrdersCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Shop's myshopify domain
     *
     * @var string
     */
    public $shopDomain;

    /**
     * The webhook data
     *
     * @var object
     */
    public $data;

    /**
     * Create a new job instance.
     *
     * @param string $shopDomain The shop's myshopify domain
     * @param object $webhook The webhook data (JSON decoded)
     *
     * @return void
     */
    public function __construct($shopDomain, $data)
    {
        $this->shopDomain = $shopDomain;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->data == null) {
            return;
        }

        $data = $this->data;
        $market = '';
        $delivery_date = '';
        $delivery_time = '';

        // Extract required information
        $customer_name = $data->customer->first_name . ' ' . $data->customer->last_name;
        $address = $data->shipping_address->address1 . ' ' . $data->shipping_address->address2 . ' ' . $data->shipping_address->zip . ' ' . $data->shipping_address->city;     

        foreach ($data->note_attributes as $key => $value) {	
            if ($value->name == 'market' ) {
                $market = $value->value;
            }  		
            if ($value->name == 'delivery_date' ) {
                $delivery_date = $value->value;
            }			
            if ($value->name == 'delivery_time' ) {
                $delivery_time = $value->value;
            }                 
        }         

        $shop_id = Shop::where('shopify_domain', $this->shopDomain)->value('id') ?? -1;

        $market_id = Market::where('shop_id', $shop_id)
                                ->where('market_name', $market)
                                ->value('id') ?? -1;

        $timeslot_id = DeliveryHour::where('shop_id', $shop_id)
                                    ->where('market_id', $market_id)
                                    ->value('id') ?? -1;

        // Create a new delivery in the database
        $delivery = Delivery::create(['shop_id' => $shop_id,
                                        'market_id' => $market_id,
                                        'timeslot_id' => $timeslot_id,
                                        'order_id' => $data->order_number,
                                        'delivery_date' => $delivery_date,
                                        'delivery_time' => $delivery_time,
                                        'customer' =>  $customer_name,
                                        'phone' => $data->phone ?? $data->customer->phone ?? $data->shipping_address->phone ?? $data->billing_address->phone,
                                        'address' => $address,
                                        'assignee' => '',
                                        'tookan_id' => '',
                                        'status' => 'open'
                                    ]);

        // Update order in Shopify
        $order = [
            'order' => [
                'id' => $data->id,
                'tags' => $market
            ]        
        ];  

        $api = new BasicShopifyAPI;
        $api->setApiKey('e1ef58708fea1eee57e4b47ba6635a05');
        $api->setApiSecret('07e58195ac41a91814185f16bac55245');

        $token = Shop::where('shopify_domain', $this->shopDomain)->value('shopify_token');
        $api->setSession($this->shopDomain, $token);
        
        $response = $api->request('PUT', '/admin/orders/' . $data->id . '.json', $order);

        // TODO:  Figure out why this doesn't work
        // $shop = ShopifyApp::shop();
        // echo($shop->shopify_domain);
        // $response = $shop->api()->request('PUT', '/admin/orders/' . $data->id . '.json', $order);
    }
}
