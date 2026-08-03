@extends('layouts.frontLayout.front-layout')
@section('content')
<main>
	<!-- <section class="stre-top-banner">
    <div class="container">
        <div class="row p-0">
            <div class="col-lg-12 p-0 text-center">
                <h3>Locations</h3>
                <hr>
            </div>
        </div>
    </div>
</section> -->

	<!-- Tabs -->
	<section id="store">
		<div class="container storeLocator">
			<h3 class="title">Store Locator</h3>
			<div class="row">
				<div class="col-xs-12 ">
					<nav>
						<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
							<a class="nav-item nav-link @if(!isset($_GET['state'])) active @endif" id="nav-ebo-tab"
								data-toggle="tab" href="#nav-ebo" role="tab" aria-controls="nav-ebo"
								aria-selected="true">EBO</a>
							<a class="nav-item nav-link @if(isset($_GET['state'])) active @endif" id="nav-mbo-tab"
								data-toggle="tab" href="#nav-mbo" role="tab" aria-controls="nav-mbo"
								aria-selected="false">MBO</a>
							<!-- <a class="nav-item nav-link" id="nav-outlet-tab" data-toggle="tab" href="#nav-outlet" role="tab" aria-controls="nav-outlet" aria-selected="false">Large Outlet</a> -->
						</div>
					</nav>
					<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">

						<div class="tab-pane fade  @if(!isset($_GET['state'])) show active @endif" id="nav-ebo"
							role="tabpanel" aria-labelledby="nav-ebo-tab">
							<div class="row">
								<!-- <div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Shop no.3 carnival complex, mall road, Ludhiana, Punjab</li>
										<li>0161-5096835</li>
									</ul>
								</div>
								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>HA- 54, phase -6 focal point, rage knitwears, Ludhiana, Punjab</li>
										<li>81465-54570, 0161-5095461</li>
									</ul>
								</div>
								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>10b, Block-b, main malhar road, Ludhiana, Punjab</li>
										<li>0161-4649908</li>
									</ul>
								</div> -->
								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Lawrance Road, Novelty Chowk, Landmark Novelty Sweet</li>
										<li>Amritsar</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Countryside Factory Outlet, Manawala, Near Delhi Public School, 143115</li>
										<li>Amritsar</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>HG Eaton Plaza, Opp 5 Star Diamond Dhaba, Handiaya Chowk, Handiaya, 148107
										</li>
										<li>Barnala</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Rage Showroom, Eaton Plaza, GT Road, Near KFC, Bughipura Chowk</li>
										<li>Moga</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Rage Knit Eastwood Village, Shop No. A-70, G.T. Road, Khajrula, 144411</li>
										<li>Jalandhar</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Shop No. 13, Ground Floor, Amayra Emporio, NH-205, Kharar Kurali Road,
											140301</li>
										<li>Kharar</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Maximus Mall, Shop No. 7, 6878 + MRX, MDR44, Chilgari, 176215</li>
										<li>Dharamshala</li>
										<li>Himachal Pradesh</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Opp Sec-3 Shopping Complex, Near Railway Track, Ishwar Road, Shanker Market,
											Channi Himmat, 180015</li>
										<li>Jammu</li>
										<li>Jammu & Kashmir</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>435-L, Gulati Chowk, Model Town, 141002</li>
										<li>Ludhiana</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Shop No. 3, Carnival Complex, Mall Road</li>
										<li>Ludhiana</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Shop No. LG-10, Ground Floor, Westend Mall, Ferozpur Road</li>
										<li>Ludhiana</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>Shop No. 05 of Unit 02, V.P.O. Heeran, Chandigarh-Ludhiana Highway, 141112
										</li>
										<li>Ludhiana</li>
										<li>Punjab</li>
									</ul>
								</div>

								<div class="col-md-4 col-12 ebo-list">
									<ul>
										<li>10-B, Block-B, Sarabha Nagar, Malhar Road</li>
										<li>Ludhiana</li>
										<li>Punjab</li>
									</ul>
								</div>

							</div>
						</div>

						<div class="tab-pane fade @if(isset($_GET['state'])) show active @endif" id="nav-mbo"
							role="tabpanel" aria-labelledby="nav-mbo-tab">
							<section class="store-locator-pg">
								<div class="container">
									<div class="row p--3tb">
										<!-- <h3>Locations</h3> -->

										<div class="col-lg-12">
											<div class="row store-list">
												<div class="col-lg-6 mb-2">
													<div class="serch-title">Select State</div>
													<select name="state" class="form-control store_select"
														onChange="window.location.href='store-locator?state=' + escape(this[selectedIndex].value)">
														<option value="">Select State</option>
														@foreach($state_list as $state)
														<option value="{{ $state['state'] }}" <?php
															if(isset($_GET['state'])){
															if($_GET['state']==$state['state']){ echo 'selected' ; }} ?>
															> {{ $state['state'] }}</option>
														@endforeach
													</select>
												</div>
												<div class="col-lg-6 mb-2">
													<div class="serch-title">Select City</div>
													<select class="form-control store_select" name="city"
														onChange="window.location.href='store-locator?state=<?php if(isset($_GET['state'])) { echo $_GET['state']; } ?>&city=' + escape(this[selectedIndex].value)">
														<option value="">Select City</option>
														@foreach($city_list as $city)
														<option value="{{ $city['city1'] }}" <?php
															if(isset($_GET['city'])) {
															if($_GET['city']==$city['city1']){ echo 'selected' ; }} ?>>
															{{ $city['city1'] }}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
									</div>
									@if(isset($_GET['city']) && ($_GET['city']!="") && isset($_GET['state']) &&
									($_GET['state']!=""))

									<div class='row p--3tb' style="margin-top: 30px">
										<div class="col-lg-5 left-addrs-bar">
											<h5 class="serch-title">
												<?php 
										if(isset($_GET['city']) && ($_GET['city']!="") && isset($_GET['state']) && ($_GET['state']!="")){
											
											if(count($store_locations) == 0){
												echo "Store Not Available ";
											}else{
												echo " Store Available :";
										}
										}
										?>

											</h5>
											<div class="addrs-container">
												@foreach($store_locations as $store_location)
												<div class="stre-adrs-wrap">
													<p>{{ $store_location['addess'] }}</p>
													<p>{{ $store_location['city1'] }}</p>
													<p class="mb-0">{{ $store_location['state'] }}</p>
												</div>
												@endforeach

											</div>
										</div>
										<div class="col-lg-7">
											<iframe
												src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54762.98128701653!2d75.81550980309885!3d30.92339063718933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a83b2d4b0d52b%3A0xf60599b5a3ef7109!2sRage!5e0!3m2!1sen!2sin!4v1660903963441!5m2!1sen!2sin"
												width="100%" height="400px"></iframe>
										</div>
									</div>

									@endif
								</div>
							</section>
						</div>

						<!-- <div class="tab-pane fade" id="nav-outlet" role="tabpanel" aria-labelledby="nav-outlet-tab">
						<div class="row">
							<div class="col-md-4 col-12 ebo-list">
								<ul>
									<li>Shop no.3 carnival complex, mall road, Ludhiana, Punjab</li>
									<li>0161-5096835</li>
								</ul>
							</div>
							<div class="col-md-4 col-12 ebo-list">
								<ul>
									<li>HA- 54, phase -6 focal point, rage knitwears, Ludhiana, Punjab</li>
									<li>81465-54570, 0161-5095461</li>
								</ul>
							</div>
							<div class="col-md-4 col-12 ebo-list">
								<ul>
									<li>10b, Block-b, main malhar road, Ludhiana, Punjab</li>
									<li>0161-4649908</li>
								</ul>
							</div>
						</div>
					</div> -->

					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- ./Tabs -->

	<!-- 
