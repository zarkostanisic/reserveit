@extends ('layouts.admin')

@section ('content')

<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
		<div class="mr-auto">
			<h3 class="m-subheader__title m-subheader__title--separator">{{ __('companies.plural') }}</h3>
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="{{ route('dashboard') }}" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
				<li class="m-nav__separator">-</li>
				<li class="m-nav__item">
					<a href="{{ route('companies.index') }}" class="m-nav__link">
						<span class="m-nav__link-text">{{ __('companies.plural') }}</span>
					</a>
				</li>

			</ul>
		</div>
	</div>
</div>

<!-- END: Subheader -->
<div class="m-content">

    <div class="m-section">
    	<admin-companies-index :cities="{{ $cities }}" :categories="{{ $categories }}"></admin-companies-index>
	</div>

</div>					

@endsection

@section ('styles')

@endsection

@section ('scripts')
@endsection