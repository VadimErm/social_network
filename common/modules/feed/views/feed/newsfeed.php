<?php
/**
 * @var $this \yii\web\View
 */
use yii\helpers\Url;

?>
<?php $this->title = 'Arba.ae / My page'; ?>
<?php if (Yii::$app->session->hasFlash('profile_change')) : ?>
    <?php $msg = Yii::$app->session->getFlash('profile_change') ?>
    <?php $this->registerJs("Materialize.toast('$msg', 4000)") ?>
<?php endif; ?>
<?= $this->render('@frontend/views/site/_blocks/promo_slider') ?>
<?= $this->render('@frontend/views/site/_blocks/menu') ?>
<?php \frontend\assets\BowerAsset::register($this)?>
    <!-- Breadcrumbs -->
		<div class="breadcrumbs hide-on-small-only">
			<div class="container">
				<div class="col s12">
					<ul class="clearfix">
						<li class="active">My newsfeed</li>
						<li>&rarr;</li>
						<li><a href="index.html">main</a></li>
					</ul>
				</div>
			</div>
		</div>
		<!-- Breadcrumbs -->
		
		<!-- wrapper -->
		<div class="section newsfeed-wrap">
			<div class="not-mes-wrap">
				<div class="container">
					<div class="row">
						<div class="col s4 m3 l3">
							<span class="to-top" id="top">Go to top</span>
						</div>
						<div class="col s8 m9 l9">
							<div class="malert">Show <span class="bolder">8</span> new entries</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col s12">
						<h5>My newsfeed</h5>
					</div>
				</div>
				<div class="row t-car-filter">
					<div class="input-field col s12 m3 l4">
						<select name="country">
						  <option value="" disabled>Country</option>
						  <option value="Russian Federation">Russian Federation</option>
						  <option value="USA">USA</option>
						  <option value="UAE" selected>UAE</option>
						</select>
					</div>
					<div class="input-field col s12 m3 l4">
						<input type="text" id="city" class="autocomplete" placeholder="City" value="Dubai">
					</div>
					<div class="input-field col s12 m3 l4">
						<select name="language">
						  <option disabled selected>Choose entry’s language</option>
						  <option value="english">English</option>
						  <option value="arabic">Arabic</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m12 l3">
						<aside class="htabs-wrap">
							<ul class="bordered-box edit-menu htabs">
								<li class="tab profile-info-row">
									<a class="active" href="#allentries">All entries</a>
								</li>
								<li class="tab profile-info-row">
									<a href="#cjournals">Cars journals</a>
								</li>
								<li class="tab profile-info-row">
									<a href="#ublogs">Users blogs</a>
								</li>
								<li class="tab profile-info-row">
									<a href="#communities">Communities</a>
								</li>
							</ul>
						</aside>
					</div>
					<div class="col s12 m12 l9">
						<div id="allentries">
							<div class="entries-wrap">
								<div class="entry bordered-box">
									<div class="preview-info clearfix">
										<div class="cat-badge">
											<a href="#">cars journals</a>
										</div>
										<div class="bookmark">
											<a href="#"><img src="images/bookmark.svg" alt="add to bookmarks"></a>
										</div>
									</div>
									<div class="top-entry clearfix">
										<a class="u-avatar round" href="user-car-journal.html">
											<img src="images/merc.jpg" alt="avatar">
										</a>
										<div class="top-entry-info">
											<div class="top-entry-meta">
												<a href="user-car-journal.html">Mercedes-benz / w211 / classic / 2014 / My favorite car mercedes-benz</a>
											</div>
											<div class="user-main-car">
												<strong>Owner:</strong> <a href="user-profile.html">Ahmed Asad</a>
											</div>
											<div class="entry-date">
												Posted on 30.11.2016, 09:46 am
											</div>
											<div class="f-actions">
												<a href="#">UNSUBSCRIBE</a>
											</div>
										</div>
									</div>
									<div class="entry-content">
										<div class="gallery-preview-block clearfix">
											<div class="main-preview-img">
												<a href="#">
													<img src="images/post-preview5.jpg" alt="image">
												</a>
											</div>
											<div class="gallery-items-wrap">
												<div class="gallery-item-preview">
													<div class="gallery-item-inner">
														<a href="#">
															<img src="images/post-preview1.jpg" alt="image">
														</a>
													</div>
												</div>
												<div class="gallery-item-preview">
													<div class="gallery-item-inner">
														<a href="#">
															<img src="images/post-preview2.jpg" alt="image">
														</a>
													</div>
												</div>
												<div class="gallery-item-preview">
													<div class="gallery-item-inner">
														<a href="#">
															<img src="images/post-preview3.jpg" alt="image">
														</a>
													</div>
												</div>
												<div class="gallery-item-preview">
													<div class="gallery-item-inner">
														<a href="#">
															<span class="gallery-item-more">
																<span class="item-label">+4</span>
															</span>
															<img src="images/post-preview4.jpg" alt="image">
														</a>
													</div>
												</div>
											</div>
										</div>
										<h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
										<div class="preview-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="full-post">
											  
											<img src="images/post-preview5.jpg" alt="image">
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="more">read more</div>
										<div class="t-entry">Mileage: 120000 km </div>
										<div class="entry-info">
											<div class="share-block">
												<div class="share-item">
													<a href="#"><span class="ico-heart-outline"></span>144</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>23</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-upload-symbol"></span>144</a>
												</div>
											</div>
										</div>
										<div class="entry-comments">
											<a href="#" class="btn-large btn-gray waves more-btn">show more comments</a>
											<div class="entry-comment">
												<div class="u-avatar round small">
													<img src="images/u-avatar1.jpg" alt="user avatar">
												</div>
												<div class="comment-body">
													<div class="top-entry-meta">
														<a href="#">Aahil Asad</a>
														<div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>777</div>
														<div class="entry-date">
															Posted on 30.11.2016, 09:46 am
														</div>
													</div>
													<p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod. Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
													<div class="comment-footer clearfix">
														<div class="answer">answer</div>
														<div class="like"><a href="#"><span class="ico-heart-outline"></span>1</a></div>
														<div class="c-options">
															<a href="#" class="spam">spam</a>
														</div>
													</div>
													<div class="bottom-entry">
														<div class="u-avatar round small">
															<img src="images/user.png" alt="user avatar">
														</div>
														<div class="comment-body">
															<div class="row">
																<div class="input-field col s12">
																  <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
																  <label for="entry-text">Add a comment</label>
																</div>
																<div class="col s12">
																	<a href="#" class="waves-effect btn-large">answer</a><div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="entry-comment">
												<div class="u-avatar round small">
													<img src="images/u-avatar2.jpg" alt="user avatar">
												</div>
												<div class="comment-body">
													<div class="top-entry-meta">
														<a href="#">Amira</a>
														<div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>777</div>
														<span class="answer-label">answered to Aahil</span>
														<div class="entry-date">
															Posted on 30.11.2016, 09:46 am
														</div>
													</div>
													<p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod. Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
													<div class="comment-footer clearfix">
														<div class="answer">answer</div>
														<div class="like"><a href="#"><span class="ico-heart-outline"></span>1</a></div>
														<div class="c-options">
															<a href="#" class="spam">spam</a>
														</div>
													</div>
													<div class="bottom-entry">
														<div class="u-avatar round small">
															<img src="images/user.png" alt="user avatar">
														</div>
														<div class="comment-body">
															<div class="row">
																<div class="input-field col s12">
																  <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
																  <label for="entry-text">Add a comment</label>
																</div>
																<div class="col s12">
																	<a href="#" class="waves-effect btn-large">answer</a><div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="bottom-entry">
										<div class="u-avatar round small">
											<img src="images/user.png" alt="user avatar">
										</div>
										<div class="comment-body">
											<div class="row">
												<div class="input-field col s12">
												  <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
												  <label for="entry-text">Add a comment</label>
												</div>
												<div class="col s12">
													<a href="#" class="waves-effect btn-large">add a comment</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="entry bordered-box">
									<div class="preview-info clearfix">
										<div class="cat-badge">
											<a href="#">users blogs</a>
										</div>
										<div class="bookmark">
											<a href="#"><img src="images/bookmark.svg" alt="add to bookmarks"></a>
										</div>
									</div>
									<div class="top-entry clearfix">
										<a class="u-avatar round" href="#">
											<img src="images/user.png" alt="user avatar">
										</a>
										<div class="top-entry-info">
											<div class="top-entry-meta">
												<a href="#">Aahil Asad</a>
												<div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>777</div>
												<span class="badge green online">online</span>
											</div>
											<div class="user-main-car">
												<strong>Car:</strong> <a href="#">Mercedes-Benz / W211 / Classic / 2014</a>
											</div>
											<div class="entry-date">
												Posted on 30.11.2016, 09:46 am
											</div>
											<div class="f-actions">
												<a href="#">UNSUBSCRIBE</a>
											</div>
										</div>
									</div>
									<div class="entry-content">
										<h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
										<div class="preview-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="full-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="more">read more</div>
										<div class="entry-info">
											<div class="share-block">
												<div class="share-item">
													<a href="#"><span class="ico-heart-outline"></span>144</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>23</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-upload-symbol"></span>144</a>
												</div>
											</div>
										</div>
									</div>
									<div class="bottom-entry">
										<div class="u-avatar round small">
											<img src="images/user.png" alt="user avatar">
										</div>
										<div class="comment-body">
											<div class="row">
												<div class="input-field col s12">
												  <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
												  <label for="entry-text">Add a comment</label>
												</div>
												<div class="col s12">
													<a href="#" class="waves-effect btn-large">add a comment</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="entry bordered-box">
									<div class="preview-info clearfix">
										<div class="cat-badge">
											<a href="#">communities</a>
										</div>
										<div class="bookmark">
											<a href="#"><img src="images/bookmark.svg" alt="add to bookmarks"></a>
										</div>
									</div>
									<div class="top-entry clearfix">
										<a class="u-avatar round" href="#">
											<img src="images/community-ava_big.jpg" alt="community avatar">
										</a>
										<div class="top-entry-info">
											<div class="top-entry-meta">
												<a href="#">BMW Lovers Club</a>
											</div>
											<div class="entry-date">
												Posted on 30.11.2016, 09:46 am
											</div>
											<div class="f-actions">
												<a href="#">UNSUBSCRIBE</a>
											</div>
										</div>
									</div>
									<div class="entry-content">
										<h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
										<div class="preview-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="full-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="more">read more</div>
										<div class="entry-info no-comments">
											<div class="share-block">
												<div class="share-item">
													<a href="#"><span class="ico-heart-outline"></span>144</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>23</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-upload-symbol"></span>144</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<a href="#" class="btn-large full btn-gray waves-effect waves more-btn">load more</a>
						</div>
						<div id="cjournals">
							<div class="entries-wrap">
								<div class="entry bordered-box">
									<div class="preview-info clearfix">
										<div class="cat-badge">
											<a href="#">cars journals</a>
										</div>
										<div class="bookmark">
											<a href="#"><img src="images/bookmark.svg" alt="add to bookmarks"></a>
										</div>
									</div>
									<div class="top-entry clearfix">
										<a class="u-avatar round" href="user-car-journal.html">
											<img src="images/merc.jpg" alt="avatar">
										</a>
										<div class="top-entry-info">
											<div class="top-entry-meta">
												<a href="user-car-journal.html">Mercedes-benz / w211 / classic / 2014 / My favorite car mercedes-benz</a>
											</div>
											<div class="user-main-car">
												<strong>Owner:</strong> <a href="user-profile.html">Ahmed Asad</a>
											</div>
											<div class="entry-date">
												Posted on 30.11.2016, 09:46 am
											</div>
											<div class="f-actions">
												<a href="#">UNSUBSCRIBE</a>
											</div>
										</div>
									</div>
									<div class="entry-content">
										<div class="gallery-preview-block clearfix">
											<div class="main-preview-img">
												<a href="#">
													<img src="images/post-preview5.jpg" alt="image">
												</a>
											</div>
											<div class="gallery-items-wrap">
												<div class="gallery-item-preview">
													<div class="gallery-item-inner">
														<a href="#">
															<img src="images/post-preview1.jpg" alt="image">
														</a>
													</div>
												</div>
												<div class="gallery-item-preview">
													<div class="gallery-item-inner">
														<a href="#">
															<img src="images/post-preview2.jpg" alt="image">
														</a>
													</div>
												</div>
												<div class="gallery-item-preview">
													<div class="gallery-item-inner">
														<a href="#">
															<img src="images/post-preview3.jpg" alt="image">
														</a>
													</div>
												</div>
												<div class="gallery-item-preview">
													<div class="gallery-item-inner">
														<a href="#">
															<span class="gallery-item-more">
																<span class="item-label">+4</span>
															</span>
															<img src="images/post-preview4.jpg" alt="image">
														</a>
													</div>
												</div>
											</div>
										</div>
										<h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
										<div class="preview-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="full-post">
											  
											<img src="images/post-preview5.jpg" alt="image">
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="more">read more</div>
										<div class="t-entry">Mileage: 120000 km </div>
										<div class="entry-info">
											<div class="share-block">
												<div class="share-item">
													<a href="#"><span class="ico-heart-outline"></span>144</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>23</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-upload-symbol"></span>144</a>
												</div>
											</div>
										</div>
										<div class="entry-comments">
											<a href="#" class="btn-large btn-gray waves more-btn">show more comments</a>
											<div class="entry-comment">
												<div class="u-avatar round small">
													<img src="images/u-avatar1.jpg" alt="user avatar">
												</div>
												<div class="comment-body">
													<div class="top-entry-meta">
														<a href="#">Aahil Asad</a>
														<div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>777</div>
														<div class="entry-date">
															Posted on 30.11.2016, 09:46 am
														</div>
													</div>
													<p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod. Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
													<div class="comment-footer clearfix">
														<div class="answer">answer</div>
														<div class="like"><a href="#"><span class="ico-heart-outline"></span>1</a></div>
														<div class="c-options">
															<a href="#" class="spam">spam</a>
														</div>
													</div>
													<div class="bottom-entry">
														<div class="u-avatar round small">
															<img src="images/user.png" alt="user avatar">
														</div>
														<div class="comment-body">
															<div class="row">
																<div class="input-field col s12">
																  <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
																  <label for="entry-text">Add a comment</label>
																</div>
																<div class="col s12">
																	<a href="#" class="waves-effect btn-large">answer</a><div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="entry-comment">
												<div class="u-avatar round small">
													<img src="images/u-avatar2.jpg" alt="user avatar">
												</div>
												<div class="comment-body">
													<div class="top-entry-meta">
														<a href="#">Amira</a>
														<div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>777</div>
														<span class="answer-label">answered to Aahil</span>
														<div class="entry-date">
															Posted on 30.11.2016, 09:46 am
														</div>
													</div>
													<p>Pellentesque commodo convallis sem. Ut consequat felis sed lacus placerat, at lacinia urna euismod. Vivamus dignissim felis arcu, at convallis purus gravida ac. Curabitur elementum pellentesque leo at pellentesque. Mauris sed sem non magna malesuada feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
													<div class="comment-footer clearfix">
														<div class="answer">answer</div>
														<div class="like"><a href="#"><span class="ico-heart-outline"></span>1</a></div>
														<div class="c-options">
															<a href="#" class="spam">spam</a>
														</div>
													</div>
													<div class="bottom-entry">
														<div class="u-avatar round small">
															<img src="images/user.png" alt="user avatar">
														</div>
														<div class="comment-body">
															<div class="row">
																<div class="input-field col s12">
																  <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
																  <label for="entry-text">Add a comment</label>
																</div>
																<div class="col s12">
																	<a href="#" class="waves-effect btn-large">answer</a><div class="btn-gray btn-ui waves-effect"><input type="file" multiple=""><span class="ico-photo-camera-outlined-interface-symbol"></span></div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="bottom-entry">
										<div class="u-avatar round small">
											<img src="images/user.png" alt="user avatar">
										</div>
										<div class="comment-body">
											<div class="row">
												<div class="input-field col s12">
												  <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
												  <label for="entry-text">Add a comment</label>
												</div>
												<div class="col s12">
													<a href="#" class="waves-effect btn-large">add a comment</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="ublogs">
							<div class="entries-wrap">
								<div class="entry bordered-box">
									<div class="preview-info clearfix">
										<div class="cat-badge">
											<a href="#">users blogs</a>
										</div>
										<div class="bookmark">
											<a href="#"><img src="images/bookmark.svg" alt="add to bookmarks"></a>
										</div>
									</div>
									<div class="top-entry clearfix">
										<a class="u-avatar round" href="#">
											<img src="images/user.png" alt="user avatar">
										</a>
										<div class="top-entry-info">
											<div class="top-entry-meta">
												<a href="#">Aahil Asad</a>
												<div class="u-rating"><span class="ico-favorites-star-outlined-symbol"></span>777</div>
												<span class="badge green online">online</span>
											</div>
											<div class="user-main-car">
												<strong>Car:</strong> <a href="#">Mercedes-Benz / W211 / Classic / 2014</a>
											</div>
											<div class="entry-date">
												Posted on 30.11.2016, 09:46 am
											</div>
											<div class="f-actions">
												<a href="#">UNSUBSCRIBE</a>
											</div>
										</div>
									</div>
									<div class="entry-content">
										<h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
										<div class="preview-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="full-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="more">read more</div>
										<div class="entry-info">
											<div class="share-block">
												<div class="share-item">
													<a href="#"><span class="ico-heart-outline"></span>144</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>23</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-upload-symbol"></span>144</a>
												</div>
											</div>
										</div>
									</div>
									<div class="bottom-entry">
										<div class="u-avatar round small">
											<img src="images/user.png" alt="user avatar">
										</div>
										<div class="comment-body">
											<div class="row">
												<div class="input-field col s12">
												  <textarea name="entry-text" class="entry-text materialize-textarea"></textarea>
												  <label for="entry-text">Add a comment</label>
												</div>
												<div class="col s12">
													<a href="#" class="waves-effect btn-large">add a comment</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="communities">
							<div class="entries-wrap">
								<div class="entry bordered-box">
									<div class="preview-info clearfix">
										<div class="cat-badge">
											<a href="#">communities</a>
										</div>
										<div class="bookmark">
											<a href="#"><img src="images/bookmark.svg" alt="add to bookmarks"></a>
										</div>
									</div>
									<div class="top-entry clearfix">
										<a class="u-avatar round" href="#">
											<img src="images/community-ava_big.jpg" alt="community avatar">
										</a>
										<div class="top-entry-info">
											<div class="top-entry-meta">
												<a href="#">BMW Lovers Club</a>
											</div>
											<div class="entry-date">
												Posted on 30.11.2016, 09:46 am
											</div>
											<div class="f-actions">
												<a href="#">UNSUBSCRIBE</a>
											</div>
										</div>
									</div>
									<div class="entry-content">
										<h6>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h6>
										<div class="preview-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="full-post">
											  
											<p>Vivamus elementum, ipsum aliquam dignissim iaculis, nibh ligula efficitur magna, eu sagittis neque nisi vel ante. Integer quam mauris, placerat ac orci condimentum, lacinia finibus dolor.</p>
										</div>
										<div class="more">read more</div>
										<div class="entry-info no-comments">
											<div class="share-block">
												<div class="share-item">
													<a href="#"><span class="ico-heart-outline"></span>144</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-speech-bubble-rectangular-chat-symbol"></span>23</a>
												</div>
												<div class="share-item">
													<a href="#"><span class="ico-upload-symbol"></span>144</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /wrapper -->
		
