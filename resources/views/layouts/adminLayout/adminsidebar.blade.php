<!-- 1,2,3,4 -->
<?php use App\Module;
$getallModules =  Module::getModules(); ?>
<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<?php if(Session::get('active')==1){?>
	            <li class="start active ">
	            <?php }else{ ?> 
	            <li>
	            <?php } ?>
					<a href="{{ url('admin/dashboard') }}">
					<i class="icon-home"></i>
					<span class="title">Dashboard</span>
					</a>
				</li>
		<?php foreach($getallModules as $module) { ?>
			<li <?php if(Session::get('active')== $module['session_value'] ) { ?> class="start active"<?php } ?> >
				<a href="{{ url($module['view_route'])}}">
					<i class="{{ $module['icon']}}"></i>
					<span class="title">{{ $module['name'] }}</span>
				</a>
			</li>
		<?php } ?>
		</ul>
	</div>
</div>