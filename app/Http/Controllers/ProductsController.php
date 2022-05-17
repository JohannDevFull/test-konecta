<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

use App\Models\Products;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Konecta/Products', [
            'products' => Products::all()
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
        $filed  = $request->filed;
        $order  = $request->order;

        $products = Products::orderBy( $filed , $order )
        ->where('name','like','%'.$request['search'].'%')
        ->orwhere('ref','like','%'.$request['search'].'%')
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
            'name'          => 'required|int',
            'ref'           => 'required|int',
            'unitary_value' => 'required|int',
            'weight'        => 'required|int',
            'fk_category_id'=> 'required|int',
            'stock'         => 'required|int'
        ]);

        if($validator->fails())
        {

            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Products::create([
            'name'              => $request->name,
            'ref'               => $request->ref,
            'unitary_value'     => $request->unitary_value,
            'weight'            => $request->weight,
            'fk_category_id'    => $request->fk_category_id,
            'stock'             => $request->stock
        ]);

        return response()->json(compact('product'),201);
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
            'name'          => 'required|int',
            'ref'           => 'required|int',
            'unitary_value' => 'required|int',
            'weight'        => 'required|int',
            'fk_category_id'=> 'required|int',
            'stock'         => 'required|int'
        ]);

        if($validator->fails())
        {

            return response()->json($validator->errors()->toJson(), 400);
        }

        $product = Products::where('id', $id)
        ->update([
            'name'              => $request->name,
            'ref'               => $request->ref,
            'unitary_value'     => $request->unitary_value,
            'weight'            => $request->weight,
            'fk_category_id'    => $request->fk_category_id,
            'stock'             => $request->stock
        ]);
       
        return response()->json(compact('product'),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product= Products::where('id','=',$id)
        ->delete();

        return response()->json(compact('product'),201);
    }
}
