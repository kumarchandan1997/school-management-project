@extends('stu_compo.main')
@section('main-container')

<div class="container">
<title>Games in Bangladesh</title>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>

<h2>Games</h2>

<table id="example" class="display">
    <thead>
        <tr>
            <th>SL</th>
            <th>Game Name</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i=1;
        @endphp
        @foreach ($link as $item)
        <tr>
            <td>{{ $i++ }}</td>
            <td><a href="{{ url('https://diksha.gov.in/ncert/exploren/1?id=ncert_k-12&selectedTab=textbook') }}" target="_blank"><img src="{{ asset('student/images/download.jpg') }}" alt="" width="100px" height="250px" ></a></td>
        </tr>
        @endforeach
    </tbody>
</table> 
</div>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    new DataTable('#example');
</script>

@endsection
