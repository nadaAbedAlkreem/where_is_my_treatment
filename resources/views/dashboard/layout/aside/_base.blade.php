
<!--begin::Content wrapper-->
<div class="d-flex flex-column-fluid">
    <!--begin::Aside-->
    <div id="kt_aside" class="aside card" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_toggle">
        <!--begin::Aside menu-->
        <div class="aside-menu flex-column-fluid px-5">
            <!--begin::Aside Menu-->
            <div class="hover-scroll-overlay-y my-5 pe-4 me-n4" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside, #kt_aside_menu" data-kt-scroll-offset="{lg: '75px'}">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded fw-bold fs-6" id="#kt_aside_menu" data-kt-menu="true">
                    @can('view dashboard')
                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <!-- SVG ICON -->
                            </span>
                            <span class="menu-title">لوحات التحكم </span>
                            <span class="menu-arrow"></span>
                        </span>
                            <div class="menu-sub menu-sub-accordion menu-active-bg">
                                <div class="menu-item">
                                    <a class="menu-link {{ request()->routeIs('admin.dashboard.home') ? 'active' : '' }}" href="{{ route('admin.dashboard.home') }}">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">احصائيات التطبيق </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan

                    <div class="menu-item">
                        <div class="menu-content pt-8 pb-2">
                            <span class="menu-section text-muted text-uppercase fs-8 ls-1">Crafted</span>
                        </div>
                    </div>

                    <div data-kt-menu-trigger="click" class="menu-item   menu-accordion mb-1">
											<span class="menu-link">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: icons/duotune/general/gen051.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black" />
															<path d="M14.854 11.321C14.7568 11.2282 14.6388 11.1818 14.4998 11.1818H14.3333V10.2272C14.3333 9.61741 14.1041 9.09378 13.6458 8.65628C13.1875 8.21876 12.639 8 12 8C11.361 8 10.8124 8.21876 10.3541 8.65626C9.89574 9.09378 9.66663 9.61739 9.66663 10.2272V11.1818H9.49999C9.36115 11.1818 9.24306 11.2282 9.14583 11.321C9.0486 11.4138 9 11.5265 9 11.6591V14.5227C9 14.6553 9.04862 14.768 9.14583 14.8609C9.24306 14.9536 9.36115 15 9.49999 15H14.5C14.6389 15 14.7569 14.9536 14.8542 14.8609C14.9513 14.768 15 14.6553 15 14.5227V11.6591C15.0001 11.5265 14.9513 11.4138 14.854 11.321ZM13.3333 11.1818H10.6666V10.2272C10.6666 9.87594 10.7969 9.57597 11.0573 9.32743C11.3177 9.07886 11.6319 8.9546 12 8.9546C12.3681 8.9546 12.6823 9.07884 12.9427 9.32743C13.2031 9.57595 13.3333 9.87594 13.3333 10.2272V11.1818Z" fill="black" />
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
												</span>
												<span class="menu-title">قسم ادارة المستخدمين</span>
												<span class="menu-arrow"></span>
											</span>
                        <div class="menu-sub menu-sub-accordion">
                            @can('view admin')
                                <div data-kt-menu-trigger="click" class="menu-item  {{ request()->routeIs('admin.dashboard.admins') ? 'here show ' : '' }}  menu-accordion mb-1">
													<span class="menu-link">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">المشرفين</span>
														<span class="menu-arrow"></span>
													</span>
                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('admin.dashboard.admins') ? 'active' : '' }}" href="{{route('admin.dashboard.admins')}}">
																<span class="menu-bullet">
																	<span class="bullet bullet-dot"></span>
																</span>
                                            <span class="menu-title">قائمة المشرفين</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endcan
                        </div>
                        <div class="menu-sub menu-sub-accordion">
                            @can('view employee')

                            <div data-kt-menu-trigger="click" class="menu-item  {{ request()->routeIs('admin.dashboard.employees') ? 'here show  ' : '' }} menu-accordion mb-1">
													<span class="menu-link">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">الموظفين</span>
														<span class="menu-arrow"></span>
													</span>
                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('admin.dashboard.employees') ? 'active ' : '' }}" href="{{route('admin.dashboard.employees')}}">
																<span class="menu-bullet">
																	<span class="bullet bullet-dot"></span>
																</span>
                                            <span class="menu-title">قائمة الموظفين</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endcan

                           @can('view pharmacy_owner')
                            <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('admin.dashboard.pharmacy_owner') ? 'here show ' : '' }} menu-accordion">
													<span class="menu-link">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">ماكلي الصيدليات</span>
														<span class="menu-arrow"></span>
													</span>
                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('admin.dashboard.pharmacy_owner') ? 'active ' : '' }}" href="{{route('admin.dashboard.pharmacy_owner')}}">
																<span class="menu-bullet">
																	<span class="bullet bullet-dot"></span>
																</span>
                                            <span class="menu-title">قائمة الصيدليات</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                           @endcan
                        </div>
                        <div class="menu-sub menu-sub-accordion">
                            @can('view app_user')

                            <div data-kt-menu-trigger="click" class="menu-item  {{ request()->routeIs('admin.dashboard.users-management.users') ? 'here show  ' : '' }} menu-accordion mb-1">
													<span class="menu-link">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
														<span class="menu-title">مستخدمين</span>
														<span class="menu-arrow"></span>
													</span>
                                <div class="menu-sub menu-sub-accordion">
                                    <div class="menu-item">
                                        <a class="menu-link {{ request()->routeIs('admin.dashboard.users-management.users') ? 'active ' : '' }}" href="{{route('admin.dashboard.users-management.users')}}">
																<span class="menu-bullet">
																	<span class="bullet bullet-dot"></span>
																</span>
                                            <span class="menu-title">قائمة مستخدمين التطبيق </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endcan

                        </div>

                    </div>
                        @can('view role')
                              <div data-kt-menu-trigger="click" class="menu-item   menu-accordion mb-1">
											<span class="menu-link">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: icons/duotune/general/gen051.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black" />
															<path d="M14.854 11.321C14.7568 11.2282 14.6388 11.1818 14.4998 11.1818H14.3333V10.2272C14.3333 9.61741 14.1041 9.09378 13.6458 8.65628C13.1875 8.21876 12.639 8 12 8C11.361 8 10.8124 8.21876 10.3541 8.65626C9.89574 9.09378 9.66663 9.61739 9.66663 10.2272V11.1818H9.49999C9.36115 11.1818 9.24306 11.2282 9.14583 11.321C9.0486 11.4138 9 11.5265 9 11.6591V14.5227C9 14.6553 9.04862 14.768 9.14583 14.8609C9.24306 14.9536 9.36115 15 9.49999 15H14.5C14.6389 15 14.7569 14.9536 14.8542 14.8609C14.9513 14.768 15 14.6553 15 14.5227V11.6591C15.0001 11.5265 14.9513 11.4138 14.854 11.321ZM13.3333 11.1818H10.6666V10.2272C10.6666 9.87594 10.7969 9.57597 11.0573 9.32743C11.3177 9.07886 11.6319 8.9546 12 8.9546C12.3681 8.9546 12.6823 9.07884 12.9427 9.32743C13.2031 9.57595 13.3333 9.87594 13.3333 10.2272V11.1818Z" fill="black" />
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
												</span>
												<span class="menu-title">قسم ادارة الصلاحيات والادوار</span>
												<span class="menu-arrow"></span>
											</span>

                        <div class="menu-sub menu-sub-accordion">
                          <div class="menu-item {{ request()->routeIs('admin.dashboard.permission-roles-management.permission') ? 'here show ' : '' }} ">
                                <a class="menu-link" href="{{route('admin.dashboard.permission-roles-management.permission')}}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
                                    <span class="menu-title">الصلاحيات</span>
                                </a>
                            </div>

                            <div class="menu-item {{ request()->routeIs('admin.dashboard.permission-roles-management.roles') ? 'here show ' : '' }}">
                                <a class="menu-link" href="{{route('admin.dashboard.permission-roles-management.roles')}}">
														<span class="menu-bullet">
															<span class="bullet bullet-dot"></span>
														</span>
                                    <span class="menu-title">الادوار</span>
                                </a>
                            </div>
                        </div>

                    </div>
                        @endcan



                    <div data-kt-menu-trigger="click" class="menu-item  menu-accordion mb-1">
											<span class="menu-link">
												<span class="menu-icon">
													<!--begin::Svg Icon | path: icons/duotune/general/gen051.svg-->
													<span class="svg-icon svg-icon-2">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
															<path opacity="0.3" d="M20.5543 4.37824L12.1798 2.02473C12.0626 1.99176 11.9376 1.99176 11.8203 2.02473L3.44572 4.37824C3.18118 4.45258 3 4.6807 3 4.93945V13.569C3 14.6914 3.48509 15.8404 4.4417 16.984C5.17231 17.8575 6.18314 18.7345 7.446 19.5909C9.56752 21.0295 11.6566 21.912 11.7445 21.9488C11.8258 21.9829 11.9129 22 12.0001 22C12.0872 22 12.1744 21.983 12.2557 21.9488C12.3435 21.912 14.4326 21.0295 16.5541 19.5909C17.8169 18.7345 18.8277 17.8575 19.5584 16.984C20.515 15.8404 21 14.6914 21 13.569V4.93945C21 4.6807 20.8189 4.45258 20.5543 4.37824Z" fill="black" />
															<path d="M14.854 11.321C14.7568 11.2282 14.6388 11.1818 14.4998 11.1818H14.3333V10.2272C14.3333 9.61741 14.1041 9.09378 13.6458 8.65628C13.1875 8.21876 12.639 8 12 8C11.361 8 10.8124 8.21876 10.3541 8.65626C9.89574 9.09378 9.66663 9.61739 9.66663 10.2272V11.1818H9.49999C9.36115 11.1818 9.24306 11.2282 9.14583 11.321C9.0486 11.4138 9 11.5265 9 11.6591V14.5227C9 14.6553 9.04862 14.768 9.14583 14.8609C9.24306 14.9536 9.36115 15 9.49999 15H14.5C14.6389 15 14.7569 14.9536 14.8542 14.8609C14.9513 14.768 15 14.6553 15 14.5227V11.6591C15.0001 11.5265 14.9513 11.4138 14.854 11.321ZM13.3333 11.1818H10.6666V10.2272C10.6666 9.87594 10.7969 9.57597 11.0573 9.32743C11.3177 9.07886 11.6319 8.9546 12 8.9546C12.3681 8.9546 12.6823 9.07884 12.9427 9.32743C13.2031 9.57595 13.3333 9.87594 13.3333 10.2272V11.1818Z" fill="black" />
														</svg>
													</span>
                                                    <!--end::Svg Icon-->
												</span>
												<span class="menu-title "> قسم ادارة  الصيدليات  و الادوية</span>
												<span class="menu-arrow"></span>
											</span>
                                            <div class="menu-sub menu-sub-accordion">
                                                @can('view category')
                                                 <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('admin.dashboard.category') ? 'here show ' : '' }}   menu-accordion mb-1">
                                                                        <span class="menu-link">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">الفئات</span>
                                                                            <span class="menu-arrow"></span>
                                                                        </span>
                                                    <div class="menu-sub menu-sub-accordion">
                                                        <div class="menu-item">
                                                            <a class="menu-link {{ request()->routeIs('admin.dashboard.category') ? 'active ' : '' }}" href="{{route('admin.dashboard.category')}}">
                                                                                    <span class="menu-bullet">
                                                                                        <span class="bullet bullet-dot"></span>
                                                                                    </span>
                                                                <span class="menu-title">قائمة الفئات</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endcan

                                                @can('view pharmacy_stock')
                                                    <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('admin.dashboard.stock_pharmacy') ? 'here show  ' : '' }}  menu-accordion mb-1">
                                                                        <span class="menu-link">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">مخزون الصيدليات </span>
                                                                            <span class="menu-arrow"></span>
                                                                        </span>
                                                    <div class="menu-sub menu-sub-accordion">
                                                        <div class="menu-item">
                                                            <a class="menu-link {{ request()->routeIs('admin.dashboard.stock_pharmacy') ? 'active ' : '' }}" href="{{route('admin.dashboard.stock_pharmacy')}}">
                                                                                    <span class="menu-bullet">
                                                                                        <span class="bullet bullet-dot"></span>
                                                                                    </span>
                                                                <span class="menu-title">مخزون الصيدلية</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endcan
                                               @can('view medicine')
                                               <div class="menu-sub menu-sub-accordion">
                                                    <div data-kt-menu-trigger="click" class="menu-item {{ request()->routeIs('admin.dashboard.treatment_management') ? 'here show  ' : '' }} menu-accordion mb-1">
                                                                        <span class="menu-link">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">الادوية</span>
                                                                            <span class="menu-arrow"></span>
                                                                        </span>
                                                        <div class="menu-sub menu-sub-accordion">
                                                            <div class="menu-item">
                                                                <a class="menu-link {{ request()->routeIs('admin.dashboard.treatment_management') ? 'active ' : '' }}" href="{{route('admin.dashboard.treatment_management')}}">
                                                                                    <span class="menu-bullet">
                                                                                        <span class="bullet bullet-dot"></span>
                                                                                    </span>
                                                                    <span class="menu-title">قائمة الادوية</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>

                        </div>
                                              @endcan


                                            </div>


                </div>
                <!--end::Menu-->
            </div>
        </div>
        <!--end::Aside menu-->

    </div>
    <!--end::Aside-->

    </div>
</div>
<!--end::Content wrapper-->
