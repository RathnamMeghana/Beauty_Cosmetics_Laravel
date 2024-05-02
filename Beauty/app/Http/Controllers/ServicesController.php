<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Services;
  
class ServicesController extends Controller
{
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $services = Services::all();  // Fetch all services members from the database
  
        return view('services', compact('services'));  // Pass the 'services' variable to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'required|string|max:255',
            'service_price' => 'required|numeric', 
        ]);
    
        $services = new Services();
        $services->service_name = $request->service_name;
        $services->service_description = $request->service_description;
        $services->service_price = $request->service_price;
        $services->save();
        return redirect()->route('services')->with('success', 'Service was added successfully!');
    
    }

    public function create()
    {
        return view('services');
    }
    
    public function edit($service_name)
    {
        return view('serviceUpdate')
        ->with('service', Services::where('service_name', $service_name)->first());
    }
    public function update(Request $request, $service_name)
    {
    $request->validate([
        'service_name' => 'required',
        'service_description' => 'required',
        'service_price' => 'required',
    ]);

  Services::where('service_name', $service_name)->
  update([
        'service_name' => $request->input('service_name'),
        'service_description' => $request->input('service_description'),
        'service_price' => $request->input('service_price')
    ]);

    return redirect()->route('services.index')
    ->with('message', 'Service has been updated!');
}

}