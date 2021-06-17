@extends('layout.main')

@include('ressources.logo')


@section('body-content')

@if(Session::has('fail'))
    <div class="alert alert-danger">
       {{Session::get('fail')}}
    </div>
@endif


<div> 
	<form  action="{{ route('equipment.update') }}" method="post"> 
		@csrf

		<div class="d-flex justify-content-center">
			<div class=" rounded border border-dark m-1 p-1">
				<input type="hidden" name="type" value="{{$stuffEdit['Type']}}">
				<input type="hidden" name="idstuff" value="{{$stuffEdit['Stuff']['ID']}}">
				<div>{{$stuffEdit['Stuff']['Name']}} est repris {{$stuffEdit['Stuff']['Quantity']}}  fois dans le stock</div>
				<br>
				<div>Nouvelle quantité</div> 
				<input type="text" name="quantity" placeholder="1200700">
				<input type="submit" class="form-control btn btn-outline-dark" value="Enregistrer">
					
			</div>
		</div>
	</form>
</div>

@endsection