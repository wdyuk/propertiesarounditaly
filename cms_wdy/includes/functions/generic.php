<?php

function return_date($num, $type)
{
	if (strpos($num, '0') === 0) {
		$num = substr($num, 1);
	}
	
	switch($type){ 
		case 'month': 
			$month_name = array("", "Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December");
			return $month_name[$num];
			break; 

		case 'day': 
			$day_name = array('', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag', 'Zondag'); 
			return $day_name[$num]; 
			break; 
	}
}

function show_checked($x, $y)
{
	echo stripcslashes($x) == stripcslashes($y) ? 'checked="checked"' : '';
}

function show_selected($x, $y)
{
	echo stripcslashes($x) == stripcslashes($y) ? 'selected="selected"' : '';
}

function show_fckeditor($name, $content = '', $placeholder = '')
{
	$ckeditor = '<textarea name="'.$name.'" id="ck'.$name.'" placeholder="'.$placeholder.'" class="newckeditor">'.$content.'</textarea>';
	echo $ckeditor;
}

// function show_fckeditor($name, $content = '', $width = 590, $height = 400)
// {
// 	include_once 'resources/fckeditor/fckeditor.php';
// 	$base_path = ADMIN_URL.'/resources/fckeditor/';
	
// 	$fckeditor = new FCKeditor($name);
// 	$fckeditor->BasePath = $base_path;
	
// 	$fckeditor->Config['SkinPath'] = $base_path . 'editor/skins/office2003/' ;
// 	$fckeditor->Config['AutoDetectLanguage'] = false;
// 	$fckeditor->Config['DefaultLanguage'] = 'en';
// 	$fckeditor->Width = $width;
// 	$fckeditor->Height = $height;
	
// 	$fckeditor->Value = stripslashes($content);
// 	$fckeditor->Create();
// }

function show_rows($rows, $table, $fields, $operations = array('edit', 'delete'), $showHtml = true)
{
	foreach ($rows as $row) {
		$id = $row['id'];
		
		printf('<tr table="%s" row_id="%s">', $table, $id);
		
		echo '<td valign="top">';
		foreach ($operations as $operation) {
			printf('<a href="?module=%s&action=%s&id=%d" class="operation-%s operation" value="%d"></a> ', $table, $operation, $id, $operation, $id);
		}
		echo '</td>';
    	
		foreach ($fields as $field) {
			if ($field == 'date') {
				printf('<td valign="top">%s</td>', date('d-m-Y', strtotime($row[$field])));
			} else {
                    if($showHtml) {
                        printf('<td valign="top">%s</td>', htmlentities($row[$field]));
                    }
                    else {
                        printf('<td valign="top">%s</td>', $row[$field]);
                    }
			}
		}
    
		echo '</tr>';
	}
}




function make_get_url($params)
{
	foreach ($params as $key => $val) {
		$url_params[] = sprintf('%s=%s', $key, urlencode($val));
	}
	
	return implode('&', $url_params);
}

function get_id()
{
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} elseif (isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	
	return $id;
}

function show_pagination($total_pages, $current_page)
{
	$params = $_GET;
	unset($params['page']);
	
	if ($total_pages > 1) {
		$url = make_get_url($params);
		
		echo '<nav aria-label="Page navigation">
  <ul class="pagination">';
		
		if ($current_page > 1) {
			$temp_params = $params;
			$temp_params['page'] = $current_page - 1;
			$url = make_get_url($temp_params);
			
			printf('<li class="page-item">
      <a class="page-link" href="?%s" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>', $url);
		}
		
		$start_page = $current_page;
		
		$start_page = 1;
		if (($current_page - 4) > 0) {
			$start_page = $current_page - 4;
		}
		
		$end_page = $start_page + 8;
		if ($end_page > $total_pages) {
			$end_page = $total_pages;
			
			if (($current_page - 10) > 0) {
				$start_page = $current_page - 10;
			} else {
				$start_page = 1;
			}
		}
		
		for ($page = $start_page; $page <= $end_page; $page++) {
			$link = sprintf('?%s&page=%d', $url, $page);
			
			if ($page == $current_page) {
				
				printf('<li class="page-item active"><a class="page-link" href="%s">%d</a></li>', $link, $page);
			} else {
				printf('<li class="page-item"><a class="page-link" href="%s">%d</a></li>', $link, $page);
			}
		}
		
		if ($current_page < $total_pages) {
			$temp_params = $params;
			$temp_params['page'] = $current_page + 1;
			$url = make_get_url($temp_params);
			
			printf('<li class="page-item">
      <a class="page-link" href="?%s" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>', $url);
		}
			
		echo '</ul></nav>';
	}
}

function show_id()
{
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} elseif (isset($_POST['id'])) {
		$id = $_POST['id'];
	}
	
	printf('<input type="hidden" name="id" id="id" value="%d" />', $id);
}

function redirect($link)
{
	$location = sprintf('Location: %s', $link);
	header($location);
	die();
}


function show_big_button($name, $text, $class = 'btn-primary')
{
	$translated_text = $text;
	
	echo <<<HTML
	<button name="{$name}" class="big btn-wdy {$class}" type="submit">
		{$translated_text}
	</button>
HTML;
}

function show_link_btn_arrow($link, $text)
{
	echo <<<HTML
	<a class="button-arrow" href="logout.php">
		<span class="left"><span class="right"><span class="text">{$text}</span></span></span>
	</a>
HTML;
}

function show_messages($messages)
{
	if (count($messages)) {
		echo '<div class="alert alert-success messages">';
		echo '<div class="row">
            <div class="col-1 alert-icon-col">
                <span class="fa fa-check fa-fw"></span>
            </div>
            <div class="col">';
            foreach ($messages as $message) {
				printf('%s<br>', $message);
			}
            echo '</div>
        </div></div>';
		
	}
}

function show_errors($errors)
{
	if (count($errors)) {

		echo '<div class="alert alert-danger errors">';
		echo '<div class="row">
            <div class="col-1 alert-icon-col">
                <span class="fas fa-exclamation-triangle fa-fw"></span>
            </div>
            <div class="col">';
            foreach ($errors as $error) {
				printf('%s<br>', $error);
			}
            echo '</div>
        </div></div>';
	}
}


/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
/*::                                                                         :*/
/*::  This routine calculates the distance between two points (given the     :*/
/*::  latitude/longitude of those points). It is being used to calculate     :*/
/*::  the distance between two locations using GeoDataSource(TM) Products    :*/
/*::                                                                         :*/
/*::  Definitions:                                                           :*/
/*::    South latitudes are negative, east longitudes are positive           :*/
/*::                                                                         :*/
/*::  Passed to function:                                                    :*/
/*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
/*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
/*::    unit = the unit you desire for results                               :*/
/*::           where: 'M' is statute miles (default)                         :*/
/*::                  'K' is kilometers                                      :*/
/*::                  'N' is nautical miles                                  :*/
/*::  Worldwide cities and other features databases with latitude longitude  :*/
/*::  are available at http://www.geodatasource.com                          :*/
/*::                                                                         :*/
/*::  For enquiries, please contact sales@geodatasource.com                  :*/
/*::                                                                         :*/
/*::  Official Web site: http://www.geodatasource.com                        :*/
/*::                                                                         :*/
/*::         GeoDataSource.com (C) All Rights Reserved 2015		   		     :*/
/*::                                                                         :*/
/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}
// Folder Generator 
	function generateRandomToken($length = 10) {
	    $chars = '0123456789';
	    $charsLength = strlen($chars);

	    $randomString = '';

	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $chars[rand(0, $charsLength - 1)];
	    }
	    return $randomString;
	}
	function getEpcRating($currentRating = null) {

		if(!isset($currentRating)) {
			return false;
		}
		$currentRating = (int)$currentRating;
		if ($currentRating == 0) {
			return 'Not Rated';
		}elseif($currentRating > 0 && $currentRating <=20 ) {
			return 'G';
		}elseif($currentRating > 20 && $currentRating <=38 ) {
			return 'F';
		}elseif($currentRating > 38 && $currentRating <=54 ) {
			return 'E';
		}elseif($currentRating > 54 && $currentRating <=68 ) {
			return 'D';
		}elseif($currentRating > 69 && $currentRating <=80 ) {
			return 'C';
		}elseif($currentRating > 80 && $currentRating <=91 ) {
			return 'B';
		}elseif($currentRating > 91 && $currentRating <=100 ) {
			return 'A';
		}
	}

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function get_active_sites()
{
    return table_fetch_rows('sites', 'status = 1', 'is_default DESC, website_name ASC');
}

