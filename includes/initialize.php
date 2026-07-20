<?php
require_once(__DIR__.DIRECTORY_SEPARATOR.'/bootstrap.php');

$request_host = get_current_host();
$site_profile = load_site_profile($request_host);

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

$site_settings = $site_profile['settings'];
$site = $site_profile['site'];
$site_base_url = $site_profile['base_url'];
$site_logo = $site_profile['logo'];
$site_reverse_logo = $site_profile['reverse_logo'];
$settings = $site_settings;
$logo = $site_logo;
$reverse_logo = $site_reverse_logo;

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
        if (!is_property_visible_on_site((int) $data['id'], (int) $site['id'])) {
            http_response_code(404);
            header('Location: /404');
            die();
        }

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

        $override = load_site_page_override($site['id'], (int) $rewriteData['table_id']);
        if ($override !== false) {
            $pageData = apply_site_page_override($pageData, $override);
        }
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
        if (!is_blog_visible_on_site((int) $data['id'], (int) $site['id'])) {
            http_response_code(404);
            header('Location: /404');
            die();
        }

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

function get_current_host(): string
{
    $host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] ?? '');
    $host = strtolower(trim($host));

    if (strpos($host, ':') !== false) {
        $host = explode(':', $host, 2)[0];
    }

    return preg_replace('/^www\./', '', $host);
}

function load_site_profile(string $host): array
{
    $site = table_fetch_row('sites', 'status = 1 AND domain = "' . $host . '"');

    if ($site === false) {
        $site = table_fetch_row('sites', 'status = 1 AND is_default = 1');
    }

    if ($site === false) {
        $site = array(
            'id' => 0,
            'domain' => $host,
            'base_url' => BASE_URL,
            'website_name' => SITE_NAME,
            'logo_path' => SITE_LOGO,
            'seo_title' => SITE_NAME,
            'seo_description' => '',
        );
    }

    $settings = $site;
    $settings['website_name'] = $settings['website_name'] ?? SITE_NAME;
    $settings['company_number'] = $settings['company_number'] ?? '';
    $settings['contact_mail'] = $settings['contact_mail'] ?? COMPANY_EMAIL;
    $settings['contact_mail_cnt_form'] = $settings['contact_mail_cnt_form'] ?? COMPANY_EMAIL;
    $settings['contact_number'] = $settings['contact_number'] ?? '';
    $settings['contact_number_html'] = $settings['contact_number_html'] ?? '';
    $settings['mobile_contact_number'] = $settings['mobile_contact_number'] ?? '';
    $settings['mobile_contact_number_html'] = $settings['mobile_contact_number_html'] ?? '';
    $settings['address'] = $settings['address'] ?? '';
    $settings['correspondence_address'] = $settings['correspondence_address'] ?? '';
    $settings['map_link'] = $settings['map_link'] ?? '';
    $settings['facebook_link'] = $settings['facebook_link'] ?? '';
    $settings['youtube_link'] = $settings['youtube_link'] ?? '';
    $settings['twitter_link'] = $settings['twitter_link'] ?? '';
    $settings['snapchat_link'] = $settings['snapchat_link'] ?? '';
    $settings['instagram_link'] = $settings['instagram_link'] ?? '';
    $settings['pinterest_link'] = $settings['pinterest_link'] ?? '';
    $settings['google_link'] = $settings['google_link'] ?? '';
    $settings['linkedin_link'] = $settings['linkedin_link'] ?? '';
    $settings['base_url'] = rtrim($settings['base_url'] ?? BASE_URL, '/') . '/';

    $logo = $settings['logo_path'] ?? SITE_LOGO;
    if (strlen($logo) === 0) {
        $logo = SITE_LOGO;
    }

    $reverse_logo = $settings['reverse_logo_path'] ?? '';
    if (strlen($reverse_logo) === 0) {
        $reverse_logo = $logo;
    }

    return array(
        'site' => $site,
        'settings' => $settings,
        'base_url' => $settings['base_url'],
        'logo' => $logo,
        'reverse_logo' => $reverse_logo,
    );
}

function load_site_page_override(int $site_id, int $page_id)
{
    if ($site_id <= 0) {
        return false;
    }

    return table_fetch_row('site_page_overrides', 'site_id = ' . $site_id . ' AND page_id = ' . $page_id . ' AND status = 1');
}

function apply_site_page_override(array $pageData, array $override): array
{
    foreach (array(
        'page_title',
        'h1_title',
        'content',
        'meta_title',
        'meta_description',
        'menu_title',
    ) as $field) {
        if (isset($override[$field]) && strlen(trim((string) $override[$field])) > 0) {
            $pageData[$field] = $override[$field];
        }
    }

    if (isset($override['page_title']) && strlen(trim((string) $override['page_title'])) > 0) {
        $pageData['title'] = $override['page_title'];
    }

    if (isset($override['h1_title']) && strlen(trim((string) $override['h1_title'])) > 0) {
        $pageData['h1_title'] = $override['h1_title'];
    }

    if (isset($override['meta_title']) && strlen(trim((string) $override['meta_title'])) > 0) {
        $pageData['meta_title'] = $override['meta_title'];
    }

    if (isset($override['meta_description']) && strlen(trim((string) $override['meta_description'])) > 0) {
        $pageData['meta_description'] = $override['meta_description'];
    }

    return $pageData;
}
?>
