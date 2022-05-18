<?php

namespace App\Http\Controllers\InvoicesSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use App\Models\Invoice;

use App\Models\InvoiceProduct;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoicesController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $consecutivo=InvoiceSale::all()
        ->limit(10);

        return $consecutivo;
    }

    public function pagination(Request $request)
    {
        $show   = $request->show;
        $field  = $request->field;
        $order  = $request->order;



        $invoices = InvoiceSale::orderBy($field, $order)
        ->where('number_invoice','like','%'.$request['search'].'%')
        ->orwhere('number_invoice','like','%'.$request['search'].'%')
        ->paginate($show);

        return [
            'pagination' => [
                'total'         => $invoices->total(),
                'current_page'  => $invoices->currentPage(),
                'per_page'      => $invoices->perPage(),
                'last_page'     => $invoices->lastPage(),
                'from'          => $invoices->firstItem(),
                'to'            => $invoices->lastPage()
            ],
            'invoices' => $invoices,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fk_client_id'               => 'required|int',
            'number_invoice'            => 'required|int'
        ]);

        if($validator->fails())
        {

            return response()->json($validator->errors()->toJson(), 400);
        }

        $date = Carbon::now();

        $invoice = Invoice::create([

            'number_invoice'        => $request->number_invoice,
            'fk_client_id'           => $request->provider_id,
            'value_without_iva'     => $request->value_without_iva,
            'iva'                   => $request->iva,
            'value_pay'             => $request->value_pay
        ]);

        foreach ($request->items_invoice as $key ) 
        {
            $items_invoice = InvoiceProduct::create([
                'invoices_id'   => $invoice->id,
                'products_id'   => $key['code'],
                'cant'          => $key['cant'],
                'iva'           => $key['iva_pro'],
                'value_unitary' => $key['val_uni'],
                'value_total'   => $key['total']
            ]);
        }

        return response()->json(compact('invoice','items_invoice'),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = InvoiceSale::select([
            'invoices_sales.*',
            'providers.name',
            'providers.id as id_providers'    
        ])
        ->where('invoices_sales.id','=', $id)
        ->join('providers','invoices_sales.provider_id','providers.id')
        ->get();

        $invoice[0]->items=InvoiceSaleProduct::select([
            'products.id as code',
            'products.name',
            'invoices_sales_products.cant',
            'invoices_sales_products.value_unitary as val_uni',
            'invoices_sales_products.value_total'
        ])
        ->where('invoices_id','=',$id)
        ->join('products','invoices_sales_products.products_id','products.id')
        ->get();

        $invoice=$invoice[0];

        return response()->json(compact('invoice'),201);
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
        //
        $invoice = InvoiceSale::where('id', $id)
        ->update([
            'number_invoice'        => $request->number_invoice,
            'provider_id'           => $request->provider_id,
            'branch_office_id'      => 1,
            'value_without_iva'     => $request->value_without_iva,
            'iva'                   => $request->iva,
            'value_pay'             => $request->value_pay,
            'date_invoice'          => $request->date_invoice
        ]);

        $invoice_products= InvoiceSaleProduct::where('invoices_id','=',$id)
        ->delete();

        foreach ($request->items_invoice as $key ) 
        {
            $items_invoice = InvoiceSaleProduct::create([
                'invoices_id'   => $invoice->id,
                'products_id'   => $key['code'],
                'cant'          => $key['cant'],
                'value_unitary' => $key['val_uni'],
                'value_total'   => $key['total']
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $invoice_products= InvoiceSaleProduct::where('invoices_id','=',$id)
        ->delete();

        $invoice= InvoiceSale::where('id','=',$id)
        ->delete();

        return response()->json(compact('invoice','invoice_products'),201);
    }

}