function get_property_visibility_site_ids($property_id)
{
    $rows = table_fetch_rows('property_site_visibility', 'property_id = ' . (int) $property_id . ' AND is_visible = 1', 'site_id ASC');
    $site_ids = array();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $site_ids[] = (int) $row['site_id'];
        }
    }

    return $site_ids;
}

function sync_property_visibility_sites($property_id, array $site_ids)
{
    $property_id = (int) $property_id;

    if ($property_id <= 0) {
        return;
    }

    table_delete_row('property_site_visibility', 'property_id = ' . $property_id);

    $site_ids = array_values(array_unique(array_map('intval', $site_ids)));
    foreach ($site_ids as $site_id) {
        if ($site_id <= 0) {
            continue;
        }

        table_insert(
            'property_site_visibility',
            array('property_id', 'site_id', 'is_visible'),
            array(
                'property_id' => $property_id,
                'site_id' => $site_id,
                'is_visible' => 1,
            )
        );
    }
}

function is_property_visible_on_site($property_id, $site_id)
{
    $row = table_fetch_row(
        'property_site_visibility',
        'property_id = ' . (int) $property_id . ' AND site_id = ' . (int) $site_id . ' AND is_visible = 1'
    );

    return $row !== false;
}

function get_visible_property_ids_for_site($site_id)
{
    $rows = table_fetch_rows('property_site_visibility', 'site_id = ' . (int) $site_id . ' AND is_visible = 1', 'property_id ASC');
    $property_ids = array();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $property_ids[] = (int) $row['property_id'];
        }
    }

    return $property_ids;
}

