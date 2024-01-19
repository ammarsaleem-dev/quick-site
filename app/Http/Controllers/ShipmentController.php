<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = Shipment::paginate(3);
        return view('layouts.shipments.browse', ['shipments' => $shipments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.shipments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'vehicle' => 'required|unique:shipments',
            'driver_name' => 'nullable|string',
            'driver_number' => 'nullable|string',
        ]);
        $shipment = new Shipment();
        $shipment->vehicle = $request->input('vehicle');
        $shipment->driver_name = $request->input('driver_name');
        $shipment->driver_number = $request->input('driver_number');
        $shipment->save();
        return redirect()->route('shipments.index')->with('success', 'Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shipment = Shipment::find($id);
        return view('layouts.shipments.edit', ['shipment' => $shipment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'vehicle' => 'required|unique:shipments,vehicle,' . $id,
            'driver_name' => 'nullable|string',
            'driver_number' => 'nullable|string',
        ]);
        $shipment = Shipment::find($id);
        $shipment->vehicle = $request->input('vehicle');
        $shipment->driver_name = $request->input('driver_name');
        $shipment->driver_number = $request->input('driver_number');
        $shipment->save();
        return redirect()->route('shipments.index')->with('success', 'Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shipment = Shipment::find($id);
        $shipment->delete();
        return redirect()->route('shipments.index')->with('success', 'Successfully!');
    }
}
