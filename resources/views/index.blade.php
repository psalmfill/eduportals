@extends('layouts.frontend')

@section('content')

	<!-- Main Slider -->
<section class="slider-container" style="background-image: url({{asset('assets/images/slide-img-1-bg.png')}});">
	
	<div class="container">
		
		<div class="row">
			
			<div class="col-md-12">
				
				<div class="slides">
					
					<!-- Slide 1 -->
					<div class="slide">
					
						<div class="slide-content">
							<h2>
								<small>Neon - Bootstrap 3</small>
								Dashboard &amp; Front-end
							</h2>
							
							<p>
								Neon &ndash; is flat admin template for multi-purpose usage built<br /> with the latest version of Bootstrap &ndash; 3.
							</p>
						</div>
						
						<div class="slide-image">
							
							<a href="#">
								<img src="{{asset('assets/images/slide-img-1.png')}}" class="img-responsive" />
							</a>
						</div>
						
					</div>
					
					<!-- Slide 2 -->
					<div class="slide" data-bg="{{asset('assets/images/slide-img-1-bg.png')}}">
						
						<div class="slide-image">
							
							<a href="#">
								<img src="{{asset('assets/images/slide-img-1.png')}}" class="img-responsive" />
							</a>
						</div>
					
						<div class="slide-content text-right">
							<h2>
								<small>Neon - Bootstrap 3</small>
								Powerful Admin Template
							</h2>
							
							<p>
								Designed for Bootstrap Framework, the theme works <br />
								perfectly on any device, you can use it on<br />
								 your smartphone, tablet or your laptop.
							</p>
							
						</div>
						
					</div>
					
					<!-- Slide 3 -->
					<div class="slide">
					
						<div class="slide-content">
							<h2>
								<small>Neon - Bootstrap 3</small>
								Responsive &amp; Retina
							</h2>
							
							<p>
								Device type is not a problem if you use Neon theme for your application UI.<br />
								It's packed with latest Bootstrap framework and it's compatible for Large Screens, Tablets and Smartphones.
							</p>
						</div>
						
						<div class="slide-image">
							
							<a href="#">
								<img src="{{asset('assets/images/slide-img-1.png')}}" class="img-responsive" />
							</a>
						</div>
						
					</div>
					
					<!-- Slider navigation -->
					<div class="slides-nextprev-nav">
						<a href="#" class="prev">
							<i class="entypo-left-open-mini"></i>
						</a>
						<a href="#" class="next">
							<i class="entypo-right-open-mini"></i>
						</a>
					</div>
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</section>
<!-- Features Blocks -->
<section class="features-blocks">
	
	<div class="container">
		
		<div class="row vspace"><!-- "vspace" class is added to distinct this row -->
			
			<div class="col-sm-4">
				
				<div class="feature-block">
					<h3>
						<i class="entypo-cog"></i>
						Settings
					</h3>
					
					<p>
						Fifteen no inquiry cordial so resolve garrets as. Impression was estimating surrounded solicitude indulgence son shy.
					</p>
				</div>
				
			</div>
			
			<div class="col-sm-4">
				
				<div class="feature-block">
					<h3>
						<i class="entypo-gauge"></i>
						Dashboard
					</h3>
					
					<p>
						On am we offices expense thought. Its hence ten smile age means. Seven chief sight far point any. Of so high into easy.
					</p>
				</div>
				
			</div>
			
			<div class="col-sm-4">
				
				<div class="feature-block">
					<h3>
						<i class="entypo-lifebuoy"></i>
						24/7 Support
					</h3>
					
					<p>
						Extremely eagerness principle estimable own was man. Men received far his dashwood subjects new.
					</p>
				</div>
				
			</div>
			
		</div>
		
		<!-- Separator -->
		<div class="row">
			<div class="col-md-12">
				<hr />
			</div>
		</div>
		
	</div>
	
