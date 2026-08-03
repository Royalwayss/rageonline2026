@extends('layouts.frontLayout.front-layout')
@section('content')
<br>
<br>
<br>
<br>
<br>

<div class="container mt-4">   <div class="row">    
    		<div class="col-12 policy-padding">   
    		
			<h4  class="purple"><?php echo $details->title; ?></h4> 	
			<p>
<?php echo $details->description; ?>
			</div>      	</div> </div>

@stop
