<!-- BEGIN: Aside Menu -->
<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " m-menu-vertical="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
	<ul class="m-menu__nav ">
		<li class="m-menu__section m-menu__section--first">
			<h4 class="m-menu__section-text">{{ __('aside_menu.description') }}</h4>
			<i class="m-menu__section-icon flaticon-more-v2"></i>
		</li>
		<li class="m-menu__item  {{ request()->routeIs('dashboard') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="index.php" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-text">{{ __('aside_menu.dashboard') }}</span></a></li>

		<li class="m-menu__item  {{ request()->routeIs('companies') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-link-redirect="1"><a href="objects.php" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-home-1"></i><span class="m-menu__link-text">{{ __('aside_menu.companies') }}</span></a></li>

		<li class="m-menu__item  {{ request()->routeIs('users') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="users.php" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-avatar"></i><span class="m-menu__link-text">{{ __('aside_menu.users') }}</span></a></li>

		<li class="m-menu__item  {{ request()->routeIs('events') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="#" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-signs"></i><span class="m-menu__link-text">{{ __('aside_menu.events') }}</span></a></li>

		<li class="m-menu__item  {{ request()->routeIs('reservations') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-link-redirect="1"><a href="#" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-calendar"></i><span class="m-menu__link-text">{{ __('aside_menu.reservations') }}</span></a></li>

		<li class="m-menu__item  {{ request()->routeIs('settings') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" m-menu-link-redirect="1"><a href="#" class="m-menu__link "><span class="m-menu__item-here"></span><i class="m-menu__link-icon flaticon-settings-1"></i><span class="m-menu__link-text">{{ __('aside_menu.settings') }}</span></a></li>
	</ul>
</div>

<!-- END: Aside Menu -->