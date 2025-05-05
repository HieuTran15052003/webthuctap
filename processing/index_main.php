<!-- SECTION -->
<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Sản phẩm mới</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<?php
									    include('processing/handle_siderbar.php')
									?>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<!-- Đây là nơi nạp sản phẩm -->
									<div class="products-slick" data-nav="#slick-nav-1">
									    <?php 
										    include('processing/main_product1.php')
										?>
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
<!-- /SECTION -->
 <!-- HOT DEAL SECTION -->
<div id="hot-deal" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="hot-deal">
							<ul class="hot-deal-countdown">
								<li>
									<div>
										<h3 id="days">00</h3>
										<span>Days</span>
									</div>
								</li>
								<li>
									<div>
										<h3 id="hours">00</h3>
										<span>Hours</span>
									</div>
								</li>
								<li>
									<div>
										<h3 id="minutes">00</h3>
										<span>Mins</span>
									</div>
								</li>
								<li>
									<div>
										<h3 id="seconds">00</h3>
										<span>Secs</span>
									</div>
								</li>
							</ul>
							<script src="./js/countdown.js"></script>
							<h2 class="text-uppercase">Giảm giá trong tuần này</h2>
							<p>Những sản phẩm mới đã giảm giá 50%</p>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
<!-- /HOT DEAL SECTION -->
 <!-- SECTION -->
<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Sản phẩm bán chạy nhất</h3>
							<div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<?php
									    include('processing/handle_siderbar1.php')
									?>
								</ul>
							</div>
						</div>
					</div>
					<!-- /section title -->

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-2">
										<?php 
										    include('processing/main_product2.php')
										?>
									</div>
									<div id="slick-nav-2" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
<!-- /SECTION -->
<!-- SECTION -->
<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Bán chạy nhất</h4>
							<div class="section-nav">
								<div id="slick-nav-3" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-3">
						    <?php 
								include('processing/main_product3.php')
							?>
						</div>
					</div>

					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Sản phẩm mới</h4>
							<div class="section-nav">
								<div id="slick-nav-4" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-4">
						    <?php 
								include('processing/main_product4.php')
							?>
						</div>
					</div>

					<div class="clearfix visible-sm visible-xs"></div>

					<div class="col-md-4 col-xs-6">
						<div class="section-title">
							<h4 class="title">Giá thành tốt</h4>
							<div class="section-nav">
								<div id="slick-nav-5" class="products-slick-nav"></div>
							</div>
						</div>

						<div class="products-widget-slick" data-nav="#slick-nav-5">
						    <?php 
								include('processing/main_product5.php')
							?>
						</div>
					</div>

				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
<!-- /SECTION -->
