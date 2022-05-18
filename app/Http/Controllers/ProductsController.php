<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\Product;



class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client=DB::select('SELECT * FROM categories');
        
        return Inertia::render('Konecta/Products', [
            'categories' => $client
        ]);
    }

    /**
     * Pagination of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pagination(Request $request)
    {
        $show   = $request->show;
        $field  = $request->field;
        $order  = $request->order;

        $products = Product::select([
            'products.*',
            'categories.name as category_name',
        ])
        ->orderBy( $field , $order )
        ->where('products.name','like','%'.$request['search'].'%')
        ->orwhere('ref','like','%'.$request['search'].'%')
        ->join('categories','products.fk_category_id','categories.id')
        ->paginate($show);

        return [
            'pagination' => [
                'total'         => $products->total(),
                'current_page'  => $products->currentPage(),
                'per_page'      => $products->perPage(),
                'last_page'     => $products->lastPage(),
                'from'          => $products->firstItem(),
                'to'            => $products->lastPage()
            ],
            'products' => $products,
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
        //
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'ref'           => 'required',
            'unitary_value' => 'required',
            'weight'        => 'required',
            'fk_category_id'=> 'required',
            'stock'         => 'required'
        ]);

        if($validator->fails())
        {

            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Product::create([
            'name'              => $request->name,
            'ref'               => $request->ref,
            'unitary_value'     => $request->unitary_value,
            'weight'            => $request->weight,
            'fk_category_id'    => $request->fk_category_id,
            'stock'             => $request->stock
        ]);

        return response()->json([
            'status'    => 'ok',
            'masage'    => 'Producto creado correctamente.',
            'product'      => $product,
        ]);
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
        $validator = Validator::make($request->all(), [
            'name'          => 'required',
            'ref'           => 'required',
            'unitary_value' => 'required',
            'weight'        => 'required',
            'fk_category_id'=> 'required',
            'stock'         => 'required'
        ]);

        if($validator->fails())
        {

            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Product::where('id', $id)
        ->update([
            'name'              => $request->name,
            'ref'               => $request->ref,
            'unitary_value'     => $request->unitary_value,
            'weight'            => $request->weight,
            'fk_category_id'    => $request->fk_category_id,
            'stock'             => $request->stock
        ]);
       
        return response()->json([
            'status'    => 'ok',
            'masage'    => 'Producto actializado correctamente.',
            'product'      => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product= Product::where('id','=',$id)
        ->delete();

        return response()->json([
            'status'    => 'ok',
            'masage'    => 'Producto eliminado correctamente.',
            'product'      => $product
        ]);
    }
}
