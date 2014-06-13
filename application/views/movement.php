		<div id = "movement_layout" class = "layout">
			<div id="movement" class="wrapper">
				<div class = "movement_display_mode">
					<span class="tag_type">
						<li class = "tag_type time">
							<img src="assets/img/movement/mo-ti01.png" class="none_selected"  />
							 <img src="assets/img/movement/mo-ti02.png" class="selected"/>
						</li>
						<li class = "tag_type hot">
							<img src="assets/img/movement/mo-ho01.png" class="none_selected"  />
							<img src="assets/img/movement/mo-ho02.png" class="selected"/>
						</li>
						<li class = "tag_type new">
							<img src="assets/img/movement/mo-ne01.png" class="none_selected"  />
							<img src="assets/img/movement/mo-ne02.png" class="selected"/>
						</li>
						<li class = "tag_type issue">
							<img src="assets/img/movement/mo-is01.png" class="none_selected"  />
							<img src="assets/img/movement/mo-is02.png" class="selected"/>
						</li>
					</span><!--tag_type -->
					<span class="display_type">
						<li class="display_type picture">
							<img src="assets/img/movement/mo-pi01.png" class="none_selected"  />
							<img src="assets/img/movement/mo-pi02.png" class="selected" />
						</li>
						<li class="display_type list">
							<img src="assets/img/movement/mo-li01.png" class="none_selected"  />
							<img src="assets/img/movement/mo-li02.png" class="selected" />
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
<?php $this->load->view('lists'); ?>
				<div class="detail_mask"></div>
<?php $this->load->view('detail'); ?>
			</div><!--movement wrapper-->
		</div><!-- movement_layout -->
