<aside id="left-panel">
	<div class="login-info">
		<span>
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				{!! Html::image('img/avatars/sunny.png', 'me', array('class' =>'online')) !!}
				<span>Admin</span>
			</a>
		</span>
	</div>

	<nav>
		<ul>
			<li data-route="dashboard">
				<a href="{{route('dashboard')}}" title="Dashboard">
					<i class="fa fa-lg fa-fw fa-home"></i>
					<span class="menu-item-parent">Bảng điều khiển</span>
				</a>
			</li>
			<li><hr></li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-th-list"></i><span class="menu-item-parent">Danh mục SẢN PHẨM</span></a>
				<ul>
					<li data-route="category"><a href="{{route('category')}}">Danh sách danh mục</a></li>
					<li data-route="category-add">
						<a href="{{route('category-add')}}">Thêm danh mục
						<span class="badge inbox-badge bg-color-greenLight">Mới</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-codepen"></i><span class="menu-item-parent">Sản phẩm</span></a>
				<ul>
					<li data-route="product"><a href="{{route('product')}}">Danh sách sản phẩm</a></li>
					<li data-route="product-add">
						<a href="{{route('product-add')}}">Thêm sản phẩm
						<span class="badge inbox-badge bg-color-greenLight">Mới</span></a>
					</li>
				</ul>
			</li>
			<li><hr></li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-th-list"></i><span class="menu-item-parent">Danh mục BÀI VIẾT</span></a>
				<ul>
					<li data-route="category-post"><a href="{{route('category-post')}}">Danh sách danh mục</a></li>
					<li data-route="category-post-add">
						<a href="{{route('category-post-add')}}">Thêm danh mục<span class="badge inbox-badge bg-color-greenLight">Mới</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-codepen"></i><span class="menu-item-parent">Bài viết</span></a>
				<ul>
					<li data-route="post"><a href="{{route('post')}}">Danh sách bài viết</a></li>
					<li data-route="post-add">
						<a href="{{route('post-add')}}">Thêm bài viết<span class="badge inbox-badge bg-color-greenLight">Mới</span></a>
					</li>
				</ul>
			</li>
			<li><hr></li><li>
				<a href="#"><i class="fa fa-lg fa-fw fa-picture-o"></i>
					<span class="menu-item-parent">Hình ảnh quảng cáo</span></a>
				<ul>
					<li data-route="banner"><a href="{{route('banner')}}">Danh sách hình ảnh</a></li>
					<li data-route="banner-add">
						<a href="{{route('banner-add')}}">Thêm hình ảnh
							<span class="badge inbox-badge bg-color-greenLight">Mới</span></a>
					</li>
				</ul>
			</li>
			<li><hr></li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-cogs"></i>
					<span class="menu-item-parent">Cấu hình website</span></a>
				<ul>
					<li data-route="config-footer"><a href="{{route('config-footer')}}">Thông tin footer</a></li>
					<li data-route="config-logo"><a href="{{route('config-logo')}}">Thay đổi logo</a></li>
				</ul>
			</li>

			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-user"></i> <span class="menu-item-parent">Người dùng</span></a>
				<ul>
					<li data-route="user-list"><a href="{{route('user-list')}}">Danh sách người dùng</a></li>
					<li data-route="user-add">
						<a href="{{route('user-add')}}">Thêm người dùng
							<span class="badge inbox-badge bg-color-greenLight">Mới</span></a>
					</li>
				</ul>
			</li>
		</ul>
	</nav>
	<span class="minifyme" data-action="minifyMenu">
		<i class="fa fa-arrow-circle-left hit"></i>
	</span>

</aside>