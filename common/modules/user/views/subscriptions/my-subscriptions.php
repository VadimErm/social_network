<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Url;

?>
<?php $this->title = 'Arba.ae / My page'; ?>

<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<?php \frontend\assets\BowerAsset::register($this)?>
		
		<!-- Breadcrumbs -->
		<div class="breadcrumbs hide-on-small-only">
			<div class="container">
				<div class="col s12">
					<ul class="clearfix">
						<li class="active">My subscriptions</li>
						<li>&rarr;</li>
						<li><a href="profile.html">my profile</a></li>
						<li>&rarr;</li>
						<li><a href="index.html">main</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs -->
		
		<!-- wrapper -->
		<div class="section subscriptions">
			<div class="container">
				<div class="row">
					<div class="col s12">
						<h5>My subscriptions</h5>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m12 l3">
						<aside class="htabs-wrap">
							<a class="btn-large waves-effect full" href="profile.html">back to profile</a>
							<ul class="bordered-box edit-menu htabs">
								<li class="tab profile-info-row">
									<a class="active" href="#ublogs">blogs</a>
								</li>
								<li class="tab profile-info-row">
									<a href="#bcjournals">Car’s journals</a>
								</li>
								<li class="tab profile-info-row">
									<a href="#bcommunities">communities</a>
								</li>
							</ul>
						</aside>
					</div>
					<div class="col s12 m12 l9 subscriptions-content">
						<div class="row">
							<div class="col input-field s12">
								<input id="susers" type="text" placeholder="Search">
								<span class="ico-magnifier"></span>
							</div>
						</div>
						<div id="ublogs">
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<img src="images/u-avatar1.jpg" alt="user avatar">
								</div>
								<div class="b-body">
									<a href="#" class="bolder truncate">CrazyDriver90</a>
									<div class="sub-title"><span class="uname">Aahil Asad</span><span class="date-title">Was online at 09:46 pm, 10.01.2017</span></div>
									<div class="city truncate">
										Dubai, UAE
									</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
														<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<img src="images/u-avatar2.jpg" alt="user avatar">
								</div>
								<div class="b-body">
									<a href="#" class="bolder truncate">CrazyDriver90</a>
									<div class="sub-title"><span class="uname">Aahil Asad</span><span class="date-title">Was online at 09:46 pm, 10.01.2017</span></div>
									<div class="city truncate">
										Dubai, UAE
									</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
														<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<img src="images/u-avatar3.jpg" alt="user avatar">
								</div>
								<div class="b-body">
									<a href="#" class="bolder truncate">CrazyDriver90</a>
									<div class="sub-title"><span class="uname">Aahil Asad</span><span class="date-title">Was online at 09:46 pm, 10.01.2017</span></div>
									<div class="city truncate">
										Dubai, UAE
									</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
														<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<img src="images/u-avatar1.jpg" alt="user avatar">
								</div>
								<div class="b-body">
									<a href="#" class="bolder truncate">CrazyDriver90</a>
									<div class="sub-title"><span class="uname">Aahil Asad</span><span class="date-title">Was online at 09:46 pm, 10.01.2017</span></div>
									<div class="city truncate">
										Dubai, UAE
									</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
														<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<img src="images/u-avatar2.jpg" alt="user avatar">
								</div>
								<div class="b-body">
									<a href="#" class="bolder truncate">CrazyDriver90</a>
									<div class="sub-title"><span class="uname">Aahil Asad</span><span class="date-title">Was online at 09:46 pm, 10.01.2017</span></div>
									<div class="city truncate">
										Dubai, UAE
									</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<img src="images/u-avatar3.jpg" alt="user avatar">
								</div>
								<div class="b-body">
									<a href="#" class="bolder truncate">CrazyDriver90</a>
									<div class="sub-title"><span class="uname">Aahil Asad</span><span class="date-title">Was online at 09:46 pm, 10.01.2017</span></div>
									<div class="city truncate">
										Dubai, UAE
									</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
						</div>
						<div id="bcjournals">
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo.jpg" alt="car avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">My favorite car Mercedes-Benz</a>
									<div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
									<div class="uname"><a href="user-profile.html">Aahil Asad</a> <span class="city-small">Dubai, UAE</span></div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo2.jpg" alt="car avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">My favorite car Mercedes-Benz</a>
									<div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
									<div class="uname"><a href="user-profile.html">Aahil Asad</a> <span class="city-small">Dubai, UAE</span></div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo3.jpg" alt="car avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">My favorite car Mercedes-Benz</a>
									<div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
									<div class="uname"><a href="user-profile.html">Aahil Asad</a> <span class="city-small">Dubai, UAE</span></div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo4.jpg" alt="car avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">My favorite car Mercedes-Benz</a>
									<div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
									<div class="uname"><a href="user-profile.html">Aahil Asad</a> <span class="city-small">Dubai, UAE</span></div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo5.jpg" alt="car avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">My favorite car Mercedes-Benz</a>
									<div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
									<div class="uname"><a href="user-profile.html">Aahil Asad</a> <span class="city-small">Dubai, UAE</span></div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo6.jpg" alt="car avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">My favorite car Mercedes-Benz</a>
									<div class="sub-title">Mercedes-Benz / W211 / Classic / 2014</div>
									<div class="uname"><a href="user-profile.html">Aahil Asad</a> <span class="city-small">Dubai, UAE</span></div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
						</div>
						<div id="bcommunities">
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo.jpg" alt="community avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">Bmw lovers club</a>
									<div class="city">Dubai, UAE</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo2.jpg" alt="community avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">Bmw lovers club</a>
									<div class="city">Dubai, UAE</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo3.jpg" alt="community avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">Bmw lovers club</a>
									<div class="city">Dubai, UAE</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo4.jpg" alt="community avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">Bmw lovers club</a>
									<div class="city">Dubai, UAE</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo5.jpg" alt="community avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">Bmw lovers club</a>
									<div class="city">Dubai, UAE</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
							<div class="bookmark-row clearfix">
								<div class="preview-img round">
									<a href="user-car-journal.html"><img src="images/in-photo6.jpg" alt="community avatar"></a>
								</div>
								<div class="b-body">
									<a href="user-car-journal.html" class="bolder truncate">Bmw lovers club</a>
									<div class="city">Dubai, UAE</div>
									<a class="btn-gray btn-large waves-effect" href="#">unsubscribe</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /wrapper -->
		
