@layout('layouts/bootstraps')

@section('content')
<div class="page-header">
<h3>Navigation Setup</h3>
</div>
<div class="row-fluid">
  <div class="span9 pull-right">
    <a href="#addHeaderModal" role="button" class="btn" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Add Module </a>
    <a href="#addParentModal" role="button" class="btn" data-toggle="modal" style='margin-bottom:10px'><i class="icon-plus"></i>&nbsp;Add Page </a>
  </div>
</div>
<div class="row-fluid">
	<div class="span6 pull-left">
    {{ Form::open('admin/console/menu', 'POST', array('id' => 'navForm', 'class' => 'form-vertical')) }}
    <!-- <ul id="sortheader" class="nav nav-list alert alert-info connectedSortable" style="padding-right:0px"> -->
  		{{$render}}
    <!-- </ul> -->
    <div class="form-actions">
      <button type="submit" class="btn pull-right btn-primary">Save changes</button>
    </div>
    {{ Form::close()}}
	</div>
</div>
<div class="row-fluid">&nbsp;</div>

  <div id="addHeaderModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Add New Module</h3>
    </div>
    <div class="modal-body">
    {{ Form::open('admin/user/role', 'POST', array('id' => 'navHeaderForm', 'class' => 'form-horizontal')) }}
      <div class="control-group">
        <label class="control-label" for="navheader">Header</label>
        <div class="controls">
          {{ Form::xlarge_text('navheader',null,array('placeholder'=>'Type Module','required')) }}
        </div>
      </div>
    {{ Form::close()}}
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button id="addModuleBtn" class="btn btn-primary">Save</button>
    </div>
  </div>

  <div id="addParentModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Add New Pages</h3>
    </div>
    <div class="modal-body">
    {{ Form::open('admin/user/role', 'POST', array('id' => 'navPageForm', 'class' => 'form-horizontal')) }}
      <div class="control-group">
        <label class="control-label" for="navheaderid">Module</label>
        <div class="controls">
          {{ Form::xlarge_select('navheaderid',$headerlist) }}
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="modulpageid">Page</label>
        <div class="controls">
          {{ Form::xlarge_select('modulpageid', $pagelist) }}
        </div>
      </div>
    {{ Form::close()}}
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button id="addParentBtn" class="btn btn-primary">Save</button>
    </div>
  </div>


  <div id="addChildModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">Add New Sub Pages</h3>
    </div>
    <div class="modal-body">
    {{ Form::open('admin/user/role', 'POST', array('id' => 'navChildForm', 'class' => 'form-horizontal')) }}
      <div class="control-group">
        <label class="control-label" for="module">Module</label>
        <div class="controls">
          {{ Form::hidden('navheaderid') }}
          {{ Form::xlarge_text('module', '', array('class' => 'disabled', 'disabled' => 'disabled')); }}
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="parent">Page</label>
        <div class="controls">
          {{ Form::hidden('parentid') }}
          {{ Form::xlarge_text('parent', '', array('class' => 'disabled', 'disabled' => 'disabled')); }}
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="modulpageid"> Sub Page</label>
        <div class="controls">
          {{ Form::xlarge_select('modulpageid',  $pagelist) }}
        </div>
      </div>
    {{ Form::close()}}
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button id="addChildBtn" class="btn btn-primary">Save</button>
    </div>
  </div>

@endsection
@section('scripts')
@parent
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script>

  function addchildpages(id){

    $('#addChildModal').modal('toggle');

    $.get("navchild", { navid: id},function(data,status){

      for (x in data)
      {   

        $('#navChildForm input[name="'+ x +'"]' ).val(data[x]);

      }

      },"json");

  }

  function datasource(){


      $.get("resetnavdata", function(data,status){

      for (x in data)
      {   

        var datavalue = data[x];
        var $el = $("[name=" + x + "]");
        $el.empty();

        $.each(datavalue, function(key, value) {
          $el.append($("<option></option>")
             .attr("value", key).text(value));
        });

      }

      },"json");

  }

  function deletePage(id){

      $.post("deletepages", "id="+id ,function(data) {
            sourcedata = data;
          }).success(function() {
              $( "#sortheader" ).empty().html( sourcedata );
              datasource();
            });
  }

  function deleteModule(id){

      $.post("deletemodule", "id="+id ,function(data) {
            sourcedata = data;
          }).success(function() {
              $( "#sortheader" ).empty().html( sourcedata );
              datasource();
            });
  }




  // $("li").hover(function() { $(".actionhead").toggle();});
    $("li").hover(function() { $(".action").toggle();});

    $('#addModuleBtn').click(function() {
      
      $.post('setmodule', $("#navHeaderForm").serialize(),function(data) {
              sourcedata = data;
            }).success(function() { 
              $( "#sortheader" ).empty().html( sourcedata );
              $("#navHeaderForm :input").val('');
              datasource();
              $('#addHeaderModal').modal('hide'); 

            });


    });

    
    $('#addParentBtn').click(function() {
      
      $.post('setpage', $("#navPageForm").serialize(),function(data) {
              sourcedata = data;
            }).success(function() { 
              $( "#sortheader" ).empty().html( sourcedata );
              $("#navPageForm :input").val('');
              datasource();
              $('#addParentModal').modal('hide');
            });

    });

    $('#addChildBtn').click(function() {
      
      $.post('setchild', $("#navChildForm").serialize(),function(data) {
              sourcedata = data;
            }).success(function() { 
              $( "#sortheader" ).empty().html( sourcedata );
              $("#navHeaderForm :input").val('');
              datasource();
              $('#addChildModal').modal('hide');
            });

     

    });

  $(function() {

    $( "#sortheader" ).sortable({
      connectWith: ".connectedSortable",
      placeholder: ".input-block-level"
    }).disableSelection();

    $( "li ul #sortparent" ).sortable({
      connectWith: ".connectedparent",
      placeholder: ".input-block-level"
    }).disableSelection();

    $( "#sortchild" ).sortable({
      connectWith: ".connectedchild"
    }).disableSelection();
  });
</script>
@endsection