function build_visible_property_where($site_id, $column = 'id')
{
    $property_ids = get_visible_property_ids_for_site($site_id);

    if (empty($property_ids)) {
        return '1=0';
    }

    return sprintf('%s IN (%s)', $column, implode(', ', $property_ids));
}

function get_blog_visibility_site_ids($blog_id)
{
    $rows = table_fetch_rows('blog_site_visibility', 'blog_id = ' . (int) $blog_id . ' AND is_visible = 1', 'site_id ASC');
    $site_ids = array();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $site_ids[] = (int) $row['site_id'];
        }
    }

    return $site_ids;
}

function sync_blog_visibility_sites($blog_id, array $site_ids)
{
    $blog_id = (int) $blog_id;

    if ($blog_id <= 0) {
        return;
    }

    table_delete_row('blog_site_visibility', 'blog_id = ' . $blog_id);

    $site_ids = array_values(array_unique(array_map('intval', $site_ids)));
    foreach ($site_ids as $site_id) {
        if ($site_id <= 0) {
            continue;
        }

        table_insert(
            'blog_site_visibility',
            array('blog_id', 'site_id', 'is_visible'),
            array(
                'blog_id' => $blog_id,
                'site_id' => $site_id,
                'is_visible' => 1,
            )
        );
    }
}

function is_blog_visible_on_site($blog_id, $site_id)
{
    $row = table_fetch_row(
        'blog_site_visibility',
        'blog_id = ' . (int) $blog_id . ' AND site_id = ' . (int) $site_id . ' AND is_visible = 1'
    );

    return $row !== false;
}

function build_visible_blog_where($site_id, $column = 'id')
{
    $blog_ids = get_visible_blog_ids_for_site($site_id);

    if (empty($blog_ids)) {
        return '1=0';
    }

    return sprintf('%s IN (%s)', $column, implode(', ', $blog_ids));
}

function get_visible_blog_ids_for_site($site_id)
{
    $rows = table_fetch_rows('blog_site_visibility', 'site_id = ' . (int) $site_id . ' AND is_visible = 1', 'blog_id ASC');
    $blog_ids = array();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $blog_ids[] = (int) $row['blog_id'];
        }
    }

    return $blog_ids;
}

