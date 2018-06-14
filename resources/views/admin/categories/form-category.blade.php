@extends('layouts.admin')

@section('header_css')
	{!! Html::style('admin/vendors/iCheck/skins/flat/green.css') !!}
@endsection

@section('footer_js')
	{!! Html::script('admin/vendors/iCheck/icheck.min.js') !!}
	{!! Html::script('admin/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') !!}
	{!! Html::script('admin/vendors/jquery.hotkeys/jquery.hotkeys.js') !!}
	{!! Html::script('admin/vendors/google-code-prettify/src/prettify.js') !!}
	{!! Html::script('admin/vendors/jquery.tagsinput/src/jquery.tagsinput.js') !!}
	{!! Html::script('admin/vendors/switchery/dist/switchery.min.js') !!}
	{!! Html::script('admin/vendors/select2/dist/js/select2.full.min.js') !!}
	{!! Html::script('admin/vendors/autosize/dist/autosize.min.js') !!}
	{!! Html::script('admin/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') !!}
	{!! Html::script('admin/vendors/starrr/dist/starrr.js') !!}
@endsection

@section('content')
	<section id="widget-grid" class="">
		<div class="row">
			<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false" data-widget-editbutton="false">
				<div>
					<div class="widget-body">
						{!! Form::open(array(
							'id' => 'submit_form',
							'class' => 'form-horizontal ',
							'method' => 'POST',
							'enctype' => "multipart/form-data",
							'url'=> route('product-category-add')
						)) !!}
							<fieldset>
								<legend>Nhập thông tin danh mục</legend>
								@if (count($errors) > 0)
									<div class="alert alert-danger">
										<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
										</ul>
									</div>
								@endif
								<div class="x_panel">
									<div class="form-group">
										<label class="col-md-2 control-label">Danh mục cha</label>
										<div class="col-md-8">
											{!! Form::select('parent',
												$categories,
												'',
												array( 'class' => 'form-control' )
											) !!}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Tên danh mục</label>
										<div class="col-md-8">
											<input class="form-control" id="name" name="name" placeholder="Tên danh mục" type="text">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Catecode</label>
										<div class="col-md-8">
											{!! Form::text('catecode', '', array('class' => 'form-control', 'placeholder' => 'Catecode')) !!}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Hình ảnh</label>
										<div class="col-md-8">
											<input name="image" class="form-control" type="file">
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Hiển thị Header</label>
										<div class="col-md-8">
											{!! Form::select('show_frontend_header',
												array('0' => 'hidden', '1' => 'show'),
												'',
												array( 'class' => 'form-control' )
											) !!}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Vị trí Header</label>
										<div class="col-md-8">
											{!! Form::number('position_header', '', array('class' => 'form-control', 'placeholder' => '1')) !!}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Hiển thị Footer</label>
										<div class="col-md-8">
											{!! Form::select('show_frontend_footer',
												array('0' => 'hidden', '1' => 'show'),
												'',
												array('class' => 'form-control')
											) !!}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Vị trí Footer</label>
										<div class="col-md-8">
											{!! Form::number('position_footer', '', array('class' => 'form-control', 'placeholder' => '1')) !!}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Tình trạng</label>
										<div class="col-md-8">
											<div class="radio">
												<label><input type="radio" class="flat" value="1" checked name="status"> Hiển thị</label>
											</div>
											<div class="radio">
												<label><input type="radio" class="flat" value="0" name="status"> Không hiển thị</label>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Mô tả</label>
										<div class="col-md-8">
											<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
											<textarea class="ckeditor form-control" name="description" id="description" rows="5"></textarea>
											<script>
												CKEDITOR.replace( 'description' , {
													customConfig	: '{{asset("/ckeditor/config-post.js")}}',
													filebrowserBrowseUrl: '{{ asset("/ckfinder/ckfinder.html") }}',
													filebrowserImageBrowseUrl: '{{ asset("/ckfinder/ckfinder.html?type=Images") }}',
													filebrowserFlashBrowseUrl: '{{ asset("/ckfinder/ckfinder.html?type=Flash") }}',
													filebrowserUploadUrl: '{{ asset("/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files") }}',
													filebrowserImageUploadUrl: '{{ asset("/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images") }}',
													filebrowserFlashUploadUrl: '{{ asset("/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash") }}'
												});
											</script>
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Meta title</label>
										<div class="col-md-8">
											{!! Form::text('meta_title', '', array('class' => 'form-control', 'placeholder' => 'Meta title')) !!}
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Meta keyword</label>
										<div class="col-md-8">
											{!! Form::text('meta_keyword', '', array('class' => 'form-control', 'placeholder' => 'Meta keyword')) !!}
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label">Meta Description</label>
										<div class="col-md-8">
											{!! Form::text('meta_description', '', array('class' => 'form-control', 'placeholder' => 'Meta Description')) !!}
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label"></label>
										<div class="col-md-8">
											<button type="button" class="btn btn-default" onclick="window.history.back();"><i class="fa fa-repeat"></i> Trở lại</button>
											<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
										</div>
									</div>
								</fieldset>
							</div>
						{!! Form::close() !!}
					</div>
					<!-- end widget content -->
				</div>
				<!-- end widget div -->
			</div>
			</article>
		</div>
	</section>

@endsection

