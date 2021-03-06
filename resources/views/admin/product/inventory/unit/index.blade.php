 @extends('admin.layout') 
 @section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Inventory Unit Management</h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Inventory Unit Management</li>
        </ol>
    </section>
    @include('admin.partials.flashMessage')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Inventory Unit Management</h3>
                        <a href="/admin/product/inventory/unit/create" class="btn btn-warning pull-right">Add Unit</a>
                    </div>
                    <div class="box-body list-items">
                        <table class="table table-bordered ss-data-table">
                            <tr class="table_header">
                                <th style="width: 30px">#</th>                                
                                <th>Name</th>
                                <th>Abbrevation</th>
                                <th>Unit Type</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th style="width: 150px">Action</th>
                            </tr>
                            @if ($units)
                            @foreach($units as $unit)
                            <tr>
                                <td>{{$unit->id }}</td>
                                <td>{{$unit->name }}</td>
                                <td>{{$unit->abbrevation }}</td>
                                {{-- <td>{{$unit->type->name }}</td> --}}
                                <td>{{$unit->description }}</td>
                                <td>@if($unit->status == 0)
                                    <span class="label label-danger label-pixtent-success">Inactive</span>
                                    @elseif($unit->status == 1)
                                    <span class="label label-success label-pixtent-success">Active</span>
                                    @endif
                                </td>
                                <td style="width: 150px;">
                                    <div class="action-ul-cover">
                                        <ul>
                                            <li><a href="/admin/product/inventory/unit/{{$unit->id}}/edit" class="crud-ab-cover ab-edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li>
                                            <li><a href="/admin/product/inventory/unit/{{$unit->id}}/delete" class="crud-ab-cover ab-delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                    <div class="text-center">
                        {!! $units->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>  
 @endsection
 @section('script')
<script src="/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
 @endsection