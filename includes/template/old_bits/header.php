<?php
	$settings = table_fetch_row('site_settings','status=1');
	
	$header_logo = get_image('settings/'.$settings['id'] .'-image');
	if(strlen($header_logo) == 0){
	   $header_logo = '/includes/layout/images/logo.png';
	}
	
	$footer_logo = get_image('settings/'.$settings['id'] .'-image2');
	if(strlen($footer_logo) == 0){
	   $footer_logo = '/includes/layout/images/logo.png';
	}
   // if ($rewriteData['id'] == 5){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['id'] == 6){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['id'] == 7){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['id'] == 8){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['table_name'] == 'vacancies'){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['id'] == 13 || $rewriteData['id'] == 15 || $rewriteData['id'] == 16 || $rewriteData['id'] == 17 || $rewriteData['id'] == 11){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['table_name'] == 'news'){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['id'] == 9 || $rewriteData['id'] == 47 || $rewriteData['id'] == 37){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['table_name'] == 'projects' || $rewriteData['table_name'] == 'peoples'){ echo 'class="home_page inner_page"'; } elseif ($rewriteData['id'] == 41){ echo 'class="home_page inner_page"'; } else { echo  'class="home_page"'; }
?>   
   <body <?php if ($rewriteData['id'] != 2){ echo 'class="home_page inner_page"'; } else{ echo 'class="home_page"'; }?>>
      <!-- header -->
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-lg-2 col-sm-3 col-xs-12">
                  <div class="logo">
                     <a href="/"><img src="<?= $header_logo; ?>" alt="<?= $settings['website_name']; ?>"></a>
                  </div>
               </div>
               <div class="col-lg-10 col-sm-9 col-xs-12">
                  <div class="header_navigation header_right">
                     <nav class="navbar navbar-expand-sm">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-2" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fa fa-bars"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbar-list-2">
                           <ul class="navbar-nav">
                              <?php 
                                 $parents = table_fetch_rows('page', 'status = 1 AND parent_id = -1 AND top_nav = 1', 'position ASC');
                                 
                                 foreach($parents as $parent)
                                 {
                                    $child_parents = table_fetch_rows('page', 'status = 1 AND parent_id = '.$parent['id'].' AND top_nav = 1', 'position ASC');
                                    if($child_parents == null)
                                    {
                              ?>
                              <li class="nav-item">
                                 <a class="nav-link" href="<?= $parent['url']; ?>"><?= $parent['menu_title']; ?></a>
                              </li>                            
                              <?php 
                                    }
                                    else
                                    {
                              ?>
                              <li class="nav-item dropdown">
                                 <a class="nav-link dropdown-toggle" id="navbarDropdown1" data-target="#" href="<?= $parent['url']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $parent['menu_title']; ?></a>
                                 <ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
                                    <?php 
                                       foreach($child_parents as $child_parent)
                                       {
                                    ?>
                                                <li><a class="dropdown-item" href="<?= $child_parent['url']; ?>"><?= $child_parent['menu_title']; ?></a></li>
                                    <?php
                                       }
                                    ?>
                                 </ul>
                              </li>             
                              <?php
                                    }
                                 }
                              ?>                     
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </div>