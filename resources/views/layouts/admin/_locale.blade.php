<li class="m-dropdown m-dropdown--inline m-dropdown--arrow m-stack__item--middle" m-dropdown-toggle="click" aria-expanded="true">
	<a href="#" class="m-dropdown__toggle btn btn-brand dropdown-toggle">
		{{ strtoupper(str_replace('_', '-', app()->getLocale())) }}													</a>
	<div class="m-dropdown__wrapper" style="z-index: 101;">
		<span class="m-dropdown__arrow m-dropdown__arrow--left"></span>
		<div class="m-dropdown__inner">
			<div class="m-dropdown__body">
				<div class="m-dropdown__content">
					<ul class="m-nav">
						<li class="m-nav__item">
							<a href="{{ route('locale', 'en') }}" class="m-nav__link">
								<span class="m-nav__link-text">EN</span>
							</a>
						</li>

						<li class="m-nav__item">
							<a href="{{ route('locale', 'sr') }}" class="m-nav__link">
								<span class="m-nav__link-text">SR</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</li>