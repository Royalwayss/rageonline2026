<div class="page-footer">
	<div class="page-footer-inner">
		<?php echo date('Y');?> &copy;  {{config('constants.project_name')}}
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<script src="{!! asset('js/backend_js/admin-script.js?v='.\Illuminate\Support\Str::random(4)) !!}" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
   	Metronic.init(); // init metronic core componets
   	Layout.init(); // init layout
   	Demo.init(); // init demo features 
 	Tasks.initDashboardWidget(); // init tash dashboard widget  
});
</script>