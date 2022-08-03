<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" style="width: 250px">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel" style="padding: 20px">
                <div class="pull-left image">
                   
                   <!-- <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Imge"  />--> 
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
             </div>
        @endif

        <!-- search form (Optional) -->
<!--        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
       <!-- <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>-->
            <!-- Optionally, you can add icons to the links -->
            <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU</li>
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-home '></i> <span>Home</span></a></li>
            <li class=""><a href="{{ url('/instructor/faculty_loading') }}"><i class='fa fa-calendar-check-o '></i> <span>Course View</span></a></li>
            <li class=""><a href="{{url('/instructor/semester_occupied')}}"><i class='fa fa-calendar-check-o '></i> <span>Semester Wise course View</span></a></li>
            <li class=""><a href="{{ url('/account/change_password') }}"><i class='fa fa-lock '></i> <span>Change Password</span></a></li>
    </section>
    <!-- /.sidebar -->
</aside>
