<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ config('shopify-app.app_name') }}</title>

        <!-- <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
              integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
              crossorigin="anonymous"> -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
        <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

        @yield('styles')
        <style>           
            a.btn--router .btn__content {
                font-family: 'Raleway', sans-serif;
                font-size: 18px;
                font-weight: bold;
                text-transform: none;               
            }

            .toolbar__content a {
                text-decoration: none;
            }

            .headline {
                padding-left: 0;
                margin-top: 8px !important;
            }
        </style>
    </head>
    <body>
      <div id="app">
        <v-app id="inspire">
          <app></app>
        </v-app>
      </div>

    <script src="https://cdn.shopify.com/s/assets/external/app.js?{{ date('YmdH') }}"></script>
    <script type="text/javascript">
        // Init ShopifyApp
        ShopifyApp.init({
            apiKey: '{{ config('shopify-app.api_key') }}',
            shopOrigin: 'https://{{ ShopifyApp::shop()->shopify_domain }}',
            debug: false,
            forceRedirect: true
        });
        
        // Init ShopifyApp.Bar
        ShopifyApp.ready(function(){
            ShopifyApp.Bar.initialize({
                icon: 'https://cdn.shopify.com/s/files/1/1030/8703/files/pt_deliveries_logo.png?17883826825238409283'
            });
        });

        // Set shop_id cookie
        document.cookie = "ptdeliveries_shop_id={{ ShopifyApp::shop()->id }}";
        
        //Set page title
        window.mainPageTitle = 'PT Deliveries';
    </script>

      @include('shopify-app::partials.flash_messages')

      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
      <script src="{{ asset('js/app.js') }}"></script>
      @yield('scripts')
  </body>
</html>
