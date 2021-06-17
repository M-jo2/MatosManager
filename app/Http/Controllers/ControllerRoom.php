<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ComputerStuff;
use App\Models\OfficeStuff;
use App\Models\ComputerStuffToPerson;
use App\Models\OfficeStuffToRoom;
use App\Models\Room;
use App\Models\Person;


class ControllerRoom extends Controller
{
    public function index(Request $request){
        $Room = [
            "Room"=> $this->getArrayRoom()];

        //dd($Room);
        return view('room.index',compact('Room'));
    }

    public function create(Request $request){
        $room;
        $request->validate(
            ['RoomName' => 'required']
        );
        $room = new Room();
        $room->Name = $request->RoomName;
        $room->save();
        return redirect()->route('room.index');
    }

    public function delete($id){
        try {
            Room::find($id)->delete();
        } catch(\Exception $exception) {
            return redirect()->route('room.index')->withFail('Impossible de supprimer un local qui n\'est pas vide.');
        }
        return redirect()->route('room.index');
    }

    private function getArrayRoom(){

        $Room = Room::all()->toArray();
        foreach($Room as $key=>$value)
        {
            $addInfo = OfficeStuffToRoom::where('RoomID','=',$value['ID'])->get()->count();
            $Room[$key] +=["nbAssignTo"=>$addInfo];
        }

        return $Room;
    }
}
