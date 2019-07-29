<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  
  @include('includes.header')
  
  <body>
    
    @yield('content')

    @include('includes.footer')
      
  </body>
  
</html>

