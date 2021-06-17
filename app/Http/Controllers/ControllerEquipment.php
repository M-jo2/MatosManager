<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ComputerStuff;
use App\Models\OfficeStuff;
use App\Models\ComputerStuffToPerson;
use App\Models\OfficeStuffToRoom;
use App\Models\Room;
use App\Models\Person;

class ControllerEquipment extends Controller
{
    public function index(Request $request){
        $Stuffs = [
            "OfficeStuff"=> $this->getArrayOfficeStuff(),
            "ComputerStuff"=> $this->getArrayComputerStuff()];

        //dd($Stuffs);
        return view('equipment.index',compact('Stuffs'));
    }

    public function create(Request $request){
        $equipment;

        $request->validate(
            ['EquipmentName' => 'required',
            'EquipmentQuantity' => 'required',
            'typeOfEquipment'=> 'required']
        );

        if($request->typeOfEquipment == "typeOffice")
            $equipment = new OfficeStuff();
        else if($request->typeOfEquipment == "typeComputer")
            $equipment = new ComputerStuff();
        $equipment->Name = $request->EquipmentName;
        $equipment->Quantity = $request->EquipmentQuantity;

        $equipment->save();
        return redirect()->route('equipment.index');
    }

    public function edit($idstuff,$type){
        $getStuff;
        if($type == "ComputerStuff"){
            $getStuff = ComputerStuff::where('ID','=',$idstuff)->get()->toArray();
        }else if($type == "OfficeStuff"){
            $getStuff = OfficeStuff::where('ID','=',$idstuff)->get()->toArray();
        }
        $stuffEdit = array_combine(['Stuff'], $getStuff);
        $stuffEdit['Type'] =$type;
        return view('equipment.edit',compact('stuffEdit'));
    }

    public function update(Request $request){
        $stuff;
        $minStock;
        

        if($request->type == "ComputerStuff"){
            $stuff = ComputerStuff::find($request->idstuff);
            $minStock = ComputerStuffToPerson::where('ComputerStuffID','=',$stuff->ID)->get()->count();

        }else if($request->type == "OfficeStuff"){
            $stuff = OfficeStuff::find($request->idstuff);
            $minStock = OfficeStuffToRoom::where('OfficeStuffID','=',$stuff->ID)->get()->count();
        }

        $request->validate(
            ['quantity' => 'required|numeric|min:'.$minStock]
        );

        $stuff->Quantity = $request->quantity;

        if($stuff->save())
            return redirect()->route('equipment.index');
    }

    public function deleteOfficeStuff($id){
        try {
            OfficeStuff::find($id)->delete();
        } catch(\Exception $exception) {
            return redirect()->route('equipment.index')->withFail('Impossible de supprimer un objet assigné.');;
        }
        return redirect()->route('equipment.index');
    }

    public function deleteComputerStuff($id){
        
        try {
            ComputerStuff::find($id)->delete();
        } catch(\Exception $exception) {
            return redirect()->route('equipment.index')->withFail('Impossible de supprimer un objet assigné.');;
        }
        return redirect()->route('equipment.index');
    }



    private function getArrayOfficeStuff(){

        $OfficeStuff = OfficeStuff::all()->toArray();
        foreach($OfficeStuff as $key=>$value)
        {
            $addInfo = OfficeStuffToRoom::where('OfficeStuffID','=',$value['ID'])->get()->count();
            $OfficeStuff[$key] +=["nbAssignTo"=>$addInfo];
        }

        return $OfficeStuff;
    }

    private function getArrayComputerStuff(){

        $ComputerStuff = ComputerStuff::all()->toArray();
        foreach($ComputerStuff as $key=>$value)
        {
            $addInfo = ComputerStuffToPerson::where('ComputerStuffID','=',$value['ID'])->get()->count();
            $ComputerStuff[$key] +=["nbAssignTo"=>$addInfo];
        }
        return $ComputerStuff;
    }

    public function exportCsvOfficeStuff(Request $request){
        $headers = array("Content-type" => "text/csv",
                        "Content-Disposition" => "attachment; filename=export_OfficeStuff.csv",
                        "Pragma" => "no-cache",
                        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                        "Expires" => "0");

        $Stuffs = $OfficeStuff = OfficeStuff::all()->toArray();
        $rows["header"] = ["Nom de l'équipement","Nombre total d'élément","Stock","Locaux"];

        foreach($Stuffs as $value){
            $roomAssigned = 
                Room::join('OfficeStuffToRoom','OfficeStuffToRoom.RoomID','=','Room.ID')->
                where('OfficeStuffToRoom.OfficeStuffID','=', $value['ID'])->
                get("Room.Name")->
                toArray();
            $nbStuffGive = OfficeStuffToRoom::where('OfficeStuffID','=',$value['ID'])->get()->count() ;

            $rows[$value['ID']] = [$value['Name'],$value['Quantity'],$value['Quantity']-$nbStuffGive];

            foreach($roomAssigned as $value2){
                array_push($rows[$value['ID']], $value2["Name"]);
            }
        }
        

        $callback = function() use ($rows)
        {
            $file = fopen('php://output', 'w');

            foreach($rows as $key=>$value) {
                fputcsv($file, $value);
            }
            fclose($file);
        };
         return response()->stream($callback, 200, $headers);
    }
}
