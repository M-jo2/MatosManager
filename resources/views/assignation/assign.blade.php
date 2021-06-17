@extends('layout.main')

@include('ressources.logo')


@section('body-content')

@if(Session::has('fail'))
    <div class="alert alert-danger">
       {{Session::get('fail')}}
    </div>
@endif
<div> 
	<form  action="{{ route('assign.save') }}" method="post"> 
		@csrf
		<div class="d-flex justify-content-center">
			<div class=" rounded border border-dark m-1 p-1">
				<input type="hidden" name="type" value="{{$structForm['Type']}}">
				<input type="hidden" name="idTarget" value="{{$structForm['Target']['ID']}}">

				@if($structForm['Type'] == 'Person')

					<h3> {{$structForm['Target']['Name'].' '.$structForm['Target']['FirstName']}} </h3>
					<br>
					<div> Assigner un(e) </div>
					<select name="idChoice">
						@foreach($structForm['ChoiceList'] as $key=>$value)
							<option value="{{$value['ID']}}"> {{$value['Name'] }} </option>
						@endforeach
				
					</select>
					

				@elseif($structForm['Type'] == 'Room')

					<h3> {{$structForm['Target']['Name']}} </h3>
					<br>
					<div> Installer un(e) </div>
					<select name="idChoice">
						@foreach($structForm['ChoiceList'] as $key=>$value)
							<option value="{{$value['ID']}}"> {{$value['Name'] }} </option>
						@endforeach
				
					</select>

				@elseif($structForm['Type'] == "OfficeStuff")

					<h3> {{$structForm['Target']['Name']}} </h3>
					<br>
					<div> Installer dans  </div>
					<select name="idChoice">
						@foreach($structForm['ChoiceList'] as $key=>$value)
							<option value="{{$value['ID']}}"> {{$value['Name'] }} </option>
						@endforeach
				
					</select>

				@elseif($structForm['Type'] == 'ComputerStuff')

					<h3>{{$structForm['Target']['Name']}}</h3> 
					<br>
					<div> Assigner à </div>
					<select name="idChoice">
						@foreach($structForm['ChoiceList'] as $key=>$value)
							<option value="{{$value['ID']}}"> {{$value['Name'].' '.$value['FirstName'] }} </option>
						@endforeach
				
					</select>

				@endif
				<br><br>
				<div>Quantité</div> 
				<input type="text" value="1" name="quantity" placeholder="Quantité">
				<br><br>
				<input type="submit" class="form-control btn btn-outline-dark" value="Enregistrer">
					
			</div>

		</div>
		
		
	</form>
</div>



<div class="card-body  bg-dark" >
	<table class="table table-striped table-dark text-white text-center align-middle">
		<thead>
			<th>
				Valider un retour
			</th>
			<th>
				Nom
			</th>
			<th>
				Date d'assignation
			</th>
		</thead>
		@foreach ($structForm['AssignList'] as $key=>$value)
			<tr>
				<th>
					<a href="{{ route('assign.delete',['type'=>$structForm['Type'], 'id'=>$value['ID']]) }}" class="btn btn-outline-success"  type="button">
						@yield('logo-returned')
					</a> 
				</th>
				<th>
					<span class="text-info">
						{{$value['Name']." ".($structForm['Type'] == "ComputerStuff" ? $value['FirstName'] : "")}} 
					</span>
				</th>
				<th>
					<span>{{$value['Date']}}</span>
				</th>
			</tr>

		@endforeach
	</table>
</div>

@endsection