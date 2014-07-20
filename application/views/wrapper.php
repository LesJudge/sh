<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Swiss Halley | Five Star Seminar Turkey, Antalya - 2014 July 22-23.</title>
    <meta name="description" content="Five Star Seminar by Swiss Halley in Turkey, Antalya - 2014 July 22-23. Buy your tickets now!" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <link href="<?php echo base_url(); ?>media/favicon.ico" rel="icon" type="image/ico"/>
	<link href="<?php echo base_url(); ?>media/favicon.ico" rel="shortcut icon" type="image/ico"/>
	<link href="<?php echo base_url(); ?>media/favicon.ico" rel="bookmark icon" type="image/ico"/>
	<link href="<?php echo base_url(); ?>media/favicon.ico" rel="shortcut" type="image/ico"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,700&subset=latin,latin-ext,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css' />   
	<link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>css/fonts/icomoon-style.css" rel="stylesheet" type="text/css" />   
    <link href="<?php echo base_url(); ?>css/main.css"  rel="stylesheet" type="text/css" />
    
    <!--[if IE 7]><link href="<?php echo base_url(); ?>css/site_ie7.css" rel="stylesheet" type="text/css" /><![endif]-->
    <!--[if IE 8]><link href="<?php echo base_url(); ?>css/site_ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
    <!--[if IE 9]><link href="<?php echo base_url(); ?>css/site_ie9.css" rel="stylesheet" type="text/css" /><![endif]-->

<!--[if lte IE 9]>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/html5shiv.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/respond.src.js"></script>
	<![endif]-->	
	<script src="<?php echo base_url(); ?>js/jquery-1.11.0.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>js/jquery-1.11.0.min.js"><\/script>');</script>
    <script type="text/JavaScript" src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>	
	<script type="text/JavaScript" src="<?php echo base_url(); ?>js/jquery.ui.touch-punch.min.js"></script>		
    <script src="<?php echo base_url(); ?>js/main.js"></script>
	
</head>
<body class="<?php echo $bodyClass; ?>">
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-T3GKZ3"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T3GKZ3');</script>
<!-- End Google Tag Manager -->

<div id="container">
	<div class="header-container">
		<div class="container">
			<div class="header col-lg-24 col-md-24 col-sm-24">
				<header>
					<?php echo $header; ?>
				</header>		
			</div>
		</div>	
    </div>
	
    <div id="slider" class="col-lg-24 col-md-24 col-sm-24">
        <?php echo $slider; ?>
    </div>
     
	<div class="footer-container">	  
		<div class="container">
			<div class="footer col-lg-24 col-md-24 col-sm-24">			
				 <footer>
					<?php echo $footer; ?>
				</footer>    	
			</div>
		</div>	
	</div>	     
</div>
    <script type="text/javascript">
        <?php if (isset($layer_url)) { ?>var LAYER_PATH = '<?php echo $layer_url; ?>'; <?php } ?>
        <?php if (isset($can_book)) { ?>
            <?php if ($can_book == TRUE) { ?>var CAN_BOOK = true; <?php } else { ?>var CAN_BOOK = false; <?php } ?>
        <?php } ?>        
    </script>
	
    <?php if ($siteBeforePopupContent): ?>
	<script type="text/javascript">
    $(document).ready(function(){
        $('#popup-modal').appendTo("BODY").modal('show');
    });
    </script>
    <div class="modal fade" id="popup-modal" tabindex="-1" role="dialog" aria-labelledby="popup" aria-hidden="true">
    <div class="modal-dialog popup-modal-dialog">
        <div class="modal-content">
           <div class="modal-body">	
            	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<div class="clearfix"></div>
                <div class="modal-content-inner"><?php echo $siteBeforePopupContent ?></div>
            </div>	        
        </div>
    </div>
    </div>
    <?php endif; ?>
	
	
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
       (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new
    Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
       ga('create', 'UA-29491320-1', 'swisshalley.com');
       ga('send', 'pageview');
    </script>
</body>
</html>