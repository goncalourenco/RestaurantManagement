<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use App\Http\Resources\Invoice as InvoiceResource;
use App\InvoiceItem;
use App\Http\Resources\InvoiceItem as ItemResource;


class InvoiceControllerAPI extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nif' => 'required|digits:9',
            'name' => 'required|alpha|regex:/^[A-z][A-z\s\.\']+$/'
        ]);

        $invoice = Invoice::findOrFail($id);

        $invoice->name = $data["name"];
        $invoice->nif = $data["nif"];

        $invoice->save();
        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }

    public function getInvoiceItemsForInvoice($id){
        $invoiceItems = InvoiceItem::where('invoice_id', $id)->get();
        return ItemResource::collection($invoiceItems);
    }

    public function listInvoices(Request $request){
        
        $invoices = Invoice::where('state', 'pending')->get();
        //return $invoices;
        return InvoiceResource::collection($invoices);
    }
}
