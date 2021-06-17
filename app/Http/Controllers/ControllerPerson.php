<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ComputerStuff;
use App\Models\OfficeStuff;
use App\Models\ComputerStuffToPerson;
use App\Models\OfficeStuffToRoom;
use App\Models\Room;
use App\Models\Person;

class ControllerPerson extends Controller
{
    public function index(Request $request){
        $Person = [
            "Person"=> $this->getArrayRoom()];

        //dd($Room);
        return view('person.index',compact('Person'));
    }

    public function create(Request $request){
        $Person;
        $request->validate(
            ['PersonName' => 'required',
                'PersonFirstName'=> 'required']
        );
        $Person = new Person();
        $Person->Name = $request->PersonName;
        $Person->FirstName = $request->PersonFirstName;
        $Person->save();
        return redirect()->route('person.index');
    }

    public function delete($id){
        try {
            Person::find($id)->delete();
        } catch(\Exception $exception) {
            return redirect()->route('person.index')->withFail('Impossible de retirer quelqu un qui loue du matériel.');;
        }
        return redirect()->route('person.index');
    }

    private function getArrayRoom(){

        $Person = Person::all()->toArray();
        foreach($Person as $key=>$value)
        {
            $addInfo = ComputerStuffToPerson::where('PersonID','=',$value['ID'])->get()->count();
            $Person[$key] +=["nbAssignTo"=>$addInfo];
        }

        return $Person;
    }
}
