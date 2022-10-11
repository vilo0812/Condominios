<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $orden = new Order();
        $orden->user_id = $user->id;
        $orden->package_id = $package->id;
        $orden->amount = $newAmount;
        $orden->hash = $request->hash;

        //guardamos comprobante
        $file = $request->file('voucher');
        $name = time() . "." . $file->extension();
        $file->move(public_path('storage') . '/comprobantes/', $name);
        $orden->voucher = '' . $name;

        $orden->fee = 15;
        $orden->status = '0';
        $orden->type = '0';
        $orden->type_wallet = $request->moneda;
        $orden->save();

        return response()->json('Orden created succesfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::where('id', $id)->first();
        $order->update([
            'status' => $request->status
        ]);

        return response()->json('orden updated succesfully', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
