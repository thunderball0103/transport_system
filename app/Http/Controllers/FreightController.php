<?php

namespace App\Http\Controllers;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FreightModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class FreightController extends Controller {

    protected $gmap;
    
    public function __construct(GMaps $gmap){
        $this->gmap = $gmap;
    }
    
    //loading map
    public function load_map($results){
        $model = new FreightModel; 
        $model->update_table_default();
        $config['center'] = 'lkast, Denmark';
        $config['zoom'] = 9;
        $config['click'] = 'document.getElementById("asign_dialog").style.display = "none"';
        $this->gmap->initialize($config);
        for($i=0;$i<count($results);$i++){
            $polyline['points'] = $model->get_points($results[$i]->town);
            $polyline['strokeColor'] = $results[$i]->color;
            $polyline['strokeOpacity'] = '0.5';
            $this->gmap->add_polyline($polyline);
        }
		for( $i=0 ; $i<count($results); $i++){
            $marker['animation'] = 'DROP';
            $marker['position'] = $results[$i]->address.', '.$results[$i]->zipcode.'  '.$model->filter_address($results[$i]->town).', Denmark';
            $marker['icon'] = $model->update_delivery_icon($results[$i]->town, $results[$i]->color);
            //$marker['size'] = 'big';
            //$marker['size'] = '0.4';
            $marker['onclick'] = '
            document.getElementById("asign_dialog").style.display = "block";
            document.getElementById("dialog_name").innerHTML = "'.$results[$i]->name.'";
            document.getElementById("dialog_address").innerHTML = "'.$results[$i]->address.'";
            document.getElementById("dialog_zipcode").innerHTML = "'.$results[$i]->zipcode.'";
            document.getElementById("dialog_town").innerHTML = "'.$model->filter_address($results[$i]->town).'";
            document.getElementById("dialog_phone").innerHTML = "'.$results[$i]->phone.'";
            ';
            $this->gmap->add_marker($marker);
        }
        $map = $this->gmap->create_map();
        return $map;
    }

    //display default
    public function index(Request $request){
        $model = new FreightModel; 
        $model->update_table_default();
        $results = $model->get_all_orders();
        $data['map'] = $this->load_map($results);
        $data['orders'] = $results;
        return view('layouts.default', $data);
    }

	//update marker icons by changing in select option
   public function update_delivered(Request $request){
		$model = new FreightModel;
		$name = $request->name;
        $update_town = $model->filter_address($request->up_town);
        $color = $request->color;
        $model->update_table_default();
        $model->get_update_orders($name, $update_town, $color);
        $results = $model->get_all_orders();
        $model->update_table_delivered();
        $data['map'] = $this->load_map($results);
        $data['orders'] = $results;
        return view('layouts.default', $data);
   }

	//remove delivery points after click on leftsidebar
	public function remove_sidebar(Request $request){
		$model = new FreightModel; 
        $remove_town = $request->town;
        $status = $request->status;
        $results = $model->get_remove_orders($remove_town, $status);
        $data['map'] = $this->load_map($results);
        $data['orders'] = $results;
        $data['shown_status'] = $results->shown_status;
        return view('layouts.default', $data);
	}

    //input date from start to end
    public function filter_by_date(Request $request){
        $model = new FreightModel;
        if($request->date == "today"){
            $results = $model->get_orders_today();
        }else{
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $results = $model->get_orders_by_date($start_date, $end_date);
        }
        $data['map'] = $this->load_map($results);
        $data['orders'] = $results;
        return view('layouts.default', $data);
    }

    //update database under background every 20mins
    public function update_database_xml(Request $request){
        $model = new FreightModel;
        $dom = new \DOMDocument();
        $dom->load('orders/order.xml');
        //get all order tags
        $rows = $dom->getElementsByTagName('ConsignorData');
        // for($i = 0 ; $i < count($rows) ; $i++){
        //     var_dump($rows[$i]->Name1Receiver);exit;
        // }
        // foreach($rows as $row){
        //     $name = $row->nodeValue;
        // }
        // var_dump($name);exit;
    }

    //test
    public function test(Request $request){
         $model = new FreightModel; 
        // $model->update_table_default();
         $results = $model->get_all_orders();
        // $data['map'] = $this->load_map($results);
         $data['orders'] = $results;
        return view('includes.header', $data);
   }
}