   
   <nav class="navbar navbar-expand-sm sticky-top navbar-dark bg-dark min-height:0px">
      <div class="collapse navbar-collapse"  id="navbarSupportedContent">
         <ul class="navbar-nav mr-auto">

            <li class="nav-item active">
               <a class="navbar brand" style="padding-top: 0px;">
               </a>
            </li>

            @if(Auth::user()->tipo=='A')
               <li class="nav-item active">
                  <a class="nav-link" href=" {{ url('/home') }}">Logs</a>
               </li>

               <li class="nav-item active">
                  <a class="nav-link" href=" {{ url('/param') }}">Configurações</a>
               </li>

            @else
               <li class="nav-item active">
                  <a class="nav-link" href=" {{ url('/home') }}">Boletos</a>
               </li>
            @endif

         </ul>



         <ul class="navbar-nav ml-auto nav-flex-icons">
            <li class="nav-item active dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ Auth::user()->name }}
                  <i class="fa fa-user-circle-o"></i>
               </a>

               <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                  <a class="dropdown-item text-right" href="{{ url('/usuarios/perfil') }}">Perfil/Senha</a>
                  @if(Auth::user()->tipo=='C')
                     <a class="dropdown-item text-right" href="{{ url('/faleConosco') }}">Fale Conosco</a>
                  @endif
                  <a class="dropdown-item text-right" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                  <form id="frm-logout"  action="{{ route('logout') }}" method="POST" style="display: none;">
                     {{ csrf_field() }}
                  </form>
               </ul>
            </li>
            
         </ul>
      </div>
   </nav>


