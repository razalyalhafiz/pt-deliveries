<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Shop;
use App\Http\Resources\Shop as ShopResource;
use \OhMyBrew\ShopifyApp\Facades\ShopifyApp;
use \OhMyBrew\BasicShopifyAPI;

class ProductController extends Controller
{
    /**
    * Display the products of a specific collection.
    *
    * @param  \Illuminate\Http\Request  $request 
    * @return \Illuminate\Http\Response
    */
   public function getProductsOfCollection(Request $request)
   {
        $coll_id = $request->collectionno;
        $api = new BasicShopifyAPI;
        $api->setApiKey('e1ef58708fea1eee57e4b47ba6635a05');
        $api->setApiSecret('07e58195ac41a91814185f16bac55245');
        $api->setSession('pasartap-dev.myshopify.com', '0b7656f350ef3d1a1453ac4102250334');
        
        $response = $api->request('GET', '/admin/products/count.json?collection_id=' . $coll_id, array());
        $count = $response->body->count;

        if ($count == null || $count == 0) {
            return json_encode(array("result" => "false" , "data" => null));
        }

        $loop = ceil($count / 250);
        $feat_coll_products = array();
        $market_name = "Chow Kit";

        for ($page = 1; $page <= $loop; $page++) {
            $response = $api->request('GET', '/admin/products.json?collection_id='. $coll_id .'&limit=250&page='. $page, array());
            $products = $response->body->products;

            if ($products == null) {
                return json_encode(array("result" => "false" , "data" => null));
            }

            foreach ($products as  $product) {
                if (count($feat_coll_products) < 15) {
                    if (strpos($product->tags, $market_name) !== false) {     
                        $feat_coll_products[] = $product;         
                    }
                } else {
                    break;
                }
            }
        
            if (count($feat_coll_products) >= 15) {
                break;
            }
        }

        return json_encode(array("result" => "true" , "data" => $feat_coll_products));
   }
}
