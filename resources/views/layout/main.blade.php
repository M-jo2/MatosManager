
@include('ressources.logo')


<!DOCTYPE html>
<html>
    <head>
        <title>laravel </title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/stylesheet.css') }}">
    </head>

    <body>

    @if(!empty($errors))
        @if($errors->any())
            <ul class="alert alert-danger" style="list-style-type: none">
                @foreach($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        @endif
    @endif

    <div class="container">
        <div class="row header">

            <div class="col-sm">
                
                <nav class="navbar navbar-expand-lg navbar-light ">
                    @yield('logo-website')

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse mr-auto" id="navbarNavAltMarkup">
                         <div class="navbar-nav mr-auto">
                            <a class="nav-item nav-link {{ (request()->is('equipment*')) ? 'active' : '' }}" href="{{ route('equipment.index')}}">EQUIPEMENT</a>
                            <a class="nav-item nav-link {{ (request()->is('room*')) ? 'active' : '' }}" href="{{ route('room.index')}}">LOCAUX</a>
                            <a class="nav-item nav-link {{ (request()->is('person*')) ? 'active' : '' }}" href="{{ route('person.index')}}">PERSONNE</a>
                        </div>
                    </div>
                </nav>

            </div>
        </div>
        
        <div class="row">
            <div class="col-sm body-content" >
                @yield('body-content')
            </div>
        </div>
        
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html> 