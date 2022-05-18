<template>

    <AppLayout title="Caja registradora">

        <div class="mt-4" style="border: 1px solid white">
     
            <div class="m-4" style="border: 1px solid white;background: cornflowerblue;">
            
                <form class="row g-3 needs-validation p-3" @submit.prevent="store">
                  
                  <div class="col-md-2">
                    <label for="validationCustom01" class="form-label">ID:</label>
                    <input type="text" class="form-control" id="id" v-model="id_client" @keyup="getCliente()">
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">Nombre cliente</label>
                    <input type="text" class="form-control" id="name_client" v-model="name_client" required>
                    <div class="valid-feedback">
                      Looks good!
                    </div>
                  </div>


                  <div class="col-md-4">
                    <label for="validationCustom03" class="form-label">Total a pagar</label>
                    <input type="text" class="form-control" id="validationCustom03" v-model="total" disabled>
                  </div> 

                  <div class="col-12">
                    <button class="btn btn-outline-success" type="submit">Registrar venta</button>
                  </div>

                </form>
            </div>

            <div class="m-4" style="border: 1px solid white" >
                
                <table class="table table-danger table-striped mt-4 p-3" v-if="products_error.length > 0">
                    
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Producto</th>
                            <th scope="col">solicitado</th>
                            <th scope="col">stock</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                    
                        <tr v-for="(item,i) in products_error" >
                            <th scope="col">{{item.code}}</th>
                            <th scope="col">{{item.name}}</th>
                            <th scope="col">{{item.cant}}</th>
                            <th scope="col">{{item.current_stock}}</th>
                            <th scope="col">
                                <button 
                                    v-if="item.current_stock == 0 || item.current_stock == '0' "
                                    type="button" 
                                    class="btn btn-outline-primary" 
                                    @click="ajustarItem( item.code , item.current_stock )">
                                    Ajustar
                                </button>
                                -
                                <button type="button" class="btn btn-outline-danger" @click="quitarItem(i)">
                                    Quitar
                                </button>
                            </th>
                        </tr>

                    </tbody>
                </table>

            </div>



            <div class="m-4" style="border: 1px solid white">
                <table class="table table-dark table-striped mt-4 p-3" >
                  
                    <thead>
                        <tr>
                          <th scope="col">Codigo</th>
                          <th scope="col">Producto</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Val. uni</th>
                          <th scope="col">Valor</th>
                          <th scope="col">Acciones</th>
                        </tr>
                    </thead>

                    <thead>
                        <tr>
                          <th scope="row">
                            <input type="text" class="form-control"  v-model="code" @keyup="getProduct()">
                          </th>
                          
                          <th scope="row">
                            <input type="text" class="form-control" v-model="name"   >
                          </th>
                          
                          <th scope="row">
                            <input type="number" class="form-control" v-model="cant" >
                          </th>

                          <th scope="row">
                            <input type="text" class="form-control"  v-model="val_uni" disabled>
                          </th>
                          
                          <th scope="row">
                            <input type="number" class="form-control" v-model="totalPro"  disabled>
                          </th>

                          <th scope="row">

                            <button type="button" class="btn btn-outline-success" @click="addItem()">
                              <i class="fas fa-plus"></i>
                            </button>
                            
                          </th>
                        </tr>
                    </thead>

                    <tbody>
                        
                        <tr v-for="(item,i) in invoice_products">
                          
                          <td>{{item.code}}</td>
                          <td>{{item.name}}</td>
                          <td><input type="number" class="form-control"  v-model="item.cant" ></td>
                          <td>{{item.val_uni}}</td>
                          <td>{{ totalItem( item.val_uni , item.cant )}}</td>
                          <td>
                            <button type="button" class="btn btn-outline-danger" @click="deletedItem(i)">
                              <i class="fas fa-trash-alt"></i>
                            </button>
                          </td>
                        </tr>            
                    </tbody>

                </table>
            </div>

        </div>

    </AppLayout>

