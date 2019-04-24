<li class="m-dropdown m-dropdown--inline m-dropdown--arrow m-stack__item--middle" m-dropdown-toggle="click" aria-expanded="true">
	<a href="#" class="m-dropdown__toggle btn btn-brand dropdown-toggle">
		{{ strtoupper(app()->getLocale()) }}													</a>
	<div class="m-dropdown__wrapper" style="z-index: 101;">
		<span class="m-dropdown__arrow m-dropdown__arrow--left"></span>
		<div class="m-dropdown__inner">
			<div class="m-dropdown__body">
				<div class="m-dropdown__content">
					<ul class="m-nav">

						@foreach ($languages as $lang)
							@if (app()->getLocale() != $lang)
								<li class="m-nav__item">
									<a href="{{ route('locale', $lang) }}" class="m-nav__link">
										<span class="m-nav__link-text">{{ strtoupper($lang) }}</S></span>
									</a>
								</li>
							@endif
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</li>