<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComputerStuff;
use App\Models\OfficeStuff;
use App\Models\ComputerStuffToPerson;
use App\Models\OfficeStuffToRoom;
use App\Models\Room;
use App\Models\Person;

class ControllerAssignation extends Controller
{

    public function assignPerson($id){
        $person = Person::find($id)->toArray();
        $listComputerStuff = ComputerStuff::select('ID','Name')->get()->toArray();

        $structForm = ['Type'=>'Person',"Target"=>$person,"ChoiceList"=>$listComputerStuff,'AssignList'=>$this->getArrayPerson($id)];

        return view('assignation.assign',compact('structForm'));
    }


    public function assignRoom($id){
        $room = Room::find($id)->toArray();
        $listOfficeStuff = OfficeStuff::select('ID','Name')->get()->toArray();

        $structForm = ['Type'=>'Room',"Target"=>$room,"ChoiceList"=>$listOfficeStuff,'AssignList'=>$this->getArrayRoom($id)];

        return view('assignation.assign',compact('structForm'));
    }


    public function assignOfficeStuff($id){
        $officeStuff = OfficeStuff::find($id)->toArray();
        $listRoom = Room::select('ID','Name')->get()->toArray();

        $structForm = ['Type'=>'OfficeStuff',"Target"=>$officeStuff,"ChoiceList"=>$listRoom,'AssignList'=>$this->getArrayOfficeStuff($id)];
        return view('assignation.assign',compact('structForm'));
    }


    public function assignComputerStuff($id){
        $computerStuff = ComputerStuff::find($id)->toArray();
        $listPerson = Person::select('ID','Name','FirstName')->get()->toArray();

        $structForm = ['Type'=>'ComputerStuff',"Target"=>$computerStuff,"ChoiceList"=>$listPerson,'AssignList'=>$this->getArrayComputerStuff($id)];
        
        return view('assignation.assign',compact('structForm'));
    }


    public function delete($type,$id){
        if($type == "ComputerStuff" || $type == "Person"){
            try {

                $test = ComputerStuffToPerson::where('ID','=',$id)->delete();
            } catch(\Exception $exception) {

                return redirect()->back()->withFail($exception->getMessage());

            }

            return redirect()->back();

        }else if($type == "OfficeStuff" || $type == "Room"){

            try {

                OfficeStuffToRoom::where('ID','=',$id)->delete();

            } catch(\Exception $exception) {

                return redirect()->back()->withFail($exception->getMessage());

            }

            return redirect()->back();
        }
    }


    public function save(Request $request){
        $target;
        $stuff;
        $assign;

        if($request->type == "ComputerStuff"){
            $stuff= ComputerStuff::find($request->idTarget);
            $target= Person::find($request->idChoice);
        }else if($request->type == "OfficeStuff"){
            $stuff= OfficeStuff::find($request->idTarget);
            $target= Room::find($request->idChoice);
        }else if($request->type == "Person"){
            $target= Person::find($request->idTarget);
            $stuff= ComputerStuff::find($request->idChoice);
        }else if($request->type == "Room"){
            $target= Room::find($request->idTarget);
            $stuff= OfficeStuff::find($request->idChoice);
        }

        $nbStuffInStock = get_class($stuff)::find($stuff->ID)->Quantity;
        $nbStuffInStock -= ($request->type == "ComputerStuff" || $request->type == "Person")?
                            ComputerStuffToPerson::where('ComputerStuffID','=',$stuff->ID)->get()->count() :
                            OfficeStuffToRoom::where('OfficeStuffID','=',$stuff->ID)->get()->count() ;

        $request->validate(
            ['idChoice' => 'required',
            'quantity' => 'required|numeric|max:'.$nbStuffInStock.'|min:'.'1',]
        );

        for($i=0 ; $i<$request->quantity ; $i++){
            if($request->type == "ComputerStuff" || $request->type == "Person"){
                $assign= new ComputerStuffToPerson();
                $assign->PersonID = $target->ID;
                $assign->ComputerStuffID = $stuff->ID;
                

            }else if($request->type == "OfficeStuff" || $request->type == "Room"){
                $assign= new OfficeStuffToRoom();
                $assign->RoomID = $target->ID;
                $assign->OfficeStuffID = $stuff->ID;
            }
            $assign->Date = date('Y-m-d h:i:s');
            $assign->IsReturned = false;
            $assign->save();
        }

            return back();
        
    }


    private function getArrayOfficeStuff($id){

        $assignList = 
                OfficeStuff::join('OfficeStuffToRoom','OfficeStuff.ID','=','OfficeStuffToRoom.OfficeStuffID')->
                join('Room','OfficeStuffToRoom.RoomID','=','Room.ID')->
                where('OfficeStuff.ID','=',$id)->
                get(['Room.Name','OfficeStuffToRoom.Date','OfficeStuffToRoom.ID'])->
                toArray();
        
        return $assignList;
    }

    private function getArrayComputerStuff($id){

        $assignList = 
                ComputerStuff::join('ComputerStuffToPerson','ComputerStuff.ID','=','ComputerStuffToPerson.ComputerStuffID')->
                join('Person','ComputerStuffToPerson.PersonID','=','Person.ID')->
                where('ComputerStuff.ID','=',$id)->
                get(['Person.Name','Person.FirstName','ComputerStuffToPerson.Date','ComputerStuffToPerson.ID'])->
                toArray();

        return $assignList;
    }

    private function getArrayPerson($id){

        $assignList = 
        Person::join('ComputerStuffToPerson','Person.ID','=','ComputerStuffToPerson.PersonID')->
        join('ComputerStuff','ComputerStuffToPerson.ComputerStuffID','=','ComputerStuff.ID')->
        where('Person.ID','=',$id)->
        get(['ComputerStuff.Name','ComputerStuffToPerson.Date','ComputerStuffToPerson.ID'])->
        toArray();

        return $assignList;
    }

    private function getArrayRoom($id){

        $assignList = 
        Room::join('OfficeStuffToRoom','Room.ID','=','OfficeStuffToRoom.RoomID')->
        join('OfficeStuff','OfficeStuffToRoom.OfficeStuffID','=','OfficeStuff.ID')->
        where('Room.ID','=',$id)->
        get(['OfficeStuff.Name','OfficeStuffToRoom.Date','OfficeStuffToRoom.ID'])->
        toArray();
        return $assignList;
    }
}
