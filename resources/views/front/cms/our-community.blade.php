@extends('layouts.frontLayout.front-layout')
@section('content')
<div class="container inner-pages">
	<div class="row">
		<div class="offset-md-2 col-md-8 col-12 our-community text-center mt-3">
			<img src="{{asset('images/miarcus-logo.png')}}" class="img-fluid comm-logo" alt="" title="" />
			<h4 class="mt-3">Welcome to our Family!</h4>

			<p>We believe in making motherhood a joyful by sharing knowledge and experiences. We strive to invest our time and knowledge significantly in connecting experienced mothers and help make motherhood experience a memorable one.  </p>
		</div>
	</div>
</div>
<div class="container-fluid purple-background mt-4">
	<div class="row">
		<div class="container community-btm">
			<div class="row">
				<div class="col-12 pt-3 text-center">
					<p class="white">Here’s a glimpse of our Community Expert Panel:</p>
				</div>
				<div class="col-sm col-12 text-center">
                    <img border='0' src="{{ asset('images/email-imgs/neha-dhupia.png') }}"  class="img-fluid" alt='' />
                    <h3>Neha Dhupia</h3>
                    <p>Mom Wizard</p>
                </div>
                <div class="col-sm col-12 text-center">
                    <img border='0' src="{{ asset('images/email-imgs/aditi-govitrikar.png') }}" class="img-fluid" alt='' />
                    <h3>Dr. Aditi Govitrikar</h3>
                    <p>Wellness Expert</p>
                </div>
                <div class="col-sm col-12 text-center">
                    <img border='0' src="{{ asset('images/email-imgs/nitika-sobti.png') }}" class="img-fluid" alt='' />
                    <h3>Dr. Nitika Sobti</h3>
                    <p>Gynaecologist &amp; Obstetrician</p>
                </div>
		        <div class="col-sm col-12 text-center">
                    <img border='0' src="{{ asset('images/email-imgs/shubhda-bhanot.png') }}" class="img-fluid" alt='' />
                    <h3>Shubhda Bhanot</h3>
                    <p>Diabetes Educator &amp; Nutritionist</p>
                </div>
		        <div class="col-sm col-12 text-center">
                    <img border='0' src="{{ asset('images/email-imgs/simi-hanspal.png') }}" class="img-fluid" alt='' />
                    <h3>Simi Hanspal</h3>
                    <p>Counsellor</p>
                </div>
                <div class="col-sm col-12 text-center">
                    <img border='0' src="{{ asset('images/email-imgs/sucheta-pal.png') }}" class="img-fluid" alt='' />
                    <h3>Sucheta Pal</h3>
                    <p>Fitness Expert</p>
				</div>
			</div>
		</div>
	</div>
</div>
@stop