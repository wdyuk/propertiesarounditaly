<?php 
$limit = 18;
if(!empty($_POST)){
    $params = $_POST;
}
else{
    $params = $_GET;
}

$queryparams = $params;
unset ($queryparams['url']);
	if (isset($queryparams['p'])) {
		unset ($queryparams['p']);
	}   


    $query = http_build_query($queryparams);
    if (empty($query)) {
        $query = '?';
    } else {
        $query = '?'.$query;
    }



$p = isset($_GET['p']) && is_numeric($_GET['p']) ? intval($_GET['p']) : 1;
$start = ($p - 1) * $limit;
//$conditions[] = 'status = 1';
$conditions = array();
$conditions[] = build_visible_property_where(isset($site['id']) ? $site['id'] : 0);

if(isset($_GET['orderby'])){
	$_SESSION['order_clause'] = $_GET['orderby'];
}

if (!isset($_SESSION['order_clause'])) {
	$_SESSION['order_clause'] = 'price DESC';
}
$details = '';

if ($pageData['id'] == 85) {
	$conditions[] = 'channel = "2"';
    $conditions[] = 'type IN ("","newbuild")';
    $details = true;
}
elseif($pageData['id'] == 86) {
    $conditions[] = 'channel = "2"';
    $conditions[] = 'type IN ("newbuild")';
    $details = true;
}
elseif(($pageData['id'] == 26)) {
    $conditions[] = 'type IN ("commercial")';
    $details = false;
}
elseif(($pageData['id'] == 87)) {
    $conditions[] = 'channel = "2"';
    $conditions[] = 'type IN ("commercial")';
    $details = false;
}
elseif($pageData['id'] == 88) {
    $conditions[] = 'channel ="2"';
    $conditions[] = 'type IN ("leisure")';
    $details = false;
}
elseif(($pageData['id'] == 89) || ($pageData['id'] == 13)) {
    $conditions[] = 'channel = "2"';
    $conditions[] = 'type IN ("agriculture")';
    $details = false;
}
elseif(($pageData['id'] == 90) || ($pageData['id'] == 17)) {
    $conditions[] = 'channel = "2"';
    $conditions[] = 'type IN ("development")';
    $details = false;
}
elseif($pageData['id'] == 9) {
	$conditions[] = 'channel = "1"';
    $details = true;
}
//Conditions  
    if(isset($params['bedrooms']) && !empty($params['bedrooms']))
    {
        if ($params['bedrooms'] == "5+") {
            $conditions[] = 'bedrooms >= "5"';
        } else {
        	$conditions[] = 'bedrooms = "' . $params['bedrooms'] . '"';
        }
    }
    // if ($rewriteData['url'] == '/rent/properties-to-let') {
    //     if(isset($params['let_agreed']) && !empty($params['let_agreed']))
    //     {
    //         if ($params['let_agreed'] != "on") {
    //             $conditions[] = 'web_status != "104"';
    //         }
    //     } else {
           
    //         $conditions[] = 'web_status != "104"';
            
    //     }
    // } else {
    //     if(isset($params['sstc']) || !empty($params['sstc']))
    //     {
    //         if ($params['sstc'] != "on") {
    //             $conditions[] = 'web_status != "3"';
    //         }
    //     } else {
    //         if (isset($params['sstc'])) {
    //             $params['sstc'] = "on";
    //         }
    //         $conditions[] = 'web_status != "3"';
            
    //     }
    // }

    if(isset($params['price']) && !empty($params['price']))
    {
        $priceparts = explode('_', $params['price']);
        $conditions[] = '(price >= ' . $priceparts[0] . ' AND price <= ' . $priceparts[1] . ')';
    }
    // if(isset($params['minprice']) && !empty($params['minprice']))
    // {
    //     $conditions[] = '(price >= ' .$params['minprice'] .')';
    // }
    // if(isset($params['maxprice']) && !empty($params['maxprice']))
    // {
    //     $conditions[] = '(price <= ' .$params['maxprice'] .')';
    // }
    // if(isset($params['added']) && !empty($params['added']))
    // {
    // 	$currentdate = date('Y-m-d H:i:s');
    //     if ($params['added'] == "24_Hours") {
    //     	$fromdate = date('Y-m-d H:i:s', strtotime('-24 hour'));
    //         $conditions[] = '(created_at >= "' . $fromdate . '" AND created_at <= "' . $currentdate . '")';
    //     }
    //     elseif ($params['added'] == "3_Days") {
    //     	$fromdate = date('Y-m-d H:i:s', strtotime('-3 days'));
    //         $conditions[] = '(created_at >= "' . $fromdate . '" AND created_at <= "' . $currentdate . '")';
    //     }
    //     elseif ($params['added'] == "7_Days") {
    //     	$fromdate = date('Y-m-d H:i:s', strtotime('-1 week'));
    //         $conditions[] = '(created_at >= "' . $fromdate . '" AND created_at <= "' . $currentdate . '")';
    //     }
    //     elseif ($params['added'] == "14_Days") {
    //     	$fromdate = date('Y-m-d H:i:s', strtotime('-2 weeks'));
    //         $conditions[] = '(created_at >= "' . $fromdate . '" AND created_at <= "' . $currentdate . '")';
    //     }
    // }
    if(isset($params['keywords']) && !empty($params['keywords']))
    {
    
       
        $orconditions = array();
        $orconditions[] = 'display_address LIKE "%' . $params['keywords'] . '%"';
        $orconditions[] = 'street LIKE "%' . $params['keywords'] . '%"';
        $orconditions[] = 'town LIKE "%' . $params['keywords'] . '%"';
        $orconditions[] = 'locality LIKE "%' . $params['keywords'] . '%"';
        $orconditions[] = 'county LIKE "%' . $params['keywords'] . '%"';
        $orconditions[] = 'type LIKE "%' . $params['keywords'] . '%"';
        $orconditions[] = 'description LIKE "%' . $params['keywords'] . '%"';
        $orconditions[] = 'bullet_points LIKE "%' . $params['keywords'] . '%"';
        $orconditions[] = 'additional_content LIKE "%' . $params['keywords'] . '%"';

        

        $conditions[] = '(' . implode(' OR ',  $orconditions) . ')';
    }
    if(isset($params['location']) && !empty($params['location']))
    {
        $orconditions = array();
        $orconditions[] = 'display_address LIKE "%' . $params['location'] . '%"';
        $orconditions[] = 'street LIKE "%' . $params['location'] . '%"';
        $orconditions[] = 'town LIKE "%' . $params['location'] . '%"';
        $orconditions[] = 'county LIKE "%' . $params['location'] . '%"';

        $keywords = trim($params['location']);
        if (strlen($keywords) < 4 && strlen($keywords) > 2) {
            if (stripos($keywords, 'york') === false) {
                if (stripos($keywords, 'YO') !== false) {
                    $params['location'] = $keywords.' ';
                    $orconditions = array();
                    $orconditions[] = 'postcode LIKE "'.$params['location'].'%"';

                }
            }
        }
        $conditions[] = '(' . implode(' OR ',  $orconditions) . ')';
    }


