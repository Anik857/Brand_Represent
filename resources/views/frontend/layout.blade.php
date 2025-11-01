<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="author" content="Themezhub">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>Brand Represent - Fashion eCommerce</title>

	<!-- Custom CSS -->
	<link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">
	<style>
		/* Center images inside quickview slider */
		#quickview .quick_view_slide {
			text-align: center;
		}

		#quickview .single_view_slide {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 360px;
		}

		#quickview .single_view_slide img {
			max-width: 100%;
			max-height: 360px;
			height: auto;
			width: auto;
			margin: 0 auto;
		}
	</style>

</head>

<body>
	<div class="preloader"></div>
	<!-- ============================================================== -->
	<div id="main-wrapper">
		<div class="header header-light dark-text">
			<div class="container">
				<nav id="navigation" class="navigation navigation-landscape">
					<div class="nav-header">
						<a class="nav-brand" href="#">
							<img src="{{ asset('frontend/assets/img/brand_logo.jpg') }}" class="logo" alt="">
						</a>
						<div class="nav-toggle"></div>
						<div class="mobile_nav">
							<ul>
								<li>
									<a href="#" onclick="openSearch()">
										<i class="lni lni-search-alt"></i>
									</a>
								</li>
								<li>
									<a href="#" data-bs-toggle="modal" data-bs-target="#login">
										<i class="lni lni-user"></i>
									</a>
								</li>
								<li>
									<a href="#" onclick="openWishlist()">
										<i class="lni lni-heart"></i><span class="dn-counter">2</span>
									</a>
								</li>
								<li>
									<a href="#" onclick="openCart()">
										<i class="lni lni-shopping-basket"></i><span class="dn-counter">0</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="nav-menus-wrapper" style="transition-property: none;">

						<ul class="nav-menu nav-menu-social align-to-right align-items-center justify-content-center">
							<li>
								<a href="#" onclick="openSearch()">
									<i class="lni lni-search-alt"></i>
								</a>
							</li>
							<li>
								<a href="#" data-bs-toggle="modal" data-bs-target="#login">
									<i class="lni lni-user"></i>
								</a>
							</li>
							<li>
								<a href="#" >
									<i class="lni lni-heart"></i><span class="dn-counter">0</span>
								</a>
							</li>
							<li>
								<a href="#" onclick="openCart()">
									<i class="lni lni-shopping-basket"></i><span class="dn-counter theme-bg">0</span>
								</a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>
		<!-- End Navigation -->
		<div class="clearfix"></div>
		<!-- ============================================================== -->
		<!-- Top header  -->
		<!-- ============================================================== -->

		<!-- ======================= Category Style 1 ======================== -->
		<section class="p-0">
			<div class="container-fluid p-0">
				<div class="row g-0">

					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
						<a href="#" class="card card-overflow card-scale no-radius mb-0">
							<div class="bg-image" data-bg="{{ optional(\App\Models\Banner::where('key','home_banner_1')->where('is_active', true)->first())->image_url ?? asset('frontend/assets/img/banner_1.jpg') }}" data-overlay="2">
							</div>
							<div class="ct_body">
								<div class="ct_body_caption">
									<h1 class="mb-0 ft-bold text-light"></h1>
								</div>
							</div>
						</a>
					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
						<a href="#" class="card card-overflow card-scale no-radius mb-0">
							<div class="bg-image" data-bg="{{ optional(\App\Models\Banner::where('key','home_banner_2')->where('is_active', true)->first())->image_url ?? asset('frontend/assets/img/banner_2.jpg') }}" data-overlay="2">
							</div>
							<div class="ct_body">
								<div class="ct_body_caption">
									<h1 class="mb-0 ft-bold text-light"></h1>
								</div>
							</div>
						</a>
					</div>

					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
						<a href="#" class="card card-overflow card-scale no-radius mb-0">
							<div class="bg-image" data-bg="{{ optional(\App\Models\Banner::where('key','home_banner_3')->where('is_active', true)->first())->image_url ?? asset('frontend/assets/img/banner_3.jpg') }}" data-overlay="2">
							</div>
							<div class="ct_body">
								<div class="ct_body_caption">
									<h1 class="mb-0 ft-bold text-light"></h1>
								</div>
							</div>
						</a>
					</div>

				</div>
			</div>
		</section>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				document.querySelectorAll('.bg-image[data-bg]').forEach(function(el) {
					var src = el.getAttribute('data-bg');
					if (src) {
						el.style.backgroundImage = 'url(' + src + ')';
						el.style.backgroundRepeat = 'no-repeat';
						el.style.backgroundSize = 'cover';
						el.style.backgroundPosition = 'center';
					}
				});
			});
		</script>
		<!-- ======================= Category Style 1 ======================== -->

		<!-- ======================= Product List ======================== -->
		<section class="middle">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="sec_title position-relative text-center">
							<h2 class="off_title">Trendy Products</h2>
							<h3 class="ft-bold pt-3">Our Trending Products</h3>
						</div>
					</div>
				</div>

				<!-- row -->
				<div class="row align-items-center rows-products">
					@forelse($trendyProducts as $product)
					<div class="col-xl-3 col-lg-4 col-md-6 col-6">
						<div class="product_grid card b-0">
							@php
							$badge = null;
							if (($product->quantity ?? 0) <= 0) {
								$badge=['bg-sold', 'Sold Out' ];
								} elseif ($product->compare_price && $product->compare_price > $product->price) {
								$badge = ['bg-sale', 'Sale'];
								} elseif ($product->featured) {
								$badge = ['bg-hot', 'Hot'];
								}
								@endphp
								@if($badge)
								<div class="badge {{ $badge[0] }} text-white position-absolute ft-regular ab-left text-upper">{{ $badge[1] }}</div>
								@endif
								<button class="btn btn_love position-absolute ab-right snackbar-wishlist"><i class="far fa-heart"></i></button>
								<div class="card-body p-0">
									<div class="shop_thumb position-relative">
										<a class="card-img-top d-block overflow-hidden" href="#" data-product-id="{{ $product->id }}" onclick="openQuickView(event, {{ $product->id }})">
											<img class="card-img-top" src="{{ $product->main_image }}" alt="{{ $product->name }}">
										</a>
										<div class="product-hover-overlay bg-dark d-flex align-items-center justify-content-center">
											<div class="edlio"><a href="#" class="text-white fs-sm ft-medium" onclick="openQuickView(event, {{ $product->id }})"><i class="fas fa-eye me-1"></i>Quick View</a></div>
										</div>
									</div>
								</div>
								<div class="card-footers b-0 pt-3 px-2 bg-white d-flex align-items-start justify-content-center">
									<div class="text-left">
										<div class="text-center">
											<h5 class="fw-normal fs-md mb-0 lh-1 mb-1"><a href="#">{{ $product->name }}</a></h5>
											<div class="elis_rty">
												@if($product->compare_price && $product->compare_price > $product->price)
												<span class="text-muted ft-medium line-through me-2">৳{{ number_format($product->compare_price, 2) }}</span>
												@endif
												<span class="fw-medium fs-md text-dark">৳{{ number_format($product->price, 2) }}</span>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>
					@empty
					<div class="col-12">
						<p class="text-center text-muted">No trendy products available.</p>
					</div>
					@endforelse
				</div>
				<!-- row -->
			</div>
		</section>
		<!-- ======================= Product List ======================== -->

		<!-- ======================= Blog Start ============================ -->
		<section class="space min">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="sec_title position-relative text-center">
							<h2 class="off_title">Latest News</h2>
							<h3 class="ft-bold pt-3">New Updates</h3>
						</div>
					</div>
				</div>

				<div class="row">
					@forelse($latestBlogs as $blog)
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
						<div class="_blog_wrap">
							<div class="_blog_thumb mb-2">
								<a href="javascript:void(0);" class="d-block">
									<img src="{{ asset($blog->featured_image) }}" class="img-fluid rounded" alt="{{ $blog->title }}">
								</a>
							</div>
							<div class="_blog_caption">
								<span class="text-muted">{{ $blog->formatted_date }}</span>
								<h5 class="bl_title lh-1">
									<a href="javascript:void(0);">{{ $blog->short_title }}</a>
								</h5>
								<p>{{ $blog->excerpt }}</p>
								<a href="javascript:void(0);" class="text-dark fs-sm">Continue Reading..</a>
							</div>
						</div>
					</div>
					@empty
					<div class="col-12">
						<div class="text-center py-5">
							<h4>No blog posts available</h4>
							<p class="text-muted">Check back later for updates!</p>
						</div>
					</div>
					@endforelse
				</div>

			</div>
		</section>
		<!-- ======================= Blog Start ============================ -->

		<!-- ======================= Customer Features ======================== -->
		<section class="px-0 py-3 br-top">
			<div class="container">
				<div class="row">

					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="d-flex align-items-center justify-content-start py-2">
							<div class="d_ico">
								<i class="fas fa-shopping-basket"></i>
							</div>
							<div class="d_capt">
								<h5 class="mb-0">Free Shipping</h5>
								<span class="text-muted">Capped at ৳10 per order</span>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="d-flex align-items-center justify-content-start py-2">
							<div class="d_ico">
								<i class="far fa-credit-card"></i>
							</div>
							<div class="d_capt">
								<h5 class="mb-0">Secure Payments</h5>
								<span class="text-muted">Up to 6 months installments</span>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="d-flex align-items-center justify-content-start py-2">
							<div class="d_ico">
								<i class="fas fa-shield-alt"></i>
							</div>
							<div class="d_capt">
								<h5 class="mb-0">15-Days Returns</h5>
								<span class="text-muted">Shop with fully confidence</span>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
						<div class="d-flex align-items-center justify-content-start py-2">
							<div class="d_ico">
								<i class="fas fa-headphones-alt"></i>
							</div>
							<div class="d_capt">
								<h5 class="mb-0">24x7 Fully Support</h5>
								<span class="text-muted">Get friendly support</span>
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>
		<!-- ======================= Customer Features ======================== -->

		<!-- ============================ Footer Start ================================== -->
		<footer class="dark-footer skin-dark-footer style-2">
			<div class="footer-middle">
				<div class="container">
					<div class="row">

						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
							<div class="footer_widget">
								<img src="{{ asset('frontend/assets/img/brand_logo.jpg') }}" class="img-footer small mb-2" alt="">

								<div class="address mt-3">
									Pulsar fashion,(1st outlet)Nagar plaza,<br>fulbaria,1st floor,shop no: 85.
								</div>
								<div class="address mt-3">
									01675338219<br>brandrepresent.com
								</div>
								<div class="address mt-3">
									<ul class="list-inline">
										<li class="list-inline-item"><a href="#"><i
													class="lni lni-facebook-filled"></i></a></li>
										<li class="list-inline-item"><a href="#"><i
													class="lni lni-twitter-filled"></i></a></li>
										<li class="list-inline-item"><a href="#"><i
													class="lni lni-instagram-filled"></i></a></li>
									</ul>
								</div>
							</div>
						</div>

						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
							<div class="footer_widget">
								<h4 class="widget_title">Supports</h4>
								<ul class="footer-menu">
									<li><a href="#">Contact Us</a></li>
									<li>
										<p>About Page</p>
									</li>
									<li>
										<p>Size Guide</p>
									</li>
									<li>
										<p>Shipping & Returns</p>
									</li>
									<li>
										<p>FAQ's Page</p>
									</li>
									<li>
										<p>Privacy</p>
									</li>
								</ul>
							</div>
						</div>

						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
							<div class="footer_widget">
								<h4 class="widget_title">Shop</h4>
								<ul class="footer-menu">
									<li>
										<p>Men's Shopping</p>
									</li>
									<li>
										<p>Women's Shopping</p>
									</li>
									<li>
										<p>Kids's Shopping</p>
									</li>
									<li>
										<p>Furniture</p>
									</li>
									<li>
										<p>Discounts</p>
									</li>
								</ul>
							</div>
						</div>

						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
							<div class="footer_widget">
								<h4 class="widget_title">Company</h4>
								<ul class="footer-menu">
									<li>
										<p>About</p>
									</li>
									<li>
										<p>Blog</p>
									</li>
									<li>
										<p>Affiliate</p>
									</li>
									<li>
										<p>Login</p>
									</li>
								</ul>
							</div>
						</div>

						<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
							<div class="footer_widget">
								<h4 class="widget_title">Subscribe</h4>
								<p>Receive updates, hot deals, discounts sent straignt in your inbox daily</p>
								<div class="foot-news-last">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Email Address">
										<div class="input-group-append">
											<button type="button" class="input-group-text rounded-0 text-light"><i
													class="lni lni-arrow-right"></i></button>
										</div>
									</div>
								</div>
								<div class="address mt-3">
									<h5 class="fs-sm text-light">Secure Payments</h5>
									<p>We accept bkash nogod payment gateway and all debit cards</p>
									<div class="scr_payment"><img src="{{ asset('frontend/assets/img/card.png') }}" class="img-fluid" alt="">
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="footer-bottom">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-12 col-md-12 text-center">
							<p class="mb-0">© 2025 Brand Represent. Designd By <a href="https://sajidkhan.dev.com">Sajid
									Khan</a> & <a href="https://anik.dev.com">Anik Dutta</a>.</p>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<!-- ============================ Footer End ================================== -->

		<!-- Product View Modal -->
		<div class="modal fade lg-modal" id="quickview" tabindex="-1" role="dialog" aria-labelledby="quickviewmodal"
			aria-hidden="true">
			<div class="modal-dialog modal-xl login-pop-form" role="document">
				<div class="modal-content" id="quickviewmodal">
					<div class="modal-headers">
						<button type="button" class="border-0 close" data-bs-dismiss="modal" aria-label="Close">
							<span class="ti-close"></span>
						</button>
					</div>

					<div class="modal-body">
						<div class="quick_view_wrap">

							<div class="quick_view_thmb">
								<div class="quick_view_slide"></div>
							</div>

							<div class="quick_view_capt">
								<div class="prd_details">

									<div class="prt_01 mb-1"><span
											class="text-light bg-info rounded px-2 py-1">Dresses</span></div>
									<div class="prt_02 mb-2">
										<h2 class="ft-bold mb-1">Women Striped Shirt Dress</h2>
										<div class="text-left">
											<div
												class="star-rating align-items-center d-flex justify-content-left mb-1 p-0">
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star filled"></i>
												<i class="fas fa-star"></i>
												<span class="small">(412 Reviews)</span>
											</div>
											<div class="elis_rty"><span
													class="ft-medium text-muted line-through fs-md me-2">৳199</span><span
													class="ft-bold theme-cl fs-lg me-2">৳110</span><span
													class="ft-regular text-danger bg-light-danger py-1 px-2 fs-sm">Out
													of Stock</span></div>
										</div>
									</div>

									<div class="prt_03 mb-3">
										<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis
											praesentium voluptatum deleniti atque corrupti quos dolores.</p>
									</div>

									<div class="prt_04 mb-2" id="quickviewColors"></div>

									<div class="prt_04 mb-4" id="quickviewSizes"></div>

									<div class="prt_05 mb-4">
										<div class="form-row row g-3 mb-7">
											<div class="col-12 col-md-6 col-lg-3">
												<!-- Quantity -->
												<select class="mb-2 custom-select">
													<option value="1" selected="">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													<option value="6">6</option>
													<option value="7">7</option>
												</select>
											</div>
											<div class="col-12 col-md-12 col-lg-6">
												<!-- Submit -->
												<button type="button"
													class="btn btn-block custom-height bg-dark mb-2 w-100" onclick="addToCartFromModal()">
													<i class="lni lni-shopping-basket me-2"></i>Add to Cart
												</button>
											</div>
											<div class="col-12 col-md-6 col-lg-3">
												<!-- Wishlist -->
												<button class="btn custom-height btn-default btn-block mb-2 text-dark"
													data-bs-toggle="button">
													<i class="lni lni-heart me-2"></i>Wishlist
												</button>
											</div>
										</div>
									</div>

									<div class="prt_06 mb-3">
										<div class="mb-3">
											<button type="button" class="btn btn-success d-flex align-items-center" onclick="openWhatsApp()">
												<i class="fab fa-whatsapp me-2"></i>
												<span>Wholesale for WhatsApp</span>
											</button>
										</div>
									</div>

									<div class="prt_06">
										<p class="mb-0 d-flex align-items-center">
											<span class="me-4">Share:</span>
											<a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted me-2"
												href="#!">
												<i class="fab fa-twitter position-absolute"></i>
											</a>
											<a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted me-2"
												href="#!">
												<i class="fab fa-facebook-f position-absolute"></i>
											</a>
											<a class="d-inline-flex align-items-center justify-content-center p-3 gray circle fs-sm text-muted"
												href="#!">
												<i class="fab fa-pinterest-p position-absolute"></i>
											</a>
										</p>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Modal -->

		<!-- Log In Modal -->
		<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
			<div class="modal-dialog login-pop-form" role="document">
				<div class="modal-content" id="loginmodal">
					<div class="modal-headers">
						<button type="button" class="border-0 close" data-bs-dismiss="modal" aria-label="Close">
							<span class="ti-close"></span>
						</button>
					</div>

					<div class="modal-body p-5">
						<div class="text-center mb-4">
							<h2 class="m-0 ft-regular">Login</h2>
						</div>

						<form>
							<div class="form-group mb-3">
								<label class="mb-2">User Name</label>
								<input type="text" class="form-control" placeholder="Username*">
							</div>

							<div class="form-group mb-3">
								<label class="mb-2">Password</label>
								<input type="password" class="form-control" placeholder="Password*">
							</div>

							<div class="form-group mb-3">
								<div class="d-flex align-items-center justify-content-between">
									<div class="flex-1">
										<input id="dd" class="checkbox-custom" name="dd" type="checkbox">
										<label for="dd" class="checkbox-custom-label">Remember Me</label>
									</div>
									<div class="eltio_k2">
										<a href="#">Lost Your Password?</a>
									</div>
								</div>
							</div>

							<div class="form-group mb-3">
								<button type="submit"
									class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
							</div>

							<div class="form-group text-center mb-0">
								<p class="extra">Not a member?<a href="#et-register-wrap" class="text-dark">
										Register</a></p>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- End Modal -->

		<!-- Search -->
		<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Search">
			<div class="rightMenu-scroll">
				<div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
					<h4 class="cart_heading fs-md ft-medium mb-0">Search Products</h4>
					<button onclick="closeSearch()" class="close_slide"><i class="ti-close"></i></button>
				</div>

				<div class="cart_action px-3 py-4">
					<form class="form m-0 p-0">
						<div class="form-group mb-3">
							<input type="text" class="form-control" placeholder="Product Keyword..">
						</div>

						<div class="form-group mb-3">
							<select class="custom-select">
								<option value="1" selected="">Choose Category</option>
								<option value="2">Men's Store</option>
								<option value="3">Women's Store</option>
								<option value="4">Kid's Fashion</option>
								<option value="5">Inner Wear</option>
							</select>
						</div>

						<div class="form-group mb-0">
							<button type="button" class="btn d-block full-width btn-dark">Search Product</button>
						</div>
					</form>
				</div>

				<div class="d-flex align-items-center justify-content-center br-top br-bottom py-2 px-3">
					<h4 class="cart_heading fs-md mb-0">Hot Categories</h4>
				</div>

				<div class="cart_action px-3 py-3">
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
							<div class="cats_side_wrap text-center">
								<div class="sl_cat_01">
									<div
										class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
										<a href="javascript:void(0);" class="d-block"><img src="{{ asset('frontend/assets/img/tshirt.png') }}"
												class="img-fluid" width="40" alt=""></a>
									</div>
								</div>
								<div class="sl_cat_02">
									<h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">T-Shirts</a></h6>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
							<div class="cats_side_wrap text-center">
								<div class="sl_cat_01">
									<div
										class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
										<a href="javascript:void(0);" class="d-block"><img src="{{ asset('frontend/assets/img/pant.png') }}"
												class="img-fluid" width="40" alt=""></a>
									</div>
								</div>
								<div class="sl_cat_02">
									<h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Pants</a></h6>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
							<div class="cats_side_wrap text-center">
								<div class="sl_cat_01">
									<div
										class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
										<a href="javascript:void(0);" class="d-block"><img src="{{ asset('frontend/assets/img/fashion.png') }}"
												class="img-fluid" width="40" alt=""></a>
									</div>
								</div>
								<div class="sl_cat_02">
									<h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Women's</a></h6>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
							<div class="cats_side_wrap text-center">
								<div class="sl_cat_01">
									<div
										class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
										<a href="javascript:void(0);" class="d-block"><img src="{{ asset('frontend/assets/img/sneakers.png') }}"
												class="img-fluid" width="40" alt=""></a>
									</div>
								</div>
								<div class="sl_cat_02">
									<h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Shoes</a></h6>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
							<div class="cats_side_wrap text-center">
								<div class="sl_cat_01">
									<div
										class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
										<a href="javascript:void(0);" class="d-block"><img
												src="{{ asset('frontend/assets/img/television.png') }}" class="img-fluid" width="40" alt=""></a>
									</div>
								</div>
								<div class="sl_cat_02">
									<h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Television</a></h6>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-4 mb-3">
							<div class="cats_side_wrap text-center">
								<div class="sl_cat_01">
									<div
										class="d-inline-flex align-items-center justify-content-center p-3 circle mb-2 gray">
										<a href="javascript:void(0);" class="d-block"><img
												src="{{ asset('frontend/assets/img/accessories.png') }}" class="img-fluid" width="40"
												alt=""></a>
									</div>
								</div>
								<div class="sl_cat_02">
									<h6 class="m-0 ft-medium fs-sm"><a href="javascript:void(0);">Accessories</a></h6>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<!-- Wishlist -->
		<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Wishlist">
			<div class="rightMenu-scroll">
				<div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
					<h4 class="cart_heading fs-md ft-medium mb-0">Saved Products</h4>
					<button onclick="closeWishlist()" class="close_slide"><i class="ti-close"></i></button>
				</div>
				<div class="right-ch-sideBar">

					<div class="cart_select_items py-2">
						<!-- Single Item -->
						<div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
							<div class="cart_single d-flex align-items-center">
								<div class="cart_selected_single_thumb">
									<a href="#"><img src="{{ asset('frontend/assets/img/product/4.jpg') }}" width="60" class="img-fluid"
											alt=""></a>
								</div>
								<div class="cart_single_caption ps-2">
									<h4 class="product_title fs-sm ft-medium mb-0 lh-1">Women Striped Shirt Dress</h4>
									<p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span
											class="text-dark small">Red</span></p>
									<h4 class="fs-md ft-medium mb-0 lh-1">৳129</h4>
								</div>
							</div>
							<div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button>
							</div>
						</div>

						<!-- Single Item -->
						<div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
							<div class="cart_single d-flex align-items-center">
								<div class="cart_selected_single_thumb">
									<a href="#"><img src="{{ asset('frontend/assets/img/product/7.jpg') }}" width="60" class="img-fluid"
											alt=""></a>
								</div>
								<div class="cart_single_caption ps-2">
									<h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Floral Print Jumpsuit</h4>
									<p class="mb-2"><span class="text-dark ft-medium small">36</span>, <span
											class="text-dark small">Red</span></p>
									<h4 class="fs-md ft-medium mb-0 lh-1">৳129</h4>
								</div>
							</div>
							<div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button>
							</div>
						</div>

						<!-- Single Item -->
						<div class="d-flex align-items-center justify-content-between px-3 py-3">
							<div class="cart_single d-flex align-items-center">
								<div class="cart_selected_single_thumb">
									<a href="#"><img src="{{ asset('frontend/assets/img/product/8.jpg') }}" width="60" class="img-fluid"
											alt=""></a>
								</div>
								<div class="cart_single_caption ps-2">
									<h4 class="product_title fs-sm ft-medium mb-0 lh-1">Girls Solid A-Line Dress</h4>
									<p class="mb-2"><span class="text-dark ft-medium small">30</span>, <span
											class="text-dark small">Blue</span></p>
									<h4 class="fs-md ft-medium mb-0 lh-1">৳100</h4>
								</div>
							</div>
							<div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button>
							</div>
						</div>

					</div>

					<div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
						<h6 class="mb-0">Subtotal</h6>
						<h3 class="mb-0 ft-medium" id="wishlistSubtotal">৳0.00</h3>
					</div>

					<div class="cart_action px-3 py-3">
						<div class="form-group mb-3">
							<button type="button" class="btn d-block full-width btn-dark">Move To Cart</button>
						</div>
						<div class="form-group">
							<button type="button" class="btn d-block full-width btn-dark-light">Edit or View</button>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- Cart -->
		<div class="w3-ch-sideBar w3-bar-block w3-card-2 w3-animate-right" style="display:none;right:0;" id="Cart">
			<div class="rightMenu-scroll">
				<div class="d-flex align-items-center justify-content-between slide-head py-3 px-3">
					<h4 class="cart_heading fs-md ft-medium mb-0">Products List</h4>
					<button onclick="closeCart()" class="close_slide"><i class="ti-close"></i></button>
				</div>
				<div class="right-ch-sideBar">

					<div class="cart_select_items py-2" id="cartItems">
					</div>

					<div class="d-flex align-items-center justify-content-between br-top br-bottom px-3 py-3">
						<h6 class="mb-0">Subtotal</h6>
						<h3 class="mb-0 ft-medium" id="cartSubtotal">৳0.00</h3>
					</div>

					<div class="cart_action px-3 py-3">
						<div class="form-group mb-3">
							<a href="{{ route('checkout.show') }}" class="btn d-block full-width btn-dark">Checkout Now</a>
						</div>
						<div class="form-group">
							<button type="button" class="btn d-block full-width btn-dark-light">Edit or View</button>
						</div>
					</div>

				</div>
			</div>
		</div>

		<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


	</div>
	<!-- ============================================================== -->
	<!-- End Wrapper -->
	<!-- ============================================================== -->

	<!-- ============================================================== -->
	<!-- All Jquery -->
	<!-- ============================================================== -->
	<script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/popper.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/ion.rangeSlider.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/slick.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/slider-bg.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/lightbox.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/smoothproducts.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/snackbar.min.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/jQuery.style.switcher.js') }}"></script>
	<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
	<!-- ============================================================== -->
	<!-- This page plugins -->
	<!-- ============================================================== -->

	<script>
		async function openQuickView(e, productId) {
			e && e.preventDefault();
			try {
				const resp = await fetch(`/products/${productId}/quickview`);
				if (!resp.ok) throw new Error('Failed to load product');
				const p = await resp.json();
				populateQuickView(p);
				new bootstrap.Modal(document.getElementById('quickview')).show();
			} catch (err) {
				console.error(err);
			}
		}

		function populateQuickView(p) {
			// Images
			const slides = (p.images && p.images.length ? p.images : [p.main_image])
				.map(url => `<div class="single_view_slide"><img src="${url}" class="img-fluid" alt=""></div>`)
				.join('');
			const slideWrap = document.querySelector('#quickview .quick_view_slide');
			if (slideWrap) slideWrap.innerHTML = slides;

			// Initialize/refresh slick slider for animation
			try {
				const $slider = window.jQuery ? window.jQuery('#quickview .quick_view_slide') : null;
				if ($slider && $slider.length) {
					if ($slider.hasClass('slick-initialized')) {
						$slider.slick('unslick');
					}
					$slider.slick({
						dots: true,
						arrows: true,
						infinite: true,
						speed: 400,
						autoplay: true,
						autoplaySpeed: 3000,
						slidesToShow: 1,
						slidesToScroll: 1,
						adaptiveHeight: true,
					});
				}
			} catch (e) {
				console.warn('Slick init failed', e);
			}

			// Title & pricing
			const titleEl = document.querySelector('#quickview .prt_02 h2');
			if (titleEl) titleEl.textContent = p.name;
			// store id on modal element for add-to-cart
			document.getElementById('quickview').dataset.productId = p.id;
			const priceWrap = document.querySelector('#quickview .prt_02 .elis_rty');
			if (priceWrap) {
				let html = '';
				if (p.compare_price && p.compare_price > p.price) {
					html += `<span class="ft-medium text-muted line-through fs-md me-2">৳${Number(p.compare_price).toFixed(2)}</span>`;
				}
				html += `<span class="ft-bold theme-cl fs-lg me-2">৳${Number(p.price).toFixed(2)}</span>`;
				priceWrap.innerHTML = html;
			}

			// Description
			const descEl = document.querySelector('#quickview .prt_03 p');
			if (descEl) descEl.textContent = p.description || '';

			// Variants: colors
			const colorsWrap = document.getElementById('quickviewColors');
			if (colorsWrap) {
				if (p.available_colors && p.available_colors.length) {
					colorsWrap.innerHTML = `
						<p class="d-flex align-items-center mb-0 text-dark ft-medium">Color:</p>
						<div class="text-left">
							${p.available_colors.map((c, idx) => `
							<div class="form-check form-option form-check-inline mb-1">
								<input class="form-check-input" type="radio" name="color" id="color_${idx}" value="${c}">
								<label class="form-option-label rounded-circle" for="color_${idx}"><span class="form-option-color rounded-circle" style="background:${c};"></span></label>
							</div>
							`).join('')}
						</div>
					`;
				} else {
					colorsWrap.innerHTML = '';
				}
			}

			// Variants: sizes
			const sizesWrap = document.getElementById('quickviewSizes');
			if (sizesWrap) {
				if (p.available_sizes && p.available_sizes.length) {
					sizesWrap.innerHTML = `
						<p class="d-flex align-items-center mb-0 text-dark ft-medium">Size:</p>
						<div class="text-left pb-0 pt-2">
							${p.available_sizes.map((s, idx) => `
							<div class="form-check form-option size-option form-check-inline mb-2">
								<input class="form-check-input" type="radio" name="size" id="size_${idx}" value="${s}">
								<label class="form-option-label" for="size_${idx}">${s}</label>
							</div>
							`).join('')}
						</div>
					`;
				} else {
					sizesWrap.innerHTML = '';
				}
			}
		}

		async function addToCartFromModal() {
			const modal = document.getElementById('quickview');
			const productId = modal.dataset.productId;
			const qtySelect = modal.querySelector('.prt_05 select');
			const quantity = qtySelect ? parseInt(qtySelect.value || '1') : 1;
			// Collect optional color/size from radio inputs if present
			const colorInput = modal.querySelector('input[name^="color"]:checked');
			const sizeInput = modal.querySelector('input[name="size"]:checked');
			const color = colorInput ? colorInput.value : null;
			const size = sizeInput ? sizeInput.value : null;
			try {
				const resp = await fetch(`{{ route('cart.add') }}`, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
					},
					body: JSON.stringify({
						product_id: productId,
						quantity,
						color,
						size
					})
				});
				if (!resp.ok) throw new Error('Add to cart failed');
				const data = await resp.json();
				updateCartCounter(data.count);
				if (window.Snackbar) {
					Snackbar.show({
						text: 'Added to cart',
						pos: 'bottom-center'
					});
				}
			} catch (e) {
				console.error(e);
			}
		}

		function updateCartCounter(count) {
			// header counters
			const counters = document.querySelectorAll('.lni-shopping-basket ~ .dn-counter, .lni-shopping-basket + span.dn-counter, .lni.lni-shopping-basket ~ span.dn-counter');
			counters.forEach(el => {
				el.textContent = count;
				el.classList.add('theme-bg');
			});
		}

		function openWishlist() {
			document.getElementById("Wishlist").style.display = "block";
		}

		function closeWishlist() {
			document.getElementById("Wishlist").style.display = "none";
		}
	</script>

	<script>
		async function openCart() {
			document.getElementById("Cart").style.display = "block";
			try {
				const resp = await fetch(`{{ route('cart.items') }}`);
				if (!resp.ok) throw new Error('Failed to load cart');
				const {
					items,
					subtotal
				} = await resp.json();
				renderCartItems(items);
				const subtotalEl = document.getElementById('cartSubtotal');
				if (subtotalEl) subtotalEl.textContent = `৳${Number(subtotal).toFixed(2)}`;
			} catch (e) {
				console.error(e);
			}
		}

		function renderCartItems(items) {
			const wrap = document.getElementById('cartItems');
			if (!wrap) return;
			if (!items || !items.length) {
				wrap.innerHTML = `<div class="px-3 py-4 text-center text-muted">Your cart is empty</div>`;
				return;
			}
			wrap.innerHTML = items.map(it => `
				<div class="d-flex align-items-center justify-content-between br-bottom px-3 py-3">
					<div class="cart_single d-flex align-items-center">
						<div class="cart_selected_single_thumb">
							<a href="#"><img src="${it.image}" width="60" class="img-fluid" alt=""></a>
						</div>
						<div class="cart_single_caption ps-2">
							<h4 class="product_title fs-sm ft-medium mb-0 lh-1">${it.name}</h4>
							<p class="mb-2"><span class="text-dark small">Qty: ${it.quantity}</span></p>
							<h4 class="fs-md ft-medium mb-0 lh-1">৳${(it.price * it.quantity).toFixed(2)}</h4>
						</div>
					</div>
					<div class="fls_last"><button class="close_slide gray"><i class="ti-close"></i></button></div>
				</div>
			`).join('');
		}

		function closeCart() {
			document.getElementById("Cart").style.display = "none";
		}
	</script>

	<script>
		function openSearch() {
			document.getElementById("Search").style.display = "block";
		}

		function closeSearch() {
			document.getElementById("Search").style.display = "none";
		}

		function openWhatsApp() {
			const whatsappUrl = "https://wa.link/oe6ovh";
			window.open(whatsappUrl, '_blank');
		}
	</script>


</body>

</html>
