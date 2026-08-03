@extends('layouts.adminLayout.backendLayout')
@section('content')
<link rel="stylesheet" href="{{ asset('css/backend_css/dashboard.css') }}?v=2.5" />
<style>
</style>
<?php
	$months = months();
	$years = years();
	
	if(Session::has('top_sale')){
		$filter['analytics']['from_date'] = @Session::get('analytics')['from_date'];
		$filter['analytics']['to_date'] =  @Session::get('analytics')['to_date'];
	}else{
		$filter['analytics']['from_date'] =date('Y-m-d');
		$filter['analytics']['to_date'] = date('Y-m-d');
	}
	
	if(Session::has('day_wise_sale')){
		$filter['day_wise_sale']['month'] = Session::get('day_wise_sale')['month'];
		$filter['day_wise_sale']['year'] = Session::get('day_wise_sale')['year'];
		$filter['day_wise_sale']['payment_method'] = Session::get('day_wise_sale')['payment_method'];
		$filter['day_wise_sale']['chart_type'] = Session::get('day_wise_sale')['chart_type'];
	}else{
		$filter['day_wise_sale']['month'] = date('m');
		$filter['day_wise_sale']['year'] = date('Y');
		$filter['day_wise_sale']['payment_method'] = '';
		$filter['day_wise_sale']['chart_type'] = 'bar';
	}

	if(Session::has('month_wise_sale')){
		$filter['month_wise_sale']['year'] = Session::get('month_wise_sale')['year'];
		$filter['month_wise_sale']['payment_method'] = Session::get('month_wise_sale')['payment_method'];
		$filter['month_wise_sale']['chart_type'] = Session::get('month_wise_sale')['chart_type'];
	}else{
		$filter['month_wise_sale']['year'] = date('Y');
		$filter['month_wise_sale']['payment_method'] = '';
		$filter['month_wise_sale']['chart_type'] = 'bar';
	}

	if(Session::has('year_wise_sale')){
		$filter['year_wise_sale']['payment_method'] = Session::get('year_wise_sale')['payment_method'];
		$filter['year_wise_sale']['chart_type'] = Session::get('year_wise_sale')['chart_type'];
	}else{
		$filter['year_wise_sale']['payment_method'] = date('Y');
		$filter['year_wise_sale']['chart_type'] = 'bar';
	}

	if(Session::has('top_sale')){
		$filter['top_sale']['from_date'] = Session::get('top_sale')['from_date'];
		$filter['top_sale']['to_date'] = Session::get('top_sale')['to_date'];
	}else{
		$filter['top_sale']['from_date'] = date('Y').'-01-01';
		$filter['top_sale']['to_date'] = date('Y-m-d');
	}

	if(Session::has('top_sale_category_wise')){
		$filter['top_sale_category_wise']['from_date'] = Session::get('top_sale_category_wise')['from_date'];
		$filter['top_sale_category_wise']['to_date'] = Session::get('top_sale_category_wise')['to_date'];
	}else{
		$filter['top_sale_category_wise']['from_date'] = date('Y').'-01-01';
		$filter['top_sale_category_wise']['to_date'] = date('Y-m-d');
	}
	
	$chart_types = chart_types();
	$payment_methods = ['all'=>'All','cod'=>'COD','online'=>'Online'];