</template>

<script>

import AppLayout from '@/Layouts/AppLayout.vue';
import Swal from 'sweetalert2'

export default {
    name: 'CashRegister',
    components: {
        AppLayout,
        Swal
    },
    data () {
        return {
          id_client:'',
          name_client:'',

          invoice_products: [],
          products_error: [],


          code:'',
          name:'',
          val_uni:0,
          cant:0,

          total:0,



          // isLoading: false,

          // number_invoice:'',
          // date_invoice:'',
          

        }
    },
    computed:{
        totalPro()
        {
          let resp;

          resp= this.cant * this.val_uni ;

          return resp;
        },
        totalPay()
        {
          let sum=0; 
          this.total=0;

          let products = this.invoice_products;
          
          products.forEach((ele)=> {

            // this.total += ele.total;
            sum += ele.cant * ele.val_uni;
            
          });
          
          return sum;
        }
    },
    methods:{

        getCliente()
        {
          axios.get('/client/'+this.id_client)
          .then(response => {
            
            this.name_client=response.data.client.name;

          })
          .catch(error => {
              // var data = error.response.data;
          });
        },
        getProduct()
        {
          axios.get('/products-by-id/'+this.code)
          .then(response => {

            this.val_uni=response.data.product.unitary_value;
            this.name   =response.data.product.name;

          })
          .catch(error => {
              // var data = error.response.data;
          });
        },
        addItem()
        {
          let product={};

          product.code=this.code;
          product.name=this.name;
          product.cant=this.cant;
          product.iva_pro=this.iva_pro;
          product.val_uni=this.val_uni;
          product.total=this.totalPro;

          this.invoice_products.push(product);

          this.clean();
        },
        deletedItem(i)
        {

          const result = this.invoice_products.splice(i, 1);
        },
        totalItem(val_uni,cant)
        {
          let resp,iva;
          
          resp = cant * val_uni;
          
          this.total = this.totalPay;

          return resp;
        },
        store()
        {
            var payload = {

                id_client:this.id_client,
                
                value_pay:this.total,

                items_products:this.invoice_products
            };

            this.loading = true;

            axios.post('sales-invoice', payload)
            .then(response => {          
                if (response.data.status == 'ok')
                {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Venta registrada correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    });

                    this.name_client='';
                    this.id_client='';
                    this.total=0;
                    this.invoice_products=[];
                    this.clean();
                }

                if (response.data.status == 'error_stock')
                {
                    this.products_error = response.data.product;
                    Swal.fire({
                      icon: 'error',
                      title: 'Lo sentimos no hay stock suficiente ajusta o quita porductos...',
                      text: 'Something went wrong!',
                      footer: '<a href="">Why do I have this issue?</a>'
                    })
                }
            })
            .catch(error => {

                // var data = error.response.data;
            });

            this.loading = false;
        },
        clean()
        {
          this.code = 0;
          this.name = '';
          this.cant = 0;
          this.val_uni = 0;  
        },
        ajustarItem( code , cant )
        {
            let index = this.invoice_products.findIndex((el)=>{
                return el.code == code; // or el.nombre=='T NORTE';
            });

            const result = this.invoice_products[index];
            result.cant = cant;
            this.invoice_products.splice(index, 1, result);

            alert("###$$###::" +code+" %%%%::"+index)
            this.cleanErrorStock( code );
        },
        quitarItem( code )
        {
            let index = this.invoice_products.findIndex((el)=>{
                return el.code == code; // or el.nombre=='T NORTE';
            });

            this.invoice_products.splice(index, 1);

            this.cleanErrorStock( code );
        },
        cleanErrorStock(code)
        {
            let index = this.products_error.findIndex((el)=>{
                return el.code == code; // or el.nombre=='T NORTE';
            });

            const result = this.products_error.splice(index, 1);
        }




          
    }
}
</script>