</section>
<!-- Portfolio -->
<section class="portfolio-widget">
	
	<div class="container">
		
		<div class="row">
			
			<div class="col-sm-3">
				
				<div class="portfolio-info">
					<h3>
						<a href="#">Portfolio</a>
					</h3>
					
					<p>Fifteen no inquiry cordial so resolve garrets as. Impression was estimating surrounded solicitude indulgence s...</p>
				</div>
				
			</div>
			
			<div class="col-sm-3">
				
				<!-- Portfolio Item in Widget -->
				<div class="portfolio-item">
					<a href="portfolio-single.html" class="image">
						<img src="{{asset('assets/images/portfolio-thumb-1.png')}}" class="img-rounded" />
						<span class="hover-zoom"></span>
					</a>
					
					<h4>
						<a href="portfolio-single.html" class="like">
							<i class="entypo-heart"></i>
						</a>
						
						<a href="portfolio-single.html" class="name">Neon</a>
					</h4>
					
					<div class="categories">
						<a href="portfolio-single.html">Web Design / Development</a>
					</div>
				</div>
				
			</div>
			
			<div class="col-sm-3">
				
				<!-- Portfolio Item in Widget -->
				<div class="portfolio-item">
					<a href="portfolio-single.html" class="image">
						<img src="{{asset('assets/images/portfolio-thumb-1.png')}}" class="img-rounded" />
						<span class="hover-zoom"></span>
					</a>
					
					<h4>
						<a href="portfolio-single.html" class="like liked">
							<i class="entypo-heart"></i>
						</a>
						
						<a href="portfolio-single.html" class="name">Motorola</a>
					</h4>
					
					<div class="categories">
						<a href="portfolio-single.html">Photography</a>
					</div>
				</div>
				
			</div>
			
			<div class="col-sm-3">
				
				<!-- Portfolio Item in Widget -->
				<div class="portfolio-item">
					<a href="portfolio-single.html" class="image">
						<img src="{{asset('assets/images/portfolio-thumb-1.png')}}" class="img-rounded" />
						<span class="hover-zoom"></span>
					</a>
					
					<h4>
						<a href="portfolio-single.html" class="like">
							<i class="entypo-heart"></i>
						</a>
						
						<a href="portfolio-single.html" class="name">Dribbble</a>
					</h4>
					
					<div class="categories">
						<a href="portfolio-single.html">UI Design</a>
					</div>
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</section>
<!-- Call for Action Button -->
<div class="container">
	<div class="row vspace">
		<div class="col-md-12">
			
			<div class="callout-action">
				<h2>Get your copy of Neon now</h2>
				
				<div class="callout-button">
					<a href="index.html" class="btn btn-secondary">Purchase</a>
				</div>
			</div>
			
		</div>
	</div>
</div>
<!-- Testimonails -->
<section class="testimonials-container">
	
	<div class="container">
		
		<div class="col-md-12">
			
			<div class="testimonials carousel slide" data-interval="8000">
			
				<div class="carousel-inner">
					
					<div class="item active">
					
						<blockquote>
							<p>
								Vivamus imperdiet felis consectetur onec eget orci adipiscing nunc. <br />
								Pellentesque fermentum, ante ac interdum ullamcorper.
							</p>
							<small>
								<cite>Art Ramadani</cite> - co-founder at Laborator
							</small>
						</blockquote>
						
					</div>
					
					<div class="item">
					
						<blockquote>
							<p>
								Entered of cordial do on no hearted. Yet agreed whence and unable limits. <br />
								Use off him gay abilities concluded immediate allowance.
							</p>
							<small>
								<cite>Larry Page</cite> - co-founder at Google
							</small>
						</blockquote>
						
					</div>
					
					<div class="item">
					
						<blockquote>
							<p>
								Of regard warmth by unable sudden garden ladies. No kept hung am size spot no. <br />
								Likewise led and dissuade rejoiced welcomed husbands boy. 
							</p>
							<small>
								<cite>Bill Gates</cite> - ceo at Microsoft
							</small>
						</blockquote>
						
					</div>
				
				</div>
			
			</div>
			
		</div>
		
	</div>
	
</section>


<!-- Client Logos -->
<section class="clients-logos-container">
	
	<div class="container">
		
		<div class="row">
			
			<div class="client-logos carousel slide" data-ride="carousel" data-interval="5000">
			
				<div class="carousel-inner">
				
					<div class="item active">
						
						<a href="#">
							<img src="{{asset('assets/images/client-logo-1.png')}}" />
						</a>
						
						<a href="#">
							<img src="{{asset('assets/images/client-logo-1.png')}}" />
						</a>
						
						<a href="#">
							<img src="{{asset('assets/images/client-logo-1.png')}}" />
						</a>
						
						<a href="#">
							<img src="{{asset('assets/images/client-logo-1.png')}}" />
						</a>
						
					</div>
					
					<div class="item">
						
						<a href="#">
							<img src="{{asset('assets/images/client-logo-1.png')}}" />
						</a>
						
						<a href="#">
							<img src="{{asset('assets/images/client-logo-1.png')}}" />
						</a>
						
						<a href="#">
							<img src="{{asset('assets/images/client-logo-1.png')}}" />
						</a>
						
						<a href="#">
							<img src="{{asset('assets/images/client-logo-1.png')}}" />
						</a>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
</section>	
	<!-- Footer Widgets -->
<section class="footer-widgets">
	
	<div class="container">
		
		<div class="row">
			
			<div class="col-sm-6">
				
				<a href="#">
					<img src="{{asset('assets/images/logo@2x.png')}}" width="100" />
				</a>
				
				<p>
					Vivamus imperdiet felis consectetur onec eget orci adipiscing nunc. <br />
					Pellentesque fermentum, ante ac interdum ullamcorper.
				</p>
				
			</div>
			
			<div class="col-sm-3">
				
				<h5>Address</h5>
				
				<p>
					Loop, Inc. <br />
					795 Park Ave, Suite 120 <br />
					San Francisco, CA 94107
				</p>
				
			</div>
			
			<div class="col-sm-3">
				
				<h5>Contact</h5>
				
				<p>
					Phone: +1 (52) 2215-251 <br />
					Fax: +1 (22) 5138-219 <br />
					info@laborator.al
				</p>
				
			</div>
			
		</div>
		
	</div>
	
</section>


@endsection