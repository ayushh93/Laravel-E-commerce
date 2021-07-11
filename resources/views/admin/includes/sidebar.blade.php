<!-- Sidebar -->
<div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
                            @if(Session::get('admin_page') == 'dashboard')
                            @php $active = "active" @endphp
                            @else
                                @php $active = "" @endphp
                            @endif


                                <li class="{{$active}}">
								<a  href="{{ROUTE('adminDashboard')}}"><i class="la la-dashboard"></i> <span> Dashboard</span>
								</a>
							</li>
                                @if(Session::get('admin_page') == 'category')
                                    @php $active = "active" @endphp
                                @else
                                    @php $active = "" @endphp
                                @endif

							<li class="{{$active}}">
								<a  href="{{ROUTE('category.index')}}"><i class="la la-list-alt"></i> <span> Category</span>
								</a>
							</li>
                                @if(Session::get('admin_page') == 'theme')
                                    @php $active = "active" @endphp
                                @else
                                    @php $active = "" @endphp
                                @endif

                            <li class="{{$active}}">
                                <a  href="{{ROUTE('theme')}}"><i class="la la-cogs"></i> <span> Theme settings</span>
                                </a>
                            </li>
                                @if(Session::get('admin_page') == 'testimonial')
                                    @php $active = "active" @endphp
                                @else
                                    @php $active = "" @endphp
                                @endif

                                <li class="{{$active}}">
                                    <a  href="{{ROUTE('testimonial.index')}}"><i class="la la-shopping-cart"></i> <span> Testimonials</span>
                                    </a>
                                </li>

                            @if(Session::get('admin_page') == 'Product')
                                    @php $active = "active" @endphp
                                @else
                                    @php $active = "" @endphp
                                @endif

                                <li class="{{$active}}">
                                    <a  href="{{ROUTE('product.index')}}"><i class="la la-shopping-cart"></i> <span> Products</span>
                                    </a>
                                </li>



						</ul>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->
