@extends('layouts.home')





@section('title')
  Leads - All
@stop





@section('subtitle')
  All Leads
@stop





@section('breadcrumb')
  <li class="active"><a href="{{ url('leads') }}">All Leads</a></li>
@stop







@include('partials.header')




@section('links')

@stop





@section('content')

  <div id="leads_list" class="row">
    <div id="leads_list_container" class="small-12 columns">
      <p>These are all leads for campaigns/landing pages that you are associated to.</p>

      <table id="leads_table" class="table table-bordered hover datatable">
        <thead>
        <tr>
          <th></th>
          <th>Created at</th>
          <th><span data-tooltip aria-haspopup="true" class="has-tip tip-right"
                    title="{{ Lang::get('lead.time_to_conversion') }}">Time to conversion <i
                class="fa fa-question-circle"></i></span></th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Title</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Company</th>
          <th>Last updated</th>
        </tr>
        </thead>
      </table>

    </div>
  </div>

@stop

@push('scripts')
<script>
  $(function () {
    $('#leads_table').DataTable({
      processing: true,
      serverSide: true,
      iDisplayLength: 50,
      ajax: '{{ $api }}',
      columns: [
        {data: 'link', name: 'link'},
        {data: 'created_at', name: 'created_at'},
        {data: 'timedifference', name: 'timedifference'},
        {data: 'first_name', name: 'first_name'},
        {data: 'last_name', name: 'last_name'},
        {data: 'title', name: 'title'},
        {data: 'phone', name: 'phone'},
        {data: 'email', name: 'email'},
        {data: 'company', name: 'company'},
        {data: 'updated_at', name: 'updated_at'}
      ],
      order: [
        [1, 'desc']
      ]
    });
  });
</script>
@endpush