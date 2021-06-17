@extends('layout.main')

@include('ressources.logo')

@section('body-content')

	@if(Session::has('fail'))
	    <div class="alert alert-danger">
	       {{Session::get('fail')}}
	    </div>
	@endif


	<div class="card">
		<button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#add-person" >Ajouter une nouvelle personne.</button> 

		<div class="collapse" id="add-person">
			<form action="{{ route('person.addPerson') }}" method="post">
			    @csrf 

			    <div class="d-flex justify-content-center rounded  form-row">
			    	<div class="rounded border border-dark m-1 p-1">
			    		<label>Prénom:</label>
			    		<input type="text" class="form-control" value placeholder="Justin" name="PersonFirstName">
			    		<br>
			    		<label>Nom:</label>
			    		<input type="text" class="form-control" value placeholder="Tombeur" name="PersonName">
			    		<br>
			    		<input type="submit" class="form-control btn btn-outline-dark" value="Enregistrer">
			    	</div>
				</div>
			</form>
		</div>
	</div>




	@foreach ($Person as $key0 => $value0)

		<h1 class="text-center">Personnes</h1>

		

			<div class="line-items  d-flex justify-content-between text-center border rounded border-dark bg-light">
				<table class="table table-striped table-bordered m-0 align-middle">
				@foreach ($value0 as $key => $value)
					<tr>
						<th scope="col" width="200rem"> 
						{{ $value['Name'].' '.$value['FirstName'] }}
						</th>
						<th scope="col" width="200rem"> Possède
						<span class="{{ $value['nbAssignTo']!=0 ? 'text-danger' : 'text-secondary'}}">{{ $value['nbAssignTo'] }}</span> objet{{$value['nbAssignTo']==0?'':'s'}}.</th>

						<th width="1">
							<div class="align-middle d-flex flex-row-reverse"> 
								<a href="{{ route('assign.'.$key0, $value['ID']) }}" class="btn btn-outline-success " type="button">
								@yield('logo-assign')
								</a> 

								<a href="{{ route('person.delete', $value['ID']) }}" class="btn btn-outline-danger"  type="button">
								@yield('logo-trash')
								</a> 

							</div>
						</th>
					</tr>
				@endforeach 
				</table>

				
			</div>
			
		

	@endforeach

@endsection