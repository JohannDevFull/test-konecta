<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

use App\Models\Invoice;

use App\Models\InvoiceProduct;
use App\Models\Product;


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
        return Inertia::render('Konecta/Invoices',[
            "invoices"      => Invoice::all()
        ]);
    }

    public function pagination(Request $request)
    {
        $show   = $request->show;
        $field  = $request->field;
        $order  = $request->order;

        $invoices = Invoice::orderBy($field, $order)
        ->where('id','like','%'.$request['search'].'%')
        ->orwhere('client_id','like','%'.$request['search'].'%')
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
        $invoice=[];
        $validator = Validator::make($request->all(), [
            'id_client'               => 'required|int',
            'value_pay'            => 'required'
        ]);

        if($validator->fails())
        {

            return response()->json($validator->errors()->toJson(), 400);
        }

        $error_stock = $this->validateStock($request->items_products);

        if ($error_stock['error'] == false)
        {
            $invoice = Invoice::create([
                // 'consecutive'           => $consecutive,
                'client_id'           => $request->id_client,
                'value_pay'           => $request->value_pay
            ]);

            foreach ($request->items_products as $key ) 
            {
                $items_invoice = InvoiceProduct::create([
                    'invoices_id'   => $invoice->id,
                    'products_id'   => $key['code'],
                    'cant'          => $key['cant'],
                    'value_unitary' => $key['val_uni'],
                    'value_total'   => $key['total']
                ]);
            }
        }
        else
        {
            return response()->json([
                'status'    => 'error_stock',
                'masage'    => 'Error productos con falta de stock',
                'product'      => $error_stock['list_errors']
            ]);
        }

        $invoice = $this->updateStocks($request->items_products);

        return response()->json([
            'status'    => 'ok',
            'masage'    => 'Venta registrada correctamente.',
            'product'      => $invoice,
        ]);
    }

    public function validateStock( $items_products )
    {
        $items_products_resp = array();
        $error=false;
        
        foreach ($items_products as $key ) 
        {
            $product = Product::find($key['code']);
            if ( $product->stock < $key['cant'] )
            {
                $key['error_stock'] = true ;
                $key['current_stock'] = $product->stock ;
                $error=true;
                $items_products_resp[] = $key ;
            }
            else
            {
                $key['error_stock'] = false ;
                $key['current_stock'] = $product->stock ;
            }
        }

        $result = [
            "error"         => $error,
            "list_errors"   => $items_products_resp
        ];

        return $result;
    }

    public function updateStocks( $items_products )
    {
        $items_products_resp = array();
        $error=false;
        
        foreach ($items_products as $key ) 
        {
            $product = Product::find($key['code']);

            $product->stock = $product->stock - $key['cant'];

            $product->save();
            
            $items_products_resp[] = $key ;
        }

        return $items_products_resp;
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
