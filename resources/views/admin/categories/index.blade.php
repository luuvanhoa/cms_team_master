@extends('layouts.admin')

@section('breadcrumbs_no_url')
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
			<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-th-list"></i> Danh sách danh mục</h1>
		</div>
	</div>
@endsection

@section('content')
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
					<header>
						<span class="widget-icon"> <i class="fa fa-th-list"></i> </span>
						<h2>Danh sách danh mục</h2>
					</header>

					<div>
						<!-- widget content -->
						<div class="widget-body no-padding">
							<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
								<thead>
									<tr>
										<th>Tên danh mục</th>
										<th>Tình trạng</th>
										<th>Thao tác</th>
									</tr>
								</thead>
								<tbody>
								@if (!empty($categories))
									@foreach($categories as $key => $category)
										<?php $line = '';?>
										<?php if($category->level > 1) $line = '|';?>
										<?php $space = str_repeat('——', $category->level - 1);?>
										<?php if($category->status == 0)
												$status = '<i data-toggle="tooltip" title="Hiển thị danh mục này?" onclick="changeStatus('.$category->id.', '.$category->status.')" class="fa fa-minus-circle inactive-red"></i>';
											 else $status = '<i data-toggle="tooltip" title="Ẩn danh mục này?" onclick="changeStatus('.$category->id.', '.$category->status.')" class="fa fa-chevron-circle-down active-blue"></i>';?>
										<tr>
											<td><div class="line-cate">{{$line.$space}}</div> <a href="{{route('category-edit',$category->id)}}"> {{$category->name}}</a></td>
											<td class="status-td" id="{{$category->id}}">{!!$status!!}</td>
											<td class="action-td" role="gridcell" aria-describedby="jqgrid_act">
												<a href="{{route('category-edit',$category->id)}}" data-toggle="tooltip"
													title="Chỉnh sửa danh mục" class="btn btn-xs btn-default">
													<i class="fa fa-pencil"></i>
												</a>
												<a href="{{route('category-del',$category->id)}}" data-toggle="tooltip"
													title="Xóa danh mục" class="btn btn-xs btn-default">
													<i class="fa fa-times"></i>
												</a>
											</td>
										</tr>
									@endforeach
								@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</article>
		</div>
	</section>

@endsection

@section('content_js')
<script type="text/javascript">
	function changeStatus(id,status){
		var status_change = (status == 0) ? 1 : 0;
		$.ajax({
		    type 	: "POST",
		    url		: "<?php echo route('category-status');?>",
		    headers : {'X-CSRF-TOKEN': token},
		    data 	: {
		        id	: id,
		        status : status_change
		    },
		    success: function (response) {
		    	if ( status_change == 1 )
		    		var icon_status = '<i onclick="changeStatus('+id+', '+status_change+')"'+
		    			'data-toggle="tooltip" title="Ẩn danh mục này?"'+
		    			'class="fa fa-chevron-circle-down active-blue"></i>';
		    	else
		    		var icon_status = '<i onclick="changeStatus('+id+', '+status_change+')"'+
						'data-toggle="tooltip" title="Hiển thị danh mục này?"'+
		    			'class="fa fa-minus-circle inactive-red"></i>';
		    	$('#'+id).html(icon_status);
		    	$('[data-toggle="tooltip"]').tooltip();
		    }
		});
	}
</script>
@endsection