@extends('backend.template')

@section('content')

<h1>Tout les menus</h1>

@include('layouts.backend_flash')
@include('layouts.backend_errors')

<div class="table-responsive">
	<table class="table table-bordered table-striped sortableParent">
		<thead>
			<tr>
                            <th></th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Link</th>
                            <th></th>
			</tr>
		</thead>
                
                    @foreach($menus as $menu)
                    <tbody data-id='{{$menu['id']}}' class="sortableChild">
                        @if(isset($menu['submenu']))
                        <tr class="active">
                            <td><span class="glyphicon glyphicon-fullscreen handleParent" aria-hidden="true"></span ></td>
                            <td>{{ Form::text('title', $menu['title']) }}</td>
                            <td>Parent</td>
                            <td></td>
                            <td>
                                <a href="{{ route('admin.menus.destroy', $menu['id']) }}" data-callback="jsonp.delete_elements" data-method="delete" data-token="{{ csrf_token() }}" class="rest-link rest-link-confirm btn btn-danger btn-sm" data-confirm="Supprimer {{ $menu['title'] }} ?">Delete</a>
                            </td>
                        </tr>
                        @foreach($menu['submenu'] as $sub)
                            @if(isset($sub['title']))
                            <tr data-id='{{$sub['id']}}'>
                                <td><span class="glyphicon glyphicon-fullscreen handleChild" aria-hidden="true"></span ></td>
                                <td>{{ Form::text('title', $sub['title']) }}</td>
                                <td>{{ Form::select('type', ['internalLink' => 'Internal link', 'externalLink' => 'External link', 'separator' => 'Separator'], $sub['type'], ['class' => 'menu-select-type']) }}</td>
                                <td>{{ Form::text('link', $sub['link']) }}</td>
                                <td><a href="{{ route('admin.menus.destroy', $sub['id']) }}" data-callback="jsonp.delete_element" data-method="delete" data-token="{{ csrf_token() }}" class="rest-link rest-link-confirm btn btn-danger btn-sm" data-confirm="Supprimer {{ $sub['title'] }} ?">Delete</a></td>
                            </tr>
                            @endif
                        @endforeach
                        <tr class="create-new">
                            <td class="handleCol"></td>
                            <td>{{ Form::text('title', null, ['placeholder' => 'Title of the menu']) }}</td>
                            <td>{{ Form::select('type', ['internalLink' => 'Internal link', 'externalLink' => 'External link', 'separator' => 'Separator'], null, ['class' => 'menu-select-type']) }}</td>
                            <td>{{ Form::text('link') }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm menu-create" data-handle="handleChild">Create</button>
                            </td>
                        </tr>                          
                        @else
                        <tr class="active">
                            <td><span class="glyphicon glyphicon-fullscreen handleParent" aria-hidden="true"></span ></td>
                            <td>{{ Form::text('title', $menu['title']) }}</td>
                            <td>{{ Form::select('type', ['internalLink' => 'Internal link', 'externalLink' => 'External link'], $menu['type'], ['class' => 'menu-select-type']) }}</td>
                            <td>{{ Form::text('link', $menu['link']) }}</td>
                            <td>
                                <a href="{{ route('admin.menus.destroy', $menu['id']) }}" data-callback="jsonp.delete_element" data-method="delete" data-token="{{ csrf_token() }}" class="rest-link rest-link-confirm btn btn-danger btn-sm" data-confirm="Supprimer {{ $menu['title'] }} ?">Delete</a>
                            </td>
                        </tr> 
                        @endif                      
                    </tbody>
                    @endforeach
                    <tbody class="sortableChild create-new-parent">
                        <tr class="active">
                            <td class="handleCol"></td>
                            <td>{{ Form::text('title', null, ['placeholder' => 'Title of the menu']) }}</td>
                            <td>{{ Form::select('type', ['parent' => 'Parent', 'link' => 'Link'], null, ['class' => 'select-type menu-select-type']) }}{{ Form::select('type', ['internalLink' => 'Internal link', 'externalLink' => 'External link'], null, ['class' => 'menu-select-type isLink hidden']) }}</td>
                            <td>{{ Form::text('link', null, ['class' => 'isLink hidden']) }}</td>
                            <td><button type="button" class="btn btn-primary btn-sm menu-create-parent" data-handle="handleParent">Create</button></td>
                        </tr>  
                        
                        <tr class="create-new isParent hidden">
                            <td class="handleCol"></td>
                            <td>{{ Form::text('title', null, ['placeholder' => 'Title of the menu']) }}</td>
                            <td>{{ Form::select('type', ['internalLink' => 'Internal link', 'externalLink' => 'External link', 'separator' => 'Separator'], null, ['class' => 'menu-select-type']) }}</td>
                            <td>{{ Form::text('link') }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm menu-create" data-handle="handleChild">Create</button>
                            </td>
                        </tr>                         
                    </tbody>
        </table>
        <a href="{{ route('admin.menus.update', $zone) }}" data-token="{{ csrf_token() }}" class="btn btn-primary menu-save">Sauver</a>
                
@stop

@section('styles')
<style>
    body.dragging, body.dragging * {
      cursor: move !important;
    }
    

    .dragged {
      position: absolute;
      top: 0;
      opacity: .5;
      z-index: 2000;
    }

    .sortable {
      margin: 0 0 9px 0;
      min-height: 10px;
    }
    
    .placeholder {
      position: relative;
      margin: 0;
      padding: 0;
      border: none; 
    }

    .placeholder:before {
      position: absolute;
      content: "";
      width: 0;
      height: 0;
      margin-top: -5px;
      left: -5px;
      top: -4px;
      border: 5px solid transparent;
      border-left-color: red;
      border-right: none; 
    }
  
</style>
@endsection

@section('scripts')
	<script src="{{ asset('js/lib/jquery.plugins.js') }}"></script>
	<script type="text/javascript">
    var oldContainer;
$(function  () {
    
  var sortableConfigParent = {
    containerSelector: 'table',
    //itemPath: '> tbody',
    itemSelector: 'tbody',
    exclude: '.create-new',
    placeholder: '<tbody class="placeholder"><tr class="info"><td colspan="5"></td></tr></tbody>',    
    handle: '.handleParent',
    onDrop: function($item, container, _super) {
      container.el.find('.create-new-parent').appendTo(container.el);
      _super($item, container);
    }      
  };
  
  var sortableConfigChild = {
    containerSelector: 'tbody',
    //itemPath: '> tbody',
    itemSelector: 'tr',
    exclude: '.create-new',
    placeholder: '<tr class="placeholder info"><td colspan="5"></td></tr>',
    handle: '.handleChild',
    onDrop: function($item, container, _super) {
      container.el.find('.create-new').appendTo(container.el);
      _super($item, container);
    }    
  };
    
  $(".sortableParent").sortable(sortableConfigParent);
  $(".sortableChild").sortable(sortableConfigChild);
  
  $(document).on('click', '.menu-child-delete', function() {
        var message = ($(this).data("confirm") !== undefined) ? $(this).data("confirm") : "Êtes vous sur ?";
        if(!confirm(message)) {
            return;
        }
        
        $(this).parents('tr').remove();
  });
  
  $(document).on('click', '.menu-parent-delete', function() {
        var message = ($(this).data("confirm") !== undefined) ? $(this).data("confirm") : "Êtes vous sur ?";
        if(!confirm(message)) {
            return;
        }
        
        $(this).parents('tbody').remove(); 
  });
  
  function duplicateElement(target, btnClass, parentClass, deleteFncName, addClass) {
      var title = target.parents('.'+parentClass).find("input[name='title']").val();
      var $parent = target.parents('.'+parentClass);
      if(title === "") {
         return false; 
      }
      var newMenu = target.parents('.'+parentClass).clone();
            
      if(addClass !== undefined) {
        addClass = 'new-item';
      } 
      
      newMenu.addClass(addClass);
      
      var handle = (target.data("handle") !== undefined) ? target.data("handle") : "";
      
      newMenu.find('.handleCol:first').html('<span class="glyphicon glyphicon-fullscreen '+handle+'" aria-hidden="true"></span >');
      $('<button class="btn btn-danger btn-sm '+deleteFncName+'" data-confirm="Supprimer ' + title + ' ?">Delete</a>').insertBefore(newMenu.find('.' + btnClass));
      newMenu.find('.' + btnClass).remove();
      

      newMenu.insertBefore( $parent );
      
      $parent.find('input').val("");
      $('.' + addClass).removeClass(parentClass);

  }
  
  $(document).on('click', '.menu-create-parent', function() {
      duplicateElement($(this), 'menu-create-parent', 'create-new-parent', 'menu-parent-delete', 'new-item');
      
      var type = $(this).parents('.create-new-parent').find('.select-type').val();
      var label = $(this).parents('.create-new-parent').find('.select-type option:selected').text();
      
      if(type == "parent") {
        $('.new-item .isParent').removeClass('hidden');
        $(".new-item").sortable(sortableConfigChild);
        $('.new-item .select-type').before(label);
      } else {
        $('.new-item .isLink').removeClass('hidden');
      }

        
        $('.new-item .select-type').remove();
      $('.new-item').removeClass('new-item');
    });
  
  $(document).on('click', '.menu-create', function() {

      var selectValue = $(this).parents('.create-new').find('select').val();
         
      duplicateElement($(this), 'menu-create', 'create-new', 'menu-child-delete', 'new-item');
      
      $('.new-item option[value="' + selectValue + '"]').prop({selected: true});

      $('.new-item').removeClass('new-item');
  });
  
  $(document).on('click', '.menu-save', function() {
      
      var send = [];
      var url = $(this).attr("href");
      var order = 1;
      
      $("tbody:not(.create-new-parent)").each(function() {
          var first = $(this).find("tr:first");
          var elem = {};
          //elem.id = $(this).data('id') || null;
          elem.title = first.find("[name='title']").val();
          elem.type = first.find("[name='type']").length > 0 ? first.find("[name='type']").val() : null;
          elem.link = first.find("[name='link']").length > 0 ? first.find("[name='link']").val() : null;
          elem.order = order;
          order++;
          
          var submenu = [];
          
          $(this).find("tr:not(:first):not(.create-new)").each(function() {
              var subelem = {};
            //subelem.id = $(this).data('id') || null;
            subelem.title = $(this).find("[name='title']").val();
            subelem.type = $(this).find("[name='type']").length > 0 ? $(this).find("[name='type']").val() : null;
            subelem.link = $(this).find("[name='link']").length > 0 ? $(this).find("[name='link']").val() : null;
            subelem.order = order;
            order++;
            submenu.push(subelem);
          });
          
          if(submenu.length > 0) {
            elem.submenu = submenu;
          }
          
          send.push(elem);
        //console.log($(this).find("tr input[name='title']").val());
      });
      
      var data = {};

      data._token = $(this).data("token");
      data.menus = send;
      
      $.ajax({
            type: 'PUT',
            url: url, //resource
            data: data
      });
      //console.log(send);
      return false;
  });
});
</script>
@endsection