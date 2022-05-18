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

          <!-- <div class="col-md-3">
            <label for="validationCustomUsername" class="form-label">Fecha</label>
            <div class="input-group has-validation">
              <span class="input-group-text" id="inputGroupPrepend"><i class="fas fa-calendar-alt"></i></span>
              <input type="date" class="form-control" id="date_in" v-model="date_invoice" >
              <div class="invalid-feedback">
                Porfavor ingresar Fecha.
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <label for="validationCustom03" class="form-label">IVA</label>
            <input type="text" class="form-control" id="validationCustom03" v-model="total_iva" required>
            <div class="invalid-feedback">
              Please provide a valid city.
            </div>
          </div>

          <div class="col-md-4">
            <label for="validationCustom03" class="form-label">Valor sin iva</label>
            <input type="text" class="form-control" id="validationCustom03" v-model="totalWithoutIva" required>
            <div class="invalid-feedback">
              Please provide a valid city.
            </div>
          </div>
          
          <div class="col-md-4">
            <label for="validationCustom03" class="form-label">Valor con IVA</label>
            <input type="text" class="form-control" id="validationCustom03" v-model="total" required>
            <div class="invalid-feedback">
              Please provide a valid city.
            </div>
          </div> -->

          <div class="col-12">
            <button class="btn btn-outline-success" type="submit">Registrar venta</button>
          </div>

        </form>

      </div>

      <div class="m-4" style="border: 1px solid white">
        <table class="table table-dark table-striped mt-4 p-3" >
          
          <thead>
            <tr>
              <th scope="col">Codigo</th>
              <th scope="col">Producto</th>
              <th scope="col">Cantidad</th>
              <th scope="col">IVA %</th>
              <th scope="col">Val. uni</th>
              <th scope="col">Valor</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>

          <thead>
            <tr>
              <th scope="row">
                <input type="text" class="form-control"  v-model="code" >
              </th>
              <th scope="row">
                <input type="text" class="form-control" v-model="name"   >
              </th>
              <th scope="row">
                <input type="number" class="form-control" v-model="cant" >
              </th>
              <th scope="row">
                <input type="number" max="20" class="form-control" v-model="iva_pro" >
              </th>
              <th scope="row">
                <input type="text" class="form-control"  v-model="val_uni" >
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
            
            <tr v-for="(item,i) in invoices_products">
              
              <td>{{item.code}}</td>
              <td>{{item.name}}</td>
              <td><input type="number" class="form-control"  v-model="item.cant"  required></td>
              <td><input type="number" class="form-control"  v-model="item.iva_pro"  required></td>
              <td>{{item.val_uni}}</td>
              <td>{{ totalItem(item.val_uni, item.cant, item.iva_pro)}}</td>
              <td>
                <button type="button" class="btn btn-outline-danger" @click="deletedItem()">
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

export default {
  name: 'CashRegister',
  components: {
    AppLayout
  },
  data () {
    return {
      id_client:'',
      name_client:'',

      invoices_products: [],





      // isLoading: false,

      // number_invoice:'',
      // date_invoice:'',
      

      // code:'',
      // name:'',
      // cant:0,
      // val_uni:0,
      // total:0,
    }
  },
  computed:{
    // totalPro()
    // {
    //   let resp,iva;
      
    //   iva= ((this.val_uni * this.cant)* this.iva_pro)/100;

    //   resp= (this.cant * this.val_uni) + iva;

    //   return resp;
    // },
    
    
   
    // totalPay()
    // {
    //   let sum=0; 
    //   this.total=0;
      
    //   this.invoices_products.forEach((ele)=> {
    //     console.log(ele);

    //     this.total += ele.total;
    //     sum += ele.total;
        
    //   });
      
    //   return sum;
    // }
  },
  methods:{

    getCliente()
    {
      axios.get('/client/'+this.id_client)
      .then(response => {
        
        console.log("--------- ...getCliente... --------");
        console.log(response.data.client.name);
        console.log("--------- ...getCliente... --------");

        this.name_client=response.data.client.name;

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

      this.invoices_products.push(product);
    },
    deletedItem(id)
    {

      const result = this.invoices_products.filter(element => element.code == id);
    },
    totalItem(val_uni,cant,iva_pro)
    {
      let resp,iva;
      
      iva= ((val_uni * cant)* iva_pro)/100;

      resp= (this.cant * this.val_uni) + iva;

      return resp;
    },
    ivaItem(val_uni,cant,iva_pro)
    {
      let iva= ((val_uni * cant) * iva_pro)/100;

      return iva;
    },
    store()
    {
        var payload = {
            number_invoice:this.number_invoice,
            provider_id:this.id,
            
            value_without_iva:this.totalWithoutIva,
            iva:this.total_iva,
            value_pay:this.total,
            date_invoice:this.date_invoice,
            items_invoice:this.invoices_products
        };

        this.loading = true;

        alert(localStorage.getItem('token'))

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');

        axios.post('http://127.0.0.1:8000/api/invoices-sales', payload)
        .then(response => {
            
            console.log("--------- ...... --------");
            console.log(response);
            console.log("--------- ...... --------");

            this.$router.push('/invoices-sales');
        })
        .catch(error => {
            var data = error.response.data;
        });

        this.loading = false;
    }
      
  }
}
</script>
