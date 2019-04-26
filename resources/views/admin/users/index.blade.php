@extends ('layouts.admin')

@section ('content')

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
		<div class="mr-auto">
			<h3 class="m-subheader__title m-subheader__title--separator">{{ __('users.plural') }}</h3>
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="{{ route('dashboard') }}" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
				<li class="m-nav__separator">-</li>
				<li class="m-nav__item">
					<a href="{{ route('users.index') }}" class="m-nav__link">
						<span class="m-nav__link-text">{{ __('users.plural') }}</span>
					</a>
				</li>

			</ul>
		</div>
	</div>
</div>

<!-- END: Subheader -->
<div class="m-content">

    <div class="m-section">
		<div class="m-portlet m-portlet--mobile">
			<div class="m-portlet__head">
				<div class="m-portlet__head-caption">
					<div class="m-portlet__head-title">
						<h3 class="m-portlet__head-text">
							{{ trans('users.list') }}
						</h3>
					</div>
				</div>
				<div class="m-portlet__head-tools">
					<ul class="m-portlet__nav">
						<li class="m-portlet__nav-item">
							<a href="new_user.php" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air">
								<span>
									<i class="la la-plus"></i>
									<span>{{ __('users.singular') }}</span>
								</span>
							</a>
						</li>
						<li class="m-portlet__nav-item"></li>
					
					</ul>
				</div>
			</div>
			<div class="m-portlet__body">
				<admin-users-index :roles="{{ $roles }}" :companies="{{ $companies }}"></admin-users-index>
			</div>
		</div>
	</div>

</div>					

@endsection

@section ('styles')

@endsection

@section ('scripts')
@endsection