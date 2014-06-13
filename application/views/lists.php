<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <title>Movement</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="shortcut icon" href="<? echo base_url("assets/img/favicon.jpg"); ?>">

    <link rel = "stylesheet" href = "<? echo base_url("assets/css/normalize.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/main.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/font.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/movement.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/menu.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/logo.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/about.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/adipoli.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/issue.css"); ?>">
    <link rel = "stylesheet" href = "<? echo base_url("assets/css/help.css"); ?>">
	
	<script src="<? echo base_url("assets/js/vendor/modernizr-2.6.2.min.js"); ?>"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://yui.yahooapis.com/2.9.0/build/yuiloader/yuiloader-min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    <script src="<? echo base_url("assets/js/plugins.js"); ?>"></script>
    <script src="<? echo base_url("assets/js/jquery.transit.min.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/jquery.mousewheel.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/masonry.pkgd.min.js"); ?>"></script>
	<script src="<? echo base_url("assets/js/scrollpagination.js"); ?>"></script>   
	
	<script src="<? echo base_url("assets/js/about.js"); ?>"></script>
    <script src="<? echo base_url("assets/js/logo.js"); ?>"></script>
    <script src="<? echo base_url("assets/js/menu.js"); ?>"></script>
    <script src="<? echo base_url("assets/js/main.js"); ?>"></script>
	
	<script> //Masonry
		$('#container').masonry({
			columnWidth: 350,
			itemSelector: '.item',
			isFitWidth: true,
			
		});
	</script>
</head>
<body >


				 <div id="movement_list"  class="masonry js-masonry"  data-masonry-options='{ "columnWidth": 350, "itemSelector": ".item","gutter": 10}'>       
					<li class="item">
						<div id="movement_list_data">
							<div class= "mask"></div>
							<img class="photo" src="<? echo base_url("assets/img/sample.jpg"); ?>">
								<div class="list_nav_wrapper">
									<div class="list_title"><?= $name ?></div>
									<div class="list_nav">
										<span class="nav_date"><?= $date ?></span>
										<span class="nav_place">
											<img src="<? echo base_url("assets/img/movement/mo-lo.png"); ?>" />
											<span><?= $city ?></span>
										</span>
										<span class="nav_category"><img src="" /></span>
									</div>
								</div>
							</img>
						</div>
					</li>
					<li class="item">
						<img src="<? echo base_url("assets/img/sample.jpg"); ?>" />
					</li>
<?php echo $lists ?>
				</div><!--movement_list-->

</body>
</html>
