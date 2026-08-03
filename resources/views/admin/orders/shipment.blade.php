<!DOCTYPE html>
<html>
<head>
    <title>Order ID #{{ $order['id'] }} - Shipment Details</title>
    <link rel="stylesheet" href="{{ asset('css/backend_css/bootstrap1.min.css') }}">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Order ID #{{ $order['id'] }} - Shipment Details</h4>
        </div>

        <div class="card-body">

            @if(isset($ShipmentData) && is_array($ShipmentData) && isset($ShipmentData['ShipmentData']) && isset($ShipmentData['ShipmentData']['0']))
               <?php
		             $data = $ShipmentData['ShipmentData']['0']['Shipment']; 
		       ?>
                {{-- Shipment Summary --}}
                <div class="alert alert-info"> 
                    <p><strong>Order ID:</strong> {{ $order['id'] }}</p>
                    <p><strong>Status:</strong> {{ $data['Status']['Status'] ?? 'N/A' }}</p>
                    <p><strong>Status Location:</strong> {{ $data['Status']['StatusLocation'] ?? 'N/A' }}</p>
                    <p><strong>Status Date:</strong> {{ $data['Status']['StatusDateTime'] ?? 'N/A' }}</p>
                    <p><strong>AWB:</strong> {{ $data['AWB'] ?? 'N/A' }}</p>
                    <p><strong>Order Reference:</strong> {{ $data['ReferenceNo'] ?? 'N/A' }}</p>
                    <p><strong>Order Type:</strong> {{ $data['OrderType'] ?? 'N/A' }}</p>
                    <p><strong>Invoice Amount:</strong> {{ $data['InvoiceAmount'] ?? 'N/A' }}</p>
                    <p><strong>COD Amount:</strong> {{ $data['CODAmount'] ?? 'N/A' }}</p>
                    <p><strong>Pickup Location:</strong> {{ $data['PickupLocation'] ?? 'N/A' }}</p>
                    <p><strong>Origin:</strong> {{ $data['Origin'] ?? 'N/A' }}</p>
                    <p><strong>Destination:</strong> {{ $data['Destination'] ?? 'N/A' }}</p>
                </div>
                 
                {{-- Consignee Details --}}
                <h5>Consignee</h5>
                <table class="table table-bordered"> 
                    <tr><th>Name</th><td>{{ $data['Consignee']['Name'] ?? 'N/A' }}</td></tr>
                    <tr><th>City</th><td>{{ $data['Consignee']['City'] ?? 'N/A' }}</td></tr>
                    <tr><th>State</th><td>{{ $data['Consignee']['State'] ?? 'N/A' }}</td></tr>
                    <tr><th>Country</th><td>{{ $data['Consignee']['Country'] ?? 'N/A' }}</td></tr>
                    <tr><th>Pincode</th><td>{{ $data['Consignee']['PinCode'] ?? 'N/A' }}</td></tr>
                </table>

                {{-- Scan History --}}
                <h5 class="mt-4">Tracking History</h5>

                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Scan</th>
                            <th>Scan Date</th>
                            <th>Scan Type</th>
                            <th>Status Code</th>
                            <th>Location</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['Scans'] ?? [] as $scan)
                            @php $s = $scan['ScanDetail']; @endphp
                            <tr>
                                <td>{{ $s['Scan'] ?? '-' }}</td>
                                <td>
								@if(isset($s['ScanDateTime']) && $s['ScanDateTime'] != '')
								     {{ \Carbon\Carbon::parse($s['ScanDateTime'])->format('d M Y, h:i A') }}
								@endif
								</td>
                                <td>{{ $s['ScanType'] ?? '-' }}</td>
                                <td>{{ $s['StatusCode'] ?? '-' }}</td>
                                <td>{{ $s['ScannedLocation'] ?? '-' }}</td>
                                <td>{{ $s['Instructions'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @else
                <div class="alert alert-danger">
                    Invalid or empty shipment response.
                </div>
            @endif

        </div>
    </div>

</div>

</body>
</html>
