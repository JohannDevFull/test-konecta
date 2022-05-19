<template>

  <AppLayout title="Productos">
    <div class="mt-4" style="border: 1px solid white">

      <div class="mt-2">
        <router-link class="btn btn-primary" to="/invoices-sales/create">
          Crear Factura compra
        </router-link>

        <div class="row">
          <div class="col-sm-12 col-md-6" >
            <label
            class="word-break"
              >Filtrar por Cantidad
              <select
                name="example1_length"
                aria-controls="example1"
                class="custom-select custom-select-sm form-control form-control-sm"
                v-model="show"
                @click="getInvoices(1, show, search)"
              >
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option> 
              </select>
            </label
            >
          </div>

          <div class="col-sm-12 col-md-6">
            <div
              id="example1_filter"
              class="float-right"
            >
              <label  
              class="sear-label "
                >Buscar por # Factura o proveerdor:<input
                  type="search"
                  class="form-control form-control-sm"
                  placeholder=""
                  aria-controls="example1"
                  v-model="search"
                  @keyup="searchInvoice()"
              /></label>
            </div>
          </div>
        </div>

      </div>

      <table class="table table-dark table-striped mt-4">
        
        <thead>
          <tr>
            <th scope="col" style="cursor:pointer" @click="changeOrder('number_invoice')">
              ID
              <template v-if="field == 'number_invoice'">
                <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                <i class="fas fa-angle-double-up text-primary" v-else></i>
              </template>
            </th>
            <th scope="col" style="cursor:pointer" @click="changeOrder('provider_id')">
              Cliente
              <template v-if="field == 'provider_id'">
                <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                <i class="fas fa-angle-double-up text-primary" v-else></i>
              </template>
            </th>
            <th scope="col" style="cursor:pointer" @click="changeOrder('iva')">
              IVA
              <template v-if="field == 'iva'">
                <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                <i class="fas fa-angle-double-up text-primary" v-else></i>
              </template>
            </th>
            <th scope="col" style="cursor:pointer" @click="changeOrder('value_without_iva')">
              Valor si IVA
              <template v-if="field == 'value_without_iva'">
                <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                <i class="fas fa-angle-double-up text-primary" v-else></i>
              </template>
            </th>
            <th scope="col" style="cursor:pointer" @click="changeOrder('value_pay')">
              Total pagado
              <template v-if="field == 'value_pay'">
                <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                <i class="fas fa-angle-double-up text-primary" v-else></i>
              </template>
            </th>
            <th scope="col" style="cursor:pointer" @click="changeOrder('date_invoice')">
              Fecha
              <template v-if="field == 'date_invoice'">
                <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                <i class="fas fa-angle-double-up text-primary" v-else></i>
              </template>
            </th>
            <th scope="col">
              Acciones
            </th>
          </tr>
        </thead>
        
        <tbody>
          
          <tr v-for="(item,i) in invoices_" :key="i">
            <th scope="row">{{item.id}}</th>
            <td>{{item.name_client}}</td>
            <td>{{item.iva}}</td>
            <td>{{item.value_without_iva}}</td>
            <td>{{item.value_pay}}</td>
            <td>{{item.date_invoice}}</td>
            <td>


              <button type="button" class="btn btn-outline-success mr-1" @click="viewInvoice(item.id)">
                <i class="fas fa-eye"></i>
              </button>
                -
              <button type="button" class="btn btn-outline-primary mr-1" @click="editInvoice(item.id)">
                <i class="fas fa-edit"></i>
              </button>
                -
              <button type="button" class="btn btn-outline-danger mr-1" @click="deleteInvoice(item.id)">
                <i class="fas fa-trash-alt"></i>
              </button>
              
            </td>
          </tr>

        </tbody>
      </table>

      <!--<nav aria-label="..." class="m-3">
        <ul class="pagination">
          <li class="page-item disabled">
            <span class="page-link">Previous</span>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item active">
            <span class="page-link">
              2
              <span class="sr-only">(current)</span>
            </span>
          </li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#">Next</a>
          </li>
        </ul>
      </nav>-->

      <div class="row">
        <div class="col-sm-12 col-md-5">
          <div
            class="dataTables_info"
            id="example1_info"
            role="status"
            aria-live="polite"
          ><p class="word-break">
            Se muestran {{ pagination.from }} de {{ count }} de un
            total de
            {{ pagination.total }}
            registros.</p>
          </div>
        </div>
        <div class="col-sm-12 col-md-7">
          <div
            class="dataTables_paginate paging_simple_numbers"
            id="example1_paginate"
          >
            <ul class="pagination flex-wrap"  >
              <li
                v-if="pagination.current_page > 1"
                class="paginate_button page-item previous"
                id="example1_previous"
              >
                <a
                  href="#"
                  @click.prevent="
                    changePage(pagination.current_page - 1)
                  "
                  aria-controls="example1"
                  data-dt-idx="0"
                  tabindex="0"
                  class="page-link"
                  >Atras</a
                >
              </li>
              <li
                class="paginate_button page-item"
                v-for="page in pagesNumber"
                :key="page"
                v-bind:class="[page == isActived ? 'active' : '']"
              >
                <a
                  href="#"
                  @click.prevent="changePage(page)"
                  aria-controls="example1"
                  data-dt-idx="1"
                  tabindex="0"
                  class="page-link"
                  >{{ page }}</a
                >
              </li>

              <li
                v-if="pagination.current_page < pagination.last_page"
                class="paginate_button page-item next"
                id="example1_next"
              >
                <a
                  href="#"
                  @click.prevent="
                    changePage(pagination.current_page + 1)
                  "
                  aria-controls="example1"
                  data-dt-idx="7"
                  tabindex="0"
                  class="page-link"
                  >Siguiente</a
                >
              </li>
            </ul>
          </div>
        </div>
      </div>
      
    </div>
  </AppLayout>

