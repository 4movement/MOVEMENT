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

        <link rel="stylesheet" href="../../assets/css/normalize.css">
        <link rel="stylesheet" href="../../assets/css/main.css">
        <link rel="stylesheet" href="../../assets/css/font.css">
        <link rel = "stylesheet" href = "../../assets/css/movement.css">
        <link rel = "stylesheet" href = "../../assets/css/menu.css">
        <link rel = "stylesheet" href = "../../assets/css/logo.css">

        <!-- 
		<script src="../../assets/js/vendor/modernizr-2.6.2.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
        <script src="../../assets/js/plugins.js"></script>
        <script src="../../assets/js/jquery.transit.min.js"></script>
        <script src="../../assets/js/jquery.mousewheel.js"></script>
        <script src="../../assets/js/jquery.rateit.min.js"></script>
		-->

        <script src="../../assets/js/main.js"></script>  
        <script src="../../assets/js/movement.js"></script>
        <script src="../../assets/js/menu.js"></script>
        <script src="../../assets/js/logo.js"></script>
		<script src="../../assets/js/masonry-docs/masonry.pkgd.min.js"></script>
		<script src="../../assets/js/scrollpagination.js"></script>   
		<script>
		$('#container').masonry({
			columnWidth: 350,
			itemSelector: '.item',
			"gutter": 10,
		});
		</script>
	</head>
	
    <body>
        <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<div id = "movement_layout" class = "layout">
			<div class = "movement_display_mode">
				<span class="tag_type">
					<li class = "tag_type time">
						<img src="../../assets/img/movement/button/mo-ti01.png" class="none_selected"  />
						 <img src="../../assets/img/movement/button/mo-ti02.png" class="selected"/>
					</li>
					<li class = "tag_type hot">
						<img src="../../assets/img/movement/button/mo-ho01.png" class="none_selected"  />
						<img src="../../assets/img/movement/button/mo-ho02.png" class="selected"/>
					</li>
					<li class = "tag_type new">
						<img src="../../assets/img/movement/button/mo-ne01.png" class="none_selected"  />
						<img src="../../assets/img/movement/button/mo-ne02.png" class="selected"/>
					</li>
					<li class = "tag_type issue">
						<img src="../../assets/img/movement/button/mo-is01.png" class="none_selected"  />
						<img src="../../assets/img/movement/button/mo-is02.png" class="selected"/>
					</li>
				</span><!--tag_type -->
				<span class="display_type">
					<li class="display_type picture">
						<img src="../../assets/img/movement/button/mo-pi01.png" class="none_selected"  />
						<img src="../../assets/img/movement/button/mo-pi02.png" class="selected" />
					</li>
					<li class="display_type list">
						<img src="../../assets/img/movement/button/mo-li01.png" class="none_selected"  />
						<img src="../../assets/img/movement/button/mo-li02.png" class="selected" />
					</li>
				</span><!--display_type -->
			</div>
			<div id = "movement_calender">
                <ul id = "movement_month_list">
                    <li class = "month_list" year = "2014">
                        <div class = "circle"></div>
                        <span> 2014.</span>
                    </li>
                    <li class = "month_list" year = "2014" month = "1">
                        <div class = "circle"></div>
                        <span>Jan.</span>
                    </li>
                    <li class = "month_list" year = "2014" month = "2">
                        <div class = "circle"></div>
                        <span>Feb.</span>
                    </li>
                    <li class = "month_list" year = "2014" month = "3">
                        <div class = "circle"></div>
                        <span>Mar.</span>
                    </li>
                            <li class = "month_list" year = "2014" month = "4">
                                <div class = "circle"></div>
                                <span>Apr.</span>
                            </li>
                            <li class = "month_list" year = "2014" month = "5">
                                <div class = "circle"></div>
                                <span>May.</span>
                            </li>
                            <li class = "month_list selected" year = "2014" month = "6">
                                <div class = "circle"></div>
                                <span>Jun.</span>
                            </li>
                            <li class = "month_list" year = "2014" month = "7">
                                <div class = "circle"></div>
                                <span>Jul.</span>
                            </li>
                            <li class = "month_list " year = "2014" month = "8">
                                <div class = "circle"></div>
                                <span>Aug.</span>
                            </li>
                            <li class = "month_list " year = "2014" month = "9">
                                <div class = "circle"></div>
                                <span>Sep.</span>
                            </li>
                            <li class = "month_list new" year = "2014" month = "10">
                                <div class = "circle"></div>
                                <span>Oct.</span>
                            </li>
                            <li class = "month_list" year = "2014" month = "11">
                                <div class = "circle"></div>
                                <span>Nov.</span>
                            </li>
                            <li class = "month_list" year = "2014" month = "12">
                                <div class = "circle"></div>
                                <span>Dec.</span>
                            </li>
                            <li class = "month_list" year = "2015">
                                <div class = "circle"></div>
                                <span> 2015.</span>
                   </li>
                </ul>
             </div><!--calender-->
			 <div id="movement_list"  class="masonry js-masonry"  data-masonry-options='{ "columnWidth": 350, "itemSelector": ".item","gutter": 20}'>       
				<li class="item">
					<div id="movement_list_data">
						<div class= "mask"></div>
						<img class="photo" src="../../assets/img/sample.jpg" />
						<div class="list_title_nav">
							<div class="list_title">Media Monoploy</div>
							<div class="list_nav">
								<span class="list_date">2/14</span>
								<span class="list_place"><img src="../../assets/img/movement/button/mo-lo.png" />Taipei</span>
								<span class="list_category"><img src="" /></span>
							</div>
						</div>
					</div>
				</li>
				<li class="item">
					<img src="../../assets/img/sample.jpg" />
				</li>
				<li class="item">
					<img src="../../assets/img/sample.jpg" />
				</li>
				<li class="item">
					<img src="../../assets/img/sample.jpg" />
				</li>
				<li class="item">
					<img src="../../assets/img/sample.jpg" />
				</li>
				<li class="item">
					<img src="../../assets/img/sample.jpg" />
				</li>
				<li class="item">
					<img src="../../assets/img/sample.jpg" />
				</li>
				<li class="item">
					<img src="../../assets/img/sample.jpg" />
				</li>
			</div><!--movement_list-->
		</div><!-- movement_layout -->
    </body>
</html>
