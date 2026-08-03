@extends('layouts.frontLayout.front-layout')

@section('content')
<main>

	<div class="container mainBanner lookbook-banner" data-aos="fade-left">
		<div class="row">
            <video class="responsive video-autoplay" autoplay loop muted playsinline>
				<source src="img/lookbook/lookbook.mp4" type="video/mp4">
			</video>
			<div class="video-text">
				<p>New Season, New You</p>
				<h4>Jenniffer Piccinato</h4>
			</div>
		</div>
	</div>

  <!-- Title -->
  <div class="collection-header">
	<h3>Lookbook</h3>
  </div>

  <!-- Lookbook Grid -->
  <section class="lookbook" data-aos="fade-left">
	<div class="container">
		<div class="row">
           <div class="col-md-4 col-6" data-aos="fade-left">
				<div class="look">
					<img src="{{ asset('/') }}img/lookbook/ba1.jpg">
					<p>Katrina Kaif</p>
				</div>
		   </div>

		    <div class="col-md-4 col-6 mt-md-5" data-aos="fade-up">
				<div class="look">
					<img src="{{ asset('/') }}img/lookbook/ba2.jpg">
					<p>Jacqueline Fernandez</p>
				</div>
		   </div>

		    <div class="col-md-4 col-6" data-aos="fade-right">
				<div class="look">
					<img src="{{ asset('/') }}img/lookbook/ba3.jpg">
					<p>Urvashi Sharma</p>
				</div>
		   </div>

		    <div class="col-md-4 col-6" data-aos="fade-right">
				<div class="look">
					<img src="{{ asset('/') }}img/lookbook/ba6.jpg">
					<p>Sameera Reddy</p>
				</div>
		   </div>

		    <div class="col-md-4 col-6 mt-md-5" data-aos="fade-down">
				<div class="look">
					<img src="{{ asset('/') }}img/lookbook/ba4.jpg">
					<p>Amyra Dastur</p>
				</div>
		   </div>

		    <div class="col-md-4 col-6" data-aos="fade-left">
				<div class="look">
					<img src="{{ asset('/') }}img/lookbook/ba5.jpg">
					<p>Giselle Monterio</p>
				</div>
		   </div>
		
		</div>
	</div>
  </section>


</main>
@stop

@section('javascript')

@parent



@stop