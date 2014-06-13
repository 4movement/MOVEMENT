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