?>
<div class="page-content-wrapper">
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Dashboard</h1>
         </div>
      </div>
      @if(Session::has('flash_message_error'))
      <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
      @endif
      <div class="">
         <div class="col-md-12">
            <div class="portlet blue-hoki box">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-bar-chart	"></i>Sales Analytics
                  </div>
               </div>
               <div class="portlet-body" style="background:#e9ecf3">
                  <div class="row margin-top-12" id="dashboard-analytics">
                     <div class="col-lg-6">
                        <div class="report-box">
                           <?php $section = 'analytics'; ;?>
                           <div class="dashboard-analytics {{ $section }} loading-icon-padding ">
                              <div class="row">
                                 <form action="javascript:;" id="{{ $section }}-form" data-form="{{ $section }}" class="filter-form">
                                    @csrf
                                    <input type="hidden" name="section" value="{{ $section }}">
                                    <div class="col-lg-4" >
                                       <input type="date" id="from_date" name="from_date" value="{{ $filter[$section]['from_date'] }}" required title="Select From Date">
                                    </div>
                                    <div class="col-lg-4">
                                       <input type="date"  id="to_date" name="to_date" value="{{ $filter[$section]['to_date'] }}" required title="Select To Date"> 
                                    </div>
                                    <div class="col-lg-3 mt-2">
                                       <input type="submit" >
                                    </div>
                                 </form>
                              </div>
                              <div  id="{{ $section }}-report">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="report-box">
                           <?php $section = 'day_wise_sale'; ;?>
                           <div class="dashboard-analytics {{ $section }} loading-icon-padding ">
                              <div class="row">
                                 <form action="javascript:;" id="{{ $section }}-form" data-form="{{ $section }}" class="filter-form">
                                    @csrf
                                    <input type="hidden" name="section" value="{{ $section }}">
                                    <div class="row" style="margin:5px">
                                       <div class="col-lg-2">
                                          <select  name="month" required title="Select Month">
                                             <option value="" disabled >Month</option>
                                             @foreach($months as $month_no=>$month)
                                             <option value="{{ $month_no }}" @if($filter[$section]['month'] == $month_no) selected @endif >{{ $month }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                       <div class="col-lg-2">
                                          <select  name="year" required title="Select Year" >
                                             <option value="" >Year</option>
                                             @foreach($years as $year)
                                             <option value="{{ $year }}" @if($filter[$section]['year'] == $year) selected @endif>{{ $year }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                       <div class="col-lg-2">
                                          <select  name="payment_method" title="Select Payment" >
                                             <option value="" >Payment</option>
                                             @foreach($payment_methods as $payment_key => $payment_method)
                                             <option value="{{ $payment_key }}" @if($filter[$section]['payment_method'] ==$payment_key) selected @endif >{{ $payment_method }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                       <div class="col-lg-2">
                                          <select  name="chart_type" required title="Select Chart Type" >
                                             <option value="" >Chart</option>
                                             @foreach($chart_types as $chart_key => $chart_type)
                                             <option value="{{ $chart_key }}" @if($filter[$section]['chart_type'] == $chart_key) selected @endif>{{ $chart_type }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                       <div class="col-lg-2 ">
                                          <input type="submit" class="" >
                                       </div>
                                    </div>
                                 </form>
                              </div>
                              <div  id="{{ $section }}-report">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="report-box">
                           <?php $section = 'month_wise_sale'; ;?>
                           <div class="dashboard-analytics {{ $section }} loading-icon-padding ">
                              <div class="row">
                                 <form action="javascript:;" id="{{ $section }}-form" data-form="{{ $section }}" class="filter-form">
                                    @csrf
                                    <input type="hidden" name="section" value="{{ $section }}">
                                    <div class="col-lg-3">
                                       <select name="year" required title="Select Year">
                                          <option value="" >Year</option>
                                          @foreach($years as $year)
                                          <option value="{{ $year }}" @if($filter[$section]['year'] == $year) selected @endif>{{ $year }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-3">
                                       <select  name="payment_method" title="Select Payment" >
                                          <option value="" >Payment</option>
                                          @foreach($payment_methods as $payment_key => $payment_method)
                                          <option value="{{ $payment_key }}" @if($filter[$section]['payment_method'] ==$payment_key) selected @endif >{{ $payment_method }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-3">
                                       <select  name="chart_type" required title="Select Chart Type">
                                          <option value="" >Chart</option>
                                          @foreach($chart_types as $chart_key => $chart_type)
                                          <option value="{{ $chart_key }}" @if($filter[$section]['chart_type'] == $chart_key) selected @endif>{{ $chart_type }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-3">
                                       <input type="submit" class="" >
                                    </div>
                                 </form>
                              </div>
                              <div  id="{{ $section }}-report">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="report-box">
                           <?php 
                              $section = 'year_wise_sale';
                              
                              ?>
                           <div class="dashboard-analytics {{ $section }} loading-icon-padding ">
                              <div class="row">
                                 <form action="javascript:;" id="{{ $section }}-form" data-form="{{ $section }}" class="filter-form">
                                    @csrf
                                    <input type="hidden" name="section" value="{{ $section }}">
                                    <div class="col-lg-3">
                                       <select name="payment_method" title="Select Payment" >
                                          <option value="" >Payment Method</option>
                                          @foreach($payment_methods as $payment_key => $payment_method)
                                          <option value="{{ $payment_key }}" @if($filter[$section]['payment_method'] ==$payment_key) selected @endif >{{ $payment_method }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-3">
                                       <select  name="chart_type" required title="Select Chart Type">
                                          <option value="" >Chart</option>
                                          @foreach($chart_types as $chart_key => $chart_type)
                                          <option value="{{ $chart_key }}" @if($filter[$section]['chart_type'] == $chart_key) selected @endif>{{ $chart_type }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                    <div class="col-lg-3">
                                       <input type="submit" >
                                    </div>
                                 </form>
                              </div>
                              <div  id="{{ $section }}-report">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="report-box">
                           <?php $section = 'top_sale'; ;?>
                           <div class="dashboard-analytics {{ $section }} loading-icon-padding ">
                              <div class="row">
                                 <form action="javascript:;" id="{{ $section }}-form" data-form="{{ $section }}" class="filter-form">
                                    @csrf
                                    <input type="hidden" name="section" value="{{ $section }}">
                                    <div class="col-lg-4" >
                                       <input type="date" id="from_date" name="from_date" value="{{ $filter[$section]['from_date'] }}" required title="Select From Date">
                                    </div>
                                    <div class="col-lg-4">
                                       <input type="date"  id="to_date" name="to_date" value="{{ $filter[$section]['to_date'] }}" required title="Select To Date"> 
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                       <input type="submit" >
                                    </div>
                                 </form>
                              </div>
                              <div  id="{{ $section }}-report">
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="report-box">
                           <?php $section = 'top_sale_category_wise'; ;?>
                           <div class="dashboard-analytics {{ $section }} loading-icon-padding ">
                              <div class="row">
                                 <form action="javascript:;" id="{{ $section }}-form" data-form="{{ $section }}" class="filter-form">
                                    @csrf
                                    <input type="hidden" name="section" value="{{ $section }}">
                                    <div class="col-lg-4" >
                                       <input type="date" id="from_date" name="from_date" value="{{ $filter[$section]['from_date'] }}" required title="Select From Date">
                                    </div>
                                    <div class="col-lg-4">
                                       <input type="date"  id="to_date" name="to_date" value="{{ $filter[$section]['to_date'] }}" required title="Select To Date"> 
                                    </div>
                                    <div class="col-lg-4 mt-2">
                                       <input type="submit" >
                                    </div>
                                 </form>
                              </div>
                              <div  id="{{ $section }}-report">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
	  <div class="">
         <div class="col-md-12">
            <div class="portlet blue-hoki box">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-bar-chart	"></i>Dashboard Analytics
                  </div>
               </div>
               <div class="portlet-body" style="background:#e9ecf3">
                   <div class="row margin-top-10">
					 @foreach($getModules as $key => $module)
					 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
						<div class="dashboard-stat2">
						   <div class="display">
							  <div class="number">
								 <h3 class="font-purple-soft">{!!$module['table_count']!!}</h3>
								 <small>{{$module['name']}}</small>
							  </div>
							  <div class="icon">
								 <i class="{{$module['icon']}}"></i>
							  </div>
						   </div>
						   <div class="progress-info">
							  <div class="status">
								 <div class="status-title">
									<a href="{{url($module['view_route'])}}">View More Details</a>
								 </div>
							  </div>
						   </div>
						</div>
					 </div>
					 @endforeach
                   </div>
			   </div>
            </div>
         </div>
      </div>
     
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0"></script>
<script>
   $( document ).ready(function() {
        load_dashboard_report('analytics');
        load_dashboard_report('day_wise_sale');
        load_dashboard_report('month_wise_sale');
        load_dashboard_report('year_wise_sale');
        load_dashboard_report('top_sale');
        load_dashboard_report('top_sale_category_wise');
     
     
      $(document).on("submit", ".filter-form", function(e){ 
           var section =  $(this).attr('data-form');
   		load_dashboard_report(section);
      });
     
      });
   
   
   function load_dashboard_report(section){ 
   	
   	var loading_icon = '<span class="loading-box-icon" role="status" aria-hidden="true"><span class="center spinner-border spinner-border-sm"></span></span>';
   	$('#'+section+'-report').html(loading_icon);
   	
   	$.ajax({
   			type: "post",
   			url: "{{ url('admin/dashboard-reports') }}",  
   			dataType: 'JSON',
   			data:$('#'+section+'-form').serialize(),
   			success: function(response) {
   				if(response.status){ 
   					var report = response.report;
   					var section = response.section;
   					$('#'+section+'-report').html(response.html);
   					
   					if(section == 'day_wise_sale'){ 
   						   DayWiseSale(response.section_data);
   					}
   					if(section == 'month_wise_sale'){ 
   						   MonthWiseSale(response.section_data);
   					}
   					if(section == 'year_wise_sale'){ 
   						   YearWiseSale(response.section_data);
   					}
   					
   					if(section == 'top_sale'){ 
   						   
   					}
   					
   					if(section == 'analytics'){ 
   						   
   					}
   				}	
   			},
   			error: function (xhr, ajaxOptions, thrownError) {
   				$('#'+section+'-report').html('');
   			}					
   						
   	});
   	
   	
   }
   
   
   
   function DayWiseSale(report_data){ 
   	const xValues = report_data.sale_dates;
   	const yValues = report_data.sale_amount;
   	let barColors = "#f28e2b";
   	const ctx = document.getElementById('DayWiseSale');
   	new Chart(ctx, {
   		type: report_data.chart_type,
   			data: {
   			labels: xValues,
   			datasets: [{
   				backgroundColor: barColors,
   				data: yValues
   			}]
   		},
   		options: {
   			plugins: {
   				legend: { display: false },
   				title: {
   					display: true,
   					text: report_data.title,
   					font: { size: 16 }
   				}
   			},
   			scales: {
   				yAxes: [{
   				ticks: {
   					beginAtZero: true
   				}
   				}]
   			},
   		}
   	});
   }
   
   
   function MonthWiseSale(report_data){
   	const xValues = report_data.sale_dates;
   	const yValues = report_data.sale_amount;
   	let barColors = "#e15759";
   	const ctx = document.getElementById('MonthWiseSale');
   	new Chart(ctx, {
   		type: report_data.chart_type,
   			data: {
   			labels: xValues,
   			datasets: [{
   				backgroundColor: barColors,
   				data: yValues
   			}]
   		},
   		options: {
   			plugins: {
   				legend: { display: false },
   				title: {
   					display: true,
   					text: report_data.title,
   					font: { size: 16 }
   				}
   			},
   			scales: {
   				yAxes: [{
   				ticks: {
   					beginAtZero: true
   				}
   				}]
   			},
   		}
   	});
   }
   
      function YearWiseSale(report_data){
   	const xValues = report_data.sale_dates;
   	const yValues = report_data.sale_amount;
   	let barColors = "#76b7b2";
	
   	const ctx = document.getElementById('YearWiseSale');
   	new Chart(ctx, {
   		type: report_data.chart_type,
   			data: {
   			labels: xValues,
   			datasets: [{
   				backgroundColor: barColors,
   				data: yValues
   			}]
   		},
   		options: {
			
   			plugins: {
   				legend: { display: false },
   				title: {
   					display: true,
   					text: report_data.title,
   					font: { size: 16 }
   				}
   			},
   			scales: {
   				yAxes: [{
   				ticks: {
   					beginAtZero: true
   				}
   				}]
   			},
   		}
   	});
   }
   
</script>
<script>
   const  today = new Date();
   const year = today.getFullYear();
   const month = String(today.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
   const day = String(today.getDate()).padStart(2, '0');
   
   const maxDate = `${year}-${month}-${day}`; // Format: YYYY-MM-DD
   
   $('#from_date').attr('max', maxDate);
   $('#to_date').attr('max', maxDate);
   
</script>
@endsection