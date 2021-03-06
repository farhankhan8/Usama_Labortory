@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                <div class="container-fluid">
        <div class="row mt-2 widgets">
            <div  class="col-xl-3 col-sm-6 py-2">
                    <div class="card card-1 text-white h-100">
                        <div style="background-color:rgb(0,200,255);" class="card-body card-1">
                            <div class="rotate">
                            <i class="fa fa-hospital-o" style="font-size:36px;"></i>
                            </div>
                            <h5 class="mb-5">Today Verified Tests</h5>
                            <h3 class="amount-position"> {{ $today }}</h3>

                            
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
                    <div class="card card-1 text-white h-100">
                        <div style="background-color:rgb(50,150,255);" class="card-body card-1">
                            <div class="rotate">
                            <i class="fa fa-user-md" style="font-size:36px;"></i>
                            </div>
                            <h5 class="mb-5">Weekly  Verified Tests</h5>
                            <h3 class="amount-position"> {{ $thisWeekPatient }}</h3>


                            
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-sm-6 py-2">
                    <div class="card card-1 text-white h-100">
                        <div  style="background-color:rgb(200,150,255);" class="card-body card-1">
                            <div class="rotate">
                            <i class="fa fa-stethoscope" style="font-size:36px;"></i>
                            </div>
                            <h5 class="mb-5">Monthly Varified Tests </h5>
                            <h3 class="amount-position"> {{ $thisMongthPatient }}</h3>


                      
                            
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-3 col-sm-6 py-2">

                    <div class="card card-1 text-white h-100">
                        <div  style="background-color:rgb(200,50,90);;" class="card-body card-1">
                        
                            <div class="rotate">
                            <i class="fa fa-wheelchair" style="font-size:48px;color:red"></i>
                            </div>

                            <h5 class="mb-5">Critical Test Today</h5>

                            <h3>{{ count($criticalTestToday) }}</h3>
                        </div>
                    </div>
                </a>
            </div>

   
    </div>



            
    <style>
* {
  box-sizing: border-box;
}
.row {
  margin-left:-5px;
  margin-right:-5px;
}
  
.column {
  float: left;
  width: 50%;
  padding: 5px;
}
/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}
th, td {
  text-align: left;
  padding: 16px;
}
tr:nth-child(even) {
  /* background-color: gray; */
}
</style>
</head>
<body>
 

<!-- <p>How to create side-by-side tables with CSS:</p> -->

<div class="row">
  <div class="column">
  <span style="text-align: left;"><h2>All Tests Performed </h2></span>  

    <table class="table table-striped">
      <tr>
        <th>Test Name</th>
        <th>Category</th>
        <th>Patient Name</th>
        <th>Status</th>

      </tr>
      @foreach($testPerformeds as $key => $testPerformed)

      <tr>
        <td>{{ $testPerformed->Cname ?? '' }}</td>
        <td>{{ $testPerformed->name ?? '' }}</td>
        <td>{{ $testPerformed->Pname  ?? '' }}</td>
        <td>
                            @if ($testPerformed->Sname =='Progressing')
                            <button class="btn btn-xs btn-info">{{ $testPerformed->Sname ?? '' }}</button>
                               @elseif ($testPerformed->Sname =='Verified')
                               <button class="btn btn-xs btn-primary">{{ $testPerformed->Sname ?? '' }}</button>
                          
                               @elseif ($testPerformed->Sname =='Not Received')
                               <button class="btn btn-xs  btn-warning">{{ $testPerformed->Sname ?? '' }}</button>
                               @elseif ($testPerformed->Sname =='Cancelled')
                               <button class="btn btn-xs btn-danger">{{ $testPerformed->Sname ?? '' }}</button>
                             @else
                             I don't have any records!
                                 @endif
                            </td>
      </tr>
     @endforeach
    </table>
  </div>
  
  <div class="column">

    <table class="table table-striped" >
    <span style="text-align: center;"><h2>Category Wise Tests Today </h2></span>  

      <tr>
        <th>Category Name</th>
        <th>No Of Tests</th>
      </tr>
      @foreach($distincrCatagory as $key => $distincrCatagor)

      <tr>
      <td>{{ $distincrCatagor->Cname }}</td>
      <td>{{ $distincrCatagory2 }}</td>
      </tr>
      @endforeach

    </table>
  </div>
</div>      



<div class="row">
  <div class="column">
  <span style="text-align: left;"><h2>Critical Tests Today </h2></span>  

    <table class="table table-striped">
      <tr>
        <th>Test Name</th>
        <th>Patient Name</th>

        <th>Phone Number</th>
        <th>Date</th>

      </tr>
      @foreach($criticalTestToday as $key => $criticalTestToda)

      <tr>
        <td>{{ $criticalTestToda->name ?? '' }}</td>
        <td>{{ $criticalTestToda->Pname  ?? '' }}</td>
        <td>{{ $criticalTestToda->phone  ?? '' }}</td>
        <td>{{ $criticalTestToda->start_time  ?? '' }}</td>



      </tr>
     @endforeach
    </table>
  </div>
  
  <div class="column">

    <table class="table table-striped" >
    <span style="text-align: center;"><h2>Delayed Tests Today</h2></span>  

      <tr>
      <th>Test Name</th>
        <th>Patient Name</th>
        <th>Date</th>

        <th>Status</th>
        <th>Action</th>
      </tr>
      @foreach($todayDelayeds as $key => $todayDelayed)

      <tr>
      <td>{{ $todayDelayed->availableTest->name ?? '' }}</td>
        <td>{{ $todayDelayed->patient->Pname  ?? '' }}</td>
        <td>{{ $todayDelayed->patient->start_time  ?? '' }}</td>
        <td>
                            <button class="btn btn-xs btn-info">Progressing</button>
        </td>
        <td>
                                    <a class="btn btn-xs btn-info" href="{{ route('test-performed-edit', $todayDelayed->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                
                                    <form  method="POST" action="{{ route("performed-test-delete", [$todayDelayed->id]) }}" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"  style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
        </td>


      </tr>
      @endforeach

    </table>
  </div>
</div>      
          </div>
            </div>
        </div>
    </div>
</div>















          </div>
            </div>
        </div>
    </div>
</div>


@endsection
@section('scripts')
@parent

@endsection