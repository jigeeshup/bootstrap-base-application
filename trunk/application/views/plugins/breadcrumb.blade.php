<div class="row-fluid">
  <ul class="breadcrumb">
    <!-- <pre>
    {{print_r($navLinks)}} -->
  	@foreach ($navLinks as $floor => $packet)
  		@foreach ($packet->page->action as $key => $action)
	  		@if($packet->packet == Str::lower(URI::segment(1)) && $packet->controller->name == Str::lower(URI::segment(2)) && $action->name == Str::lower(URI::segment(3)) || (URI::segment(3) == NULL && $action->name == $packet->controller->name && Str::lower(URI::segment(2)) == $packet->controller->name))
	  			<!-- <li class="active">{{Str::upper($packet->packet)}}<span class="divider">/</span></li> -->
	    		<li>{{Str::upper($packet->controller->alias)}}<span class="divider">/</span></li>
	    		<li class="{{ ($action->status != NULL)? 'active':''}}">{{Str::title($action->alias)}}</li>
	    	@endif
    	@endforeach
    @endforeach
  </ul>
</div>