# Bitcoin-Price-Plugin
Bitcoin Price Plugin to the osclass

Read readme.txt for using this plugin.



// 1. Edit bitcoinpp/index.php
// 2.  Find this code:

`$rates = osc_file_get_contents("https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=[YOUR API KEY]&start=1&limit=1&convert=USD");
`

// 3. Register coinmarket.com and generate new API KEY for you and replace [YOUR API KEY].

// 4. Edit item.php

// 5. Scroll to the line:593

// 6. Find this:

`<span class="long-price-fix" title="<?php echo osc_esc_html(osc_item_formated_price()); ?>"><?php echo osc_item_formated_price(); ?></br></span>
`

// 7. Paste:
`<?php bitcoinpp_price(); ?>`

// 8. 
Code completed:

`<span class="long-price-fix" title="<?php echo osc_esc_html(osc_item_formated_price()); ?>"><?php echo osc_item_formated_price(); ?></br><?php bitcoinpp_price(); ?></span>
`

// 9. Edit crontab 

`*/30 *	* * *	root	wget yourdomain.com/index.php?page=cron -O /dev/null`

// 10. Finished. Have nice day! :)
