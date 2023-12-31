@extends('layouts.master')

@section('title')
  قائمة الفواتير
@stop
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">قائمة الفواتير</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">


					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">


                        <!--/div-->

                        <!--div-->

                        <!--/div-->

                        <!--div-->
                        <div class="col-xl-12">
                            <div class="card mg-b-20">
                                <div class="card-header pb-0">
                                    <div class="d-flex justify-content-between">

                                        <a href="{{ route('invoices.create') }}" class="modal-effect btn btn-sm btn-primary" style="color:white"
                                        class="fas fa-plus"></i>&nbsp; + اضافة فاتورة</a>
                                           اضافة فاتورة
                                    </a>
                                    </div>
                                        </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>


                                            <thead>



                                                <tr>
                                                    <th class="border-bottom-0">#</th>
                                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                    <th class="border-bottom-0">القسم</th>
                                                    <th class="border-bottom-0">المنتج</th>
                                                    <th class="border-bottom-0">الخصم</th>
                                                    <th class="border-bottom-0">نسبة الضريبة</th>
                                                    <th class="border-bottom-0">قيمة الضريبة</th>
                                                    <th class="border-bottom-0"> الاجمالي</th>
                                                    <th class="border-bottom-0">الحالة </th>
                                                    <th class="border-bottom-0">ملاحظات </th>
                                                    <th class="border-bottom-0">العمليات </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach (  $invoices as $invoice )
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $invoice->invoice_number }}</td>
                                                    <td>{{$invoice->invoice_Date  }}</td>
                                                    <td>{{$invoice->Due_date  }}</td>
                                                    <td><a
                                                        href="{{ route('InvoicesDetails',$invoice->id) }}">{{ $invoice->section->section_name }}</a>
                                                </td>
                                                    <td>{{ $invoice->product }}</td>

                                                    <td>{{ $invoice->Discount }}</td>
                                                    <td>{{ $invoice->Rate_VAT }}</td>
                                                    <td>{{ $invoice->Value_VAT }}</td>
                                                    <td>{{ $invoice->Total }}</td>
                                                    <td>
                                                         @if ($invoice->Value_Status == 1)
                                                    <span class="text-success">{{ $invoice->Status }}</span>
                                                @elseif($invoice->Value_Status == 2)
                                                    <span class="text-danger">{{ $invoice->Status }}</span>
                                                @else
                                                    <span class="text-warning">{{ $invoice->Status }}</span>
                                                @endif
                                                    </td>
                                                    <td>{{ $invoice->note }}</td>
                                                    <td>


                                                        <a href="{{ route('edit' ,$invoice->id) }}" >تعديل
                                                            الفاتورة</a><br>

                                                            <a href="{{ route('delete' ,$invoice->id) }}" >حذف
                                                                الفاتورة</a><br>

                                                                <a href="{{ route('status_show' ,$invoice->id) }}" >تعديل حالة الدفع
                                                                    </a><br>
                                                                    <a href="{{ route('print_invoice' ,$invoice->id) }}" >طباعة الفاتورة
                                                                    </a>




                                            </div>
                                        </div>
                                                    </td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/div-->

                        <!--div-->

                    </div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
@endsection