<section class="store-locator-pg">
	<div class="container">
		<div class="row p--3tb">
			 <h3>Locations</h3>
                <hr>
			<div class="col-lg-12">
				<div class="row store-list">
					<div class="col-lg-6">
						<h5 class="serch-title">Select State</h5>
						<select name="state" class="form-control store_select" onChange="window.location.href='store-locator?state=' + escape(this[selectedIndex].value)">
							<option value="">Select State</option>
								@foreach($state_list as $state)
								<option value="{{ $state['state'] }}" <?php if(isset($_GET['state'])){ if($_GET['state']==$state['state']){ echo 'selected'; }} ?> > {{ $state['state'] }}</option>
								@endforeach
						</select>
					</div>
					<div class="col-lg-6">
						<h5 class="serch-title">Select City</h5>
						<select class="form-control store_select" name="city" onChange="window.location.href='store-locator?state=<?php if(isset($_GET['state'])) { echo $_GET['state']; } ?>&city=' + escape(this[selectedIndex].value)">
							<option value="">Select City</option>
							@foreach($city_list as $city)
							<option value="{{ $city['city1'] }}" <?php if(isset($_GET['city'])) { if($_GET['city']==$city['city1']){ echo 'selected'; }} ?>> {{ $city['city1'] }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		@if(isset($_GET['city']) && ($_GET['city']!="") && isset($_GET['state']) && ($_GET['state']!=""))
				
		<div class='row p--3tb' style="margin-top: 30px">
			<div class="col-lg-5 left-addrs-bar">
				<h5 class="serch-title">
				<?php 
				if(isset($_GET['city']) && ($_GET['city']!="") && isset($_GET['state']) && ($_GET['state']!="")){
					
					if(count($store_locations) == 0){
						echo "Store Not Available ";
					}else{
						echo " Store Available :";
				}
				}
				?>
				
				</h5>
				<div class="addrs-container">
					@foreach($store_locations as $store_location)
					<div class="stre-adrs-wrap">
						<p>{{  $store_location['addess'] }}</p>
						<p>{{ $store_location['city1'] }}</p>
						<p class="mb-0">{{ $store_location['state'] }}</p>
					</div>
					@endforeach
				
				</div>
			</div>
			<div class="col-lg-7">
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54762.98128701653!2d75.81550980309885!3d30.92339063718933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a83b2d4b0d52b%3A0xf60599b5a3ef7109!2sRage!5e0!3m2!1sen!2sin!4v1660903963441!5m2!1sen!2sin" width="100%" height="400px"></iframe>
			</div>
		</div>
	
	@endif
	</div>
</section> -->
</main>

<!-- <div class="">

  <div class="block-title">
    <h3 class=""><span>STORE LOCATOR</span></h3>
  </div>
  
  

	

</div> -->
@stop
@section('javascript')
@parent

@stop