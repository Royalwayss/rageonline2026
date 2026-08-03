<!-- Stock Logs Table -->
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Action</th>
              <th>Quantity</th>
              <th>Stock Remaining</th>
              <th>Updated By</th>
              <th>Time</th>
            </tr>
          </thead>
          <tbody>
            <!-- Sample Data, Replace with Dynamic Data from Laravel -->
            
			@foreach($logs as $key=>$log)
			<tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $log['message'] }}</td>
              <td>
			  
			 
			  
			  <span 
				class="btn {{ $log['qty'] < 1 ? 'qty-red' : ($log['qty'] > 1 ? 'qty-green' : 'qty-green') }}">
					   {{ $log['qty'] }}
			 </span>
			  
			  
			  </td>
              <td>{{ $log['stock_remaining'] }}</td>
              <td>
			  
			  @if($log['action'] == 1)
				  admin
			  @elseif($log['action'] == 2)
			      new order # <a target="_blank" href="{{ url('admin/order-view/'.$log['order_id']) }}">{{ $log['order_id'] }}</a>
		      @endif
			  
			  
			  </td>
              <td>{{ date('d M Y h:i a',strtotime($log['created_at'])) }}</td>
            </tr>
            @endforeach
          
          </tbody>
        </table>
      