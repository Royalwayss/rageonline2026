<style>
.analytics-box { height: 74px !important; min-height: 0 !important; padding: 6px 10px !important; margin-bottom: 6px !important; }
.analytics-box .number h3 { font-size: 26px !important; margin: 0 !important; line-height: 30px !important; }
.analytics-box .number small { font-size: 12px !important; line-height: 14px; }
.analytics-box .display { padding: 0 !important; }
</style>
<div class="row" style="margin:10px">
	<div class="dashboard-stat2 analytics-box">
		<div class="display">
			<div class="number">
				<h3 class="font-purple-soft">{{ number_format($section_data['total_sales'],2) }}</h3>
				<small>Sales</small>
			</div>
		</div>
	</div>
	<div class="dashboard-stat2 analytics-box">
		<div class="display">
			<div class="number">
				<h3 class="font-purple-soft">{{ $section_data['total_users'] }}</h3>
				<small>Users</small>
			</div>
		</div>
	</div>
	<div class="dashboard-stat2 analytics-box">
		<div class="display">
			<div class="number">
				<h3 class="font-purple-soft">{{ number_format($section_data['prepaid']['total_sales'],2) }}</h3>
				<small>PREPAID SALES</small>
				<small style="display:block;text-transform:none;">{{ $section_data['prepaid']['total_orders'] }} orders | {{ $section_data['prepaid']['total_items'] }} items</small>
			</div>
		</div>
	</div>
	<div class="dashboard-stat2 analytics-box">
		<div class="display">
			<div class="number">
				<h3 class="font-purple-soft">{{ number_format($section_data['cod']['total_sales'],2) }}</h3>
				<small>COD SALES</small>
				<small style="display:block;text-transform:none;">{{ $section_data['cod']['total_orders'] }} orders | {{ $section_data['cod']['total_items'] }} items</small>
			</div>
		</div>
	</div>
	<div class="dashboard-stat2 analytics-box">
		<div class="display">
			<div class="number">
				<h3 class="font-purple-soft">{{ $section_data['total_return_requests'] }}</h3>
				<small>EXCHANGE/RETURN</small>
			</div>
		</div>
	</div>
	<div class="dashboard-stat2 analytics-box">
		<div class="display">
			<div class="number">
				<h3 class="font-purple-soft">{{ $section_data['total_notify'] }}</h3>
				<small>Notify</small>
			</div>
		</div>
	</div>
</div>