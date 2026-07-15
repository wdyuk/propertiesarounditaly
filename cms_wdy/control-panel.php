<?php 
    
	require 'application.php';
	
    error_reporting(E_ALL);

    if (DEBUG_ADMIN === true) {

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);

    } else {

        ini_set('display_errors', 0);
        ini_set('display_startup_errors', 0);

    }

    if (!isset($_SESSION['admin'])) {
        redirect('login.php');
    }

?>
<!DOCTYPE html>
<html>
<?php 
$title = "WDY CMS : ".APP_TITLE;
require 'includes/head.php'; ?>

<body class="dashboard">
	<?php require 'includes/header.php'; ?>
    <div class="wrapper">
        <?php require 'includes/menu.php'; ?>
        <!-- Page Content Holder -->
        <div id="content">
            <div id="accordion">
            <?php
                if(!isset($_SESSION['sector'])):

                else:
                    require 'includes/breadcrumb.php';
                endif;
                    if (isset($_GET['module'])) {

                        $path = sprintf('modules/%s/%s.php', $_GET['module'], $_GET['action']);
                        
                        require $path;
                    } else {
                        require 'modules/page/list.php';
                    }
                ?>
            </div>
        </div>
    </div>

    <?php require 'includes/footer.php'; ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $(this).toggleClass('active');
            });
        });
    </script>
</body>
</html>