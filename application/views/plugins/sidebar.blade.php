
<ul class="nav nav-list">
@foreach ($navLinks as $floor => $packet)
  <li class="nav-header">{{ Str::title($packet->controller->alias) }}</li>

  @foreach ($packet->page->action as $key => $action)
	@if($action->header)
		<li class="{{ ($action->status != NULL)? 'active':''}}"><a href="{{url($packet->packet.'/'.$packet->controller->name.'/'.$action->name)}}" ><i class="icon-edit"></i>&nbsp;{{ Str::title($action->alias) }}</a></li>
	@endif
  @endforeach
<!--   <li class="active"><a href="{{url('mileage/dashboard')}}"><i class="icon-home"></i>&nbsp;Dashboard</a></li>
  <li><a href="{{url('mileage/request')}}" ><i class="icon-pencil"></i>&nbsp;New Request</a></li>
  <li><a href="{{url('mileage/request/approval')}}" ><i class="icon-edit"></i>&nbsp;New Approval</a></li>
  <li><a href="{{url('mileage/request/history')}}" ><i class="icon-list-alt"></i>&nbsp;Claims History</a></li> -->
@endforeach
</ul>
