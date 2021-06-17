@extends('layout.main')

@include('ressources.logo')




@section('body-content')
@if(Session::has('fail'))
    <div class="alert alert-danger">
       {{Session::get('fail')}}
    </div>
@endif
<div class="card">
	<button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#add-equipment" >Creer un nouvel equipement.</button> 

	<div class="collapse" id="add-equipment">
		<form action="{{ route('equipment.addEquipment') }}" method="post">
		    @csrf 


			<div class="d-flex justify-content-center rounded ">
				<div class="rounded border border-dark m-1 p-1"> 
					Type d'équipement : <br>
			    	<div class="form-check form-check-inline">
				  		<input checked class="form-check-input" type="radio" name="typeOfEquipment" id="inlineRadio1" value="typeOffice">
						<label class="form-check-label" for="inlineRadio1">Bureau</label>
					</div>
					<div class="form-check form-check-inline">
					  	<input class="form-check-input" type="radio" name="typeOfEquipment" id="inlineRadio2" value="typeComputer">
					  	<label class="form-check-label" for="inlineRadio2">informatique</label>
					</div><br><br>
					<label>Nom de l'équipement:</label>
					<input type="text" class="form-control" value placeholder="Guillotine" name="EquipmentName">
					<br>
					<label>Quantité:</label>
					<input type="text" class="form-control" placeholder="12000" name="EquipmentQuantity">
					<br>
					<input type="submit" class="form-control btn btn-outline-dark" value="Enregistrer">
				</div>
			</div>
		    
		</form>
	</div>
</div>




@foreach ($Stuffs as $key0 => $value0)

	@if($key0 == "OfficeStuff")
		<h1 class="text-center">Bureau 
			<a href="{{route('equipment.download')}}" class="btn btn-outline-success" type="button">
				@yield('logo-downloadexcel')
			</a> 
		</h1>
	@elseif($key0 == "ComputerStuff")
		<h1 class="text-center">Informatique</h1>
	@endif

	

		<div class="line-items  d-flex justify-content-between text-center border rounded border-dark bg-light">
			<table class="table table-striped table-bordered m-0 align-middle">
				@foreach ($value0 as $key => $value)
					<tr>
						<th scope="col" width="200rem"> 
						{{ $value['Name'] }}
						</th>

						<th scope="col" width="200rem"> 	
							{{ $value['Quantity'] }} pièces au total
						</th>
						<th scope="col" width="200rem"> 
							Assigné 
							<span class="{{ $value['nbAssignTo']!=0 ? 'text-danger' : 'text-secondary'}}">
								{{ $value['nbAssignTo'] }}
							</span> fois. 
						</th>
						<th width="1">
							<div class="align-middle d-flex flex-row-reverse"> 
								<a href="{{ route('equipment.edit', ['idstuff'=>$value['ID'],'type'=>$key0]) }}" class="btn btn-outline-warning"  type="button">
								@yield('logo-edit')
								</a> 
								<a href="{{ route('assign.'.$key0, $value['ID']) }}" class="btn btn-outline-success" type="button">
								@yield('logo-assign')
								</a> 
								<a href="{{ route('equipment.delete'.$key0 , $value['ID']) }}" class="btn btn-outline-danger"  type="button">
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