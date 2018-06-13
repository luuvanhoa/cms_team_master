@extends('layouts.admin')

@section('breadcrumbs_no_url')
	<div class="row">
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-6">
			<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-th-list"></i> Thêm danh mục mới</h1>
		</div>
	</div>
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
							'url'=> route('category-add')
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
								<div class="form-group">
									<label class="col-md-2 control-label">Tên danh mục</label>
									<div class="col-md-10">
										<input class="form-control" id="name" name="name" placeholder="Tên danh mục" type="text">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Danh mục cha</label>
									<div class="col-md-10">
										{!! Form::select('parent',
											$categories,
											'',
											array( 'class' => 'form-control' )
										) !!}
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Hình ảnh</label>
									<div class="col-md-10">
										<input name="image" class="form-control" type="file">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Tình trạng</label>
									<div class="col-md-10">
										<div class="radio radio-primary radio-custom">
								            <input type="radio" name="status" id="active" value="1" checked >
								            <label for="active" class="radio-sinline">Hiển thị</label>
								        </div>
								        <div class="radio radio-primary radio-custom">
								            <input type="radio" name="status" id="inactive" value="0">
								            <label for="inactive" class="radio-sinline">Không hiển thị</label>
								        </div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Mô tả</label>
									<div class="col-md-10">
										<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
					                    <textarea class="ckeditor form-control" name="description" id="description" rows="10"></textarea>
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
									<label class="col-md-2 control-label"></label>
									<div class="col-md-10">
										<button type="button" class="btn btn-default" onclick="window.history.back();">Trở lại</button>
										<button type="submit" class="btn btn-primary">Lưu danh mục</button>
									</div>
								</div>
							</fieldset>
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

