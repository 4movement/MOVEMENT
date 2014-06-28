				<div id="movement_list_detail">
					<div id="detail_button_wrapper">
						<div id="detail_button_border">
						</div>
						<li>
							<img src="assets/img/movement/mo-jo01.png" />
							<span class="detail_count join_count"><?= $joins ?></span>
						</li>
						<li>
							<img src="assets/img/movement/mo-sh01.png" />
							<span class="detail_count support_count"><?= $support ?></span>		
						</li>
						<li>
							<img src="assets/img/movement/mo-do01.png" />
							<span class="detail_count donate_count"><?= $donate ?></span>		
						</li>
					</div><!--detail_button_wrapper-->
					<div id="detail_data_wrapper">
						<li class="detail_intro">
							<div class="detail_data_head">Introduction</div>
						<?= $intro ?>
						</li>
						<li class="detail_demand">
							<div class="detail_data_head">Demand</div>
						<?= $demand ?>
						</li>
						<li class="detail_time">
							<div class="detail_data_head">Time</div>
						<?= $date_start." ".$time_start." ~ ".$date_end." ".$time_end ?>
						</li>
						<li class="detail_link">
							<div class="detail_data_head">Link</div>
						<?= "<a herf=\"$url\">$url</a>" ?>
						</li>
						<li class="detail_organizer">
							<div class="detail_data_head">Organizer</div>
						<?= $host ?>
						</li>
					</div><!--detail_data_wrapper-->
					<div class="detail_nav_wrapper">
						<div class="list_title"><?= $name ?></div>
						<div class="detail_nav">
							<span class="nav_date"><?= $date ?></span>
							<span class="nav_place">
								<img src="assets/img/movement/mo-lo.png" />
								<span><?= $city ?></span>
							</span>
							<span class="nav_category"><img src="" /></span>
						</div>
					</div><!--detail_nav_wrapper-->
					<img id="detail_close" src="assets/img/movement/mo-xx01.png" />
					<div class="op_issue_data_wrapper">
						<img src="assets/img/movement/mo-ar.png">
					</div><!--op_issue_data_wrapper-->
					<div class="issue_data_wrapper">
						<div>Recommend</div>
						<li></li>
						<li></li>
						<li></li>
					</div><!--issue_data_wrapper-->
				</div><!--movement_list_detail-->
