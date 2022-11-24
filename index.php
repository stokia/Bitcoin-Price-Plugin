<?php
/*
Plugin Name: Bitcoin Price Plugin
Plugin URI: https://github.com/stokia
Description: Get BTC/USD price from Coinmarketcap
Version: 1.0
Author: stokia
Author URI: https://github.com/stokia
Short Name: bitcoinpp
Plugin update URI: bitcoinpp
*/


	function bitcoinpp_install() {
		osc_set_preference("rates", '[{"id": "bitcoin", "name": "Bitcoin", "symbol": "BTC", "rank": "1", "price_usd": "8348.66", "price_btc": "1.0", "24h_volume_usd": "4429300000.0", "market_cap_usd": "139363555230", "available_supply": "16692925.0", "total_supply": "16692925.0", "max_supply": "21000000.0", "percent_change_1h": "1.84", "percent_change_24h": "1.62", "percent_change_7d": "27.16", "last_updated": "1511278452", "price_huf": "2225836.2426", "24h_volume_huf": "1180895673000.0000000000", "market_cap_huf": "37155717460004"}]', "bitcoinpp");
		bitcoinpp_get_data();
	}

	function bitcoinpp_uninstall() 
	{
		Preference::newInstance()->delete(array("s_section" => "bitcoinpp"));
	}

	function bitcoinpp_get_data() 
	{
		$rates = osc_file_get_contents("https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=[YOUR API KEY]&start=1&limit=1&convert=USD");
		osc_set_preference("rates", $rates, "bitcoinpp");
	}
	
	function bitcoinpps_price() 
	{
		if(osc_item_price()!=NULL && osc_item_price()!='' && osc_item_price()!=0) 
		{ 
			$rates = json_decode(osc_get_preference("rates", "bitcoinpp"), true);
			
			if(osc_item_currency() == "USD")	// Only request USD/BTC price!
			{
				$btcprice = 0;
				
				$btcprice=$rates['data'][0]['quote']['USD']['price'];	//JSON code get from database and in the array read necessary data
				if($btcprice!=0)	//if btc price not 0
				{ 	
					$price = osc_item_price()/(1000000*$btcprice); //Fiat currency divided by btc price
					$currencyFormat = osc_locale_currency_format();
					$currencyFormat = str_replace('{NUMBER}', number_format($price, 8, osc_locale_dec_point(), osc_locale_thousands_sep()), $currencyFormat);
					$currencyFormat = str_replace('{CURRENCY}', 'BTC', $currencyFormat);
					echo '<span class="bitcoinpp_price" >'.$currencyFormat.'</span>';
				}
			}
		}
	}

	/**
	* ADD HOOKS
	*/
	osc_register_plugin(osc_plugin_path(__FILE__), 'bitcoinpp_install');
	osc_add_hook(osc_plugin_path(__FILE__)."_uninstall", 'bitcoinpp_uninstall');

	osc_add_hook('cron_hourly', 'bitcoinpp_get_data');

	osc_add_filter('item_price', 'bitcoinpp_price', 10);
	
?>