// if ($_SERVER['REMOTE_ADDR'] =='86.170.29.224') { 
//     echo '<pre>'.print_r($params, true).'</pre>';
//     echo implode(' AND ', $conditions);
//      echo '***';
// }
$properties = table_fetch_rows('properties',implode(' AND ', $conditions),$_SESSION['order_clause'], $start, $limit);
$total_rows = table_row_count('properties', implode(' AND ', $conditions));
$total_pages = ceil($total_rows / $limit);
?>
<section class="property-listings-page__heading mb-5">
	<div class="container">
		<div class="row g-0">
			<div class="col-12">
				<div class="property-listings-page__heading__summary">
                    <?= $pageData['page_title'];?>
				</div>
			</div>
			<div class="col-12">
				<div class="property-listings-page__heading__actions my-5">
    	    		<form method="GET" action="">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control search_field" id="" placeholder="Keyword Search">
                                <!-- <i class="fa-solid fa-magnifying-glass iconsubmit"></i> -->
                            </div>
    						<div class="col">
    							<select name="bedrooms" id="bedrooms" class="form-control search_field">
    								<option value="" readonly>Bed</option>
                                    <option value="1" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '1') ? 'selected="selected"' : ''; ?>>1 Bedrooms</option>
                                    <option value="2" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '2') ? 'selected="selected"' : ''; ?>>2 Bedrooms</option>
                                    <option value="3" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '3') ? 'selected="selected"' : ''; ?>>3 Bedrooms</option>
                                    <option value="4" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '4') ? 'selected="selected"' : ''; ?>>4 Bedrooms</option>
                                    <option value="5" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '5') ? 'selected="selected"' : ''; ?>>5+ Bedrooms</option>
    							</select>
    						</div>
                            <div class="col">
                                <select name="bedrooms" id="bedrooms" class="form-control search_field">
                                    <option value="" readonly>Price</option>
                                    <option value="0-50000" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '0-50000') ? 'selected="selected"' : ''; ?>>£0 - £50,000</option>
                                    <option value="50001-150000" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '50001-150000') ? 'selected="selected"' : ''; ?>>£50,001 - £150,000</option>
                                    <option value="150001 - 250000" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '150001 - 250000') ? 'selected="selected"' : ''; ?>>£150,001 - £250,000</option>
                                    <option value="250001 - 400000" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '250001 - 400000') ? 'selected="selected"' : ''; ?>>£250,001 - £400,000</option>
                                    <option value="400001 - 600000" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '400001 - 600000') ? 'selected="selected"' : ''; ?>>£400,001 - £600,000</option>
                                    <option value="600001 - 800000" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '600001 - 800000') ? 'selected="selected"' : ''; ?>>£600,001 - £800,000</option>
                                    <option value="800001 - 1000000" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '800001 - 1000000') ? 'selected="selected"' : ''; ?>>£800,001 - £1,000,000</option>
                                    <option value="1000001+" <?php echo (isset($_SESSION['bedrooms']) && $_SESSION['bedrooms'] == '1000001+') ? 'selected="selected"' : ''; ?>>£1,000,001+</option>
                                </select>
                            </div>
                            <div class="col">
                                <select name="locations" id="location" class="form-control search_field">
                                    <option value="" readonly>Location</option>
                                    <option value="Pocklington" <?php echo (isset($_SESSION['location']) && $_SESSION['location'] == 'Pocklington') ? 'selected="selected"' : ''; ?>>Pocklington</option>
                                    <option value="Market Weighton" <?php echo (isset($_SESSION['location']) && $_SESSION['location'] == 'Market Weighton') ? 'selected="selected"' : ''; ?>>Market Weighton</option>
                                    <option value="York" <?php echo (isset($_SESSION['location']) && $_SESSION['location'] == 'York') ? 'selected="selected"' : ''; ?>>York</option>
                                </select>
                            </div>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