function get_homepage_slider_visibility_site_ids($slider_id)
{
    $rows = table_fetch_rows('homepage_slider_site_visibility', 'homepage_slider_id = ' . (int) $slider_id . ' AND is_visible = 1', 'site_id ASC');
    $site_ids = array();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $site_ids[] = (int) $row['site_id'];
        }
    }

    return $site_ids;
}

function sync_homepage_slider_visibility_sites($slider_id, array $site_ids)
{
    $slider_id = (int) $slider_id;

    if ($slider_id <= 0) {
        return;
    }

    table_delete_row('homepage_slider_site_visibility', 'homepage_slider_id = ' . $slider_id);

    $site_ids = array_values(array_unique(array_map('intval', $site_ids)));
    foreach ($site_ids as $site_id) {
        if ($site_id <= 0) {
            continue;
        }

        table_insert(
            'homepage_slider_site_visibility',
            array('homepage_slider_id', 'site_id', 'is_visible'),
            array(
                'homepage_slider_id' => $slider_id,
                'site_id' => $site_id,
                'is_visible' => 1,
            )
        );
    }
}

function is_homepage_slider_visible_on_site($slider_id, $site_id)
{
    $row = table_fetch_row(
        'homepage_slider_site_visibility',
        'homepage_slider_id = ' . (int) $slider_id . ' AND site_id = ' . (int) $site_id . ' AND is_visible = 1'
    );

    return $row !== false;
}

function get_visible_homepage_slider_ids_for_site($site_id)
{
    $rows = table_fetch_rows('homepage_slider_site_visibility', 'site_id = ' . (int) $site_id . ' AND is_visible = 1', 'homepage_slider_id ASC');
    $slider_ids = array();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $slider_ids[] = (int) $row['homepage_slider_id'];
        }
    }

    return $slider_ids;
}

function build_visible_homepage_slider_where($site_id, $column = 'id')
{
    $slider_ids = get_visible_homepage_slider_ids_for_site($site_id);

    if (empty($slider_ids)) {
        return '1=0';
    }

    return sprintf('%s IN (%s)', $column, implode(', ', $slider_ids));
}

function get_page_visibility_site_ids($page_id)
{
    $rows = table_fetch_rows('page_site_visibility', 'page_id = ' . (int) $page_id . ' AND is_visible = 1', 'site_id ASC');
    $site_ids = array();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $site_ids[] = (int) $row['site_id'];
        }
    }

    return $site_ids;
}

function sync_page_visibility_sites($page_id, array $site_ids)
{
    $page_id = (int) $page_id;

    if ($page_id <= 0) {
        return;
    }

    table_delete_row('page_site_visibility', 'page_id = ' . $page_id);

    $site_ids = array_values(array_unique(array_map('intval', $site_ids)));
    foreach ($site_ids as $site_id) {
        if ($site_id <= 0) {
            continue;
        }

        table_insert(
            'page_site_visibility',
            array('page_id', 'site_id', 'is_visible'),
            array(
                'page_id' => $page_id,
                'site_id' => $site_id,
                'is_visible' => 1,
            )
        );
    }
}

function is_page_visible_on_site($page_id, $site_id)
{
    $row = table_fetch_row(
        'page_site_visibility',
        'page_id = ' . (int) $page_id . ' AND site_id = ' . (int) $site_id . ' AND is_visible = 1'
    );

    return $row !== false;
}

function get_visible_page_ids_for_site($site_id)
{
    $rows = table_fetch_rows('page_site_visibility', 'site_id = ' . (int) $site_id . ' AND is_visible = 1', 'page_id ASC');
    $page_ids = array();

    if (!empty($rows)) {
        foreach ($rows as $row) {
            $page_ids[] = (int) $row['page_id'];
        }
    }

    return $page_ids;
}

function build_visible_page_where($site_id, $column = 'id')
{
    $page_ids = get_visible_page_ids_for_site($site_id);

    if (empty($page_ids)) {
        return '1=0';
    }

    return sprintf('%s IN (%s)', $column, implode(', ', $page_ids));
}
?>