</template>

<script>

import AppLayout from '@/Layouts/AppLayout.vue';

export default {
  props:['invoices'],
  name: 'Invoices',
  components: {
    AppLayout
  },
  data(){
      return {
          show: 5,
          field: 'number_invoice',
          order: 'DESC',
          search: '',
          
          invoices_: [],
          pagination: {
            total: 0,
            current_page: 0,
            per_page: 0,
            last_page: 0,
            from: 0,
            to: 0,
          },
          offset: 3,
          setTimeoutBuscador: ''
      }
  },
  mounted(){

    this.invoices_ = this.invoices;
  },
  computed: {
    count() {
      var counted = 0;
      counted = this.pagination.from + parseInt(this.show) - 1;
      if (counted > this.pagination.total) {
        counted = this.pagination.total;
      }
      return counted;
    },
    isActived() {
      return this.pagination.current_page;
    },
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }
      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }
      var to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }
      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    },
  },
  methods:{
    getInvoices(page)
    {
        var payload = {
            show:this.show,
            field:this.field,
            order:this.order,
            search:this.search
        };

        axios.post("invoices-pagination?page=" +
            page +
            "&show=" +
            this.show +
            "&search=" +
            this.search
        , payload)
        .then(response => {
          this.pagination = response.data.pagination;
          this.invoices_ = response.data.invoices.data;
        })
        .catch(error => {
            // var data = error.response.data;
        });

        this.loading = false;
    },
    changePage(page) 
    {
      this.pagination.current_page = page;
      this.getInvoices(page);
    },
    changeOrder(val)
    {
      if(this.field == val)
      {
        if(this.order == 'DESC')
        {
          this.order='ASC'
        }else{
          this.order='DESC'
        }
      }else{
        this.field=val;
      }

      this.getInvoices();
    },
    searchInvoice(){
      
      clearTimeout( this.setTimeoutBuscador );

      this.setTimeoutBuscador=setTimeout( this.getInvoices , 200);
    },


    viewInvoice(id)
    {
    },
    editInvoice(id)
    {
      this.storeInvoice.$state = { 
        id: id
      };

      this.$router.push({ name: 'invoices_sales_edit', params: { id: id } })
    },
    deleteInvoice(id)
    {

      

      axios.delete(this.store.url_base+"invoices-sales/"+id)
      .then(response => {
          
        // this.pagination = response.data.pagination;
        // this.invoices = response.data.invoices.data;
        alert("Factura Eliminada:"+id)
        this.getInvoice();
        
      })
      .catch(error => {
          var data = error.response.data;
      });
    }
  }
}
</script>
