<?php
require_once(__DIR__.DIRECTORY_SEPARATOR.'/bootstrap.php');

$domain = parse_url($_SERVER['SERVER_NAME']);

$url = isset($_GET['url']) ? $_GET['url'] : '/';
$url = ($url == '/index') ? '/' : $url;
// if($url == "/contact-us/"){
// 	$url = "/contact";
// }
// if($url == "/our-people/"){
// 	$url = "/people";
// }
// if($url == "/about-us/"){
// 	$url = "/about";
// }
// if($url == "/services/"){
// 	$url = "/services";
// }
// if($url == "/clients/"){
// 	$url = "/projects";
// }
// if($url == "/sectors/"){
// 	$url = "/news";
// }


$rewriteData = getRewriteByURL($url);

$pageData = array();
$pageData['meta_keywords'] = '';
$pageData['meta_description'] = '';
$pageData['title'] = '';
$pageData['content'] = '';
$pageData['blocks'] = '';
$pageData['javascript'] = '';


$params = $_POST;

$site_settings = table_fetch_row('site_settings','id=1');

if($rewriteData !== false && $rewriteData['table_name'] == 'projects') {
    $data = table_fetch_row('projects', 'status = 1 AND id = ' . $rewriteData['table_id']);
    
    if($data !== false)
    {
		$pageData = $data;
		$pageData['title'] = $data['title'];
		$pageData['page_title'] = $data['title'];
    }
    else {
        header('Location: /');
    }   
} 
elseif($rewriteData !== false && $rewriteData['table_name'] == 'properties') {
    $data = table_fetch_row('properties', 'id = ' . $rewriteData['table_id']);
    
    if($data !== false)
    {
        $pageData = $data;
        $pageData['title'] = $data['name'];
        $pageData['page_title'] = $data['name'];
        $urltotitle = explode('/', $rewriteData['url']);
        $meta_title = str_replace('-', ' ', $urltotitle[1]);
        $pageData['meta_title'] = ucwords($meta_title);
        //$pageData['title'];
        $meta_description = $pageData['name'].' | '.strip_tags($pageData['description']);

        if (strlen($meta_description) >= 160) {
            $meta_description = substr($meta_description, 0,160);
        } 
        $pageData['meta_description'] = $meta_description;
    }
    else {
        header('Location: /');
    }   
}  
elseif($rewriteData !== false && $rewriteData['table_name'] == 'teams') {
    $data = table_fetch_row('teams', 'status = 1 AND id = ' . $rewriteData['table_id']);
    
    if($data !== false)
    {
        $pageData = $data;
        $pageData['title'] = $pageData['full_name'];
        $pageData['page_title'] = $pageData['full_name'];
        $pageData['meta_title'] = $pageData['title'];
        $pageData['meta_description'] = 'Meet '.$pageData['full_name'].' '.$pageData['qualifications'].' | '.$pageData['job_title'];
    }
    else {
        header('Location: /');
    }   
}  
elseif($rewriteData !== false && $rewriteData['table_name'] == 'page')  {
	$data = table_fetch_row('page', 'status = 1 AND id = ' . $rewriteData['table_id']);
    	
    if($data !== false)
    {    
		$pageData = $data;
		$pageData['title'] = $data['page_title'];
    }
    else {
        header('Location: /');
    }
}  
// elseif($rewriteData !== false && $rewriteData['table_name'] == 'peoples') {
//     $data = table_fetch_row('peoples', 'status = 1 AND id = ' . $rewriteData['table_id']);
    
//     if($data !== false)
//     {
// 		$pageData = $data;
// 		$pageData['h1_title'] = $data['name'];
// 		$pageData['title'] = $data['name'];
// 		$pageData['meta_description'] = '';
// 		$pageData['page_title'] = $data['name'];
//         $pageData['meta_title'] = $pageData['title'];
// 	}
//     else {
//         header('Location: /');
//     }
// }  
elseif($rewriteData !== false && $rewriteData['table_name'] == 'vacancies') {
    $data = table_fetch_row('vacancies', 'status = 1 AND id = ' . $rewriteData['table_id']);
    
    if($data !== false)
    {
		$pageData = $data;
		$pageData['h1_title'] = $data['title'];
		$pageData['page_title'] = $data['title'];
        $pageData['meta_title'] = $pageData['title'];
        $pageData['meta_description'] = $pageData['title'].' | '.$pageData['short_description'];
	}
    else {
        header('Location: /');
    }
}
elseif($rewriteData !== false && $rewriteData['table_name'] == 'cases') {
    $data = table_fetch_row('cases', 'status = 1 AND id = ' . $rewriteData['table_id']);
    
    if($data !== false)
    {
		$pageData = $data;
		$pageData['h1_title'] = $data['title'];
		$pageData['page_title'] = $data['title'];
    }
    else {
        header('Location: /');
    }
}
elseif($rewriteData !== false && $rewriteData['table_name'] == 'blog') {
    $data = table_fetch_row('blog', 'status = 1 AND id = ' . $rewriteData['table_id']);
    
    if($data !== false)
    {
		$pageData = $data;
		$pageData['h1_title'] = $data['title'];
		$pageData['page_title'] = $data['title'];
        if(strlen($pageData['title']) >= 49) {
           
            $pageData['meta_title'] .= substr($pageData['title'],0,49);
           
        } else {
            $pageData['meta_title'] = $pageData['title'];
        }
        
        if(strlen($pageData['meta_description']) == 0) {
            $pageData['meta_description'] = '';
            if (strlen($pageData['description']) > 115) {
                $pageData['meta_description'] .= substr(strip_tags($pageData['description']),0,115);
            } else {
                $pageData['meta_description'] .= strip_tags($pageData['description']);
            }
        }
    }
    else {
        header('Location: /');
    }
} 
else {
    http_response_code(404);
    $pageData = table_fetch_row('page','page_title="Page Not Found"');
	
	header('Location: /404');
	
    die();    
}
?>