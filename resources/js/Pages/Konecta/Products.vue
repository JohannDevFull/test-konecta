<template>
    <AppLayout title="Productos">

        <div class="mt-4" style="border: 1px solid white">

            <div class="mt-2">
              

                <div class="row">
                    
                    <div class="d-flex justify-content-between">             
                        <div class="" >
                          <label class="word-break" >
                            Filtrar por Cantidad
                            <select
                                name="example1_length"
                                aria-controls="example1"
                                class="custom-select custom-select-sm form-control form-control-sm"
                                v-model="show"
                                @click="getProducts(1, show, search)"
                                >
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option> 
                            </select>
                          </label>
                        </div>

                        <div id="example1_filter" class="" >
                            <label   class="sear-label "  >
                                Buscar por Nombre o referencia:
                                <input
                                    type="search"
                                    class="form-control form-control-sm"
                                    placeholder=""
                                    aria-controls="example1"
                                    v-model="search"
                                    @keyup="searchProduct()"
                                />
                            </label>
                        </div>

                        <div class="">
                            <label   class="sear-label "  >
                                -
                                <button class="btn btn-outline-success" @click="createProduct()">
                                   Crear Producto  <i class="fas fa-plus"></i>
                                </button>
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            <table class="table table-dark table-striped mt-4">
              
                <thead>
                    <tr>
                        <th scope="col" style="cursor:pointer" @click="changeOrder('name')">
                            Nombre 
                            <template v-if="field == 'name'">
                              <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                              <i class="fas fa-angle-double-up text-primary" v-else></i>
                            </template>
                        </th>
                        <th scope="col" style="cursor:pointer" @click="changeOrder('ref')">
                            Referencia
                            <template v-if="field == 'ref'">
                              <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                              <i class="fas fa-angle-double-up text-primary" v-else></i>
                            </template>
                        </th>
                        <th scope="col" style="cursor:pointer" @click="changeOrder('unitary_value')">
                            Valor unitarios
                            <template v-if="field == 'unitary_value'">
                              <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                              <i class="fas fa-angle-double-up text-primary" v-else></i>
                            </template>
                        </th>
                        <th scope="col" style="cursor:pointer" @click="changeOrder('weight')">
                            Peso ( gramos 0 mililitros)
                            <template v-if="field == 'weight'">
                              <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                              <i class="fas fa-angle-double-up text-primary" v-else></i>
                            </template>
                        </th>
                        <th scope="col" style="cursor:pointer" @click="changeOrder('stock')">
                            Stock
                            <template v-if="field == 'stock'">
                              <i class="fas fa-angle-double-down text-primary" v-if="order == 'DESC'"></i>
                              <i class="fas fa-angle-double-up text-primary" v-else></i>
                            </template>
                        </th>
                        <th scope="col" style="cursor:pointer" @click="changeOrder('categories.name')">
                            Categoria
                            <template v-if="field == 'categories.name'">
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
                
                    <tr v-for="(item,i) in products" :key="i">
                      <td>{{item.name}}</td>
                      <td>{{item.ref}}</td>
                      <td>{{item.unitary_value}}</td>
                      <td>{{item.weight}}</td>
                      <td>{{item.stock}}</td>
                      <td>{{item.category_name}}</td>
                      <td>


                        <button type="button" class="btn btn-outline-success mr-1" @click="viewProduct(i)">
                          <i class="fas fa-eye"></i>
                        </button>
                          -
                        <button type="button" class="btn btn-outline-primary mr-1" @click="editProduct(i)">
                          <i class="fas fa-edit"></i>
                        </button>
                          -
                        <button type="button" class="btn btn-outline-danger mr-1" @click="deleteProduct(item.id)">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                        
                      </td>
                    </tr>

                </tbody>

            </table>

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

        <ModalBootstrap :_id="'modal_product'"  >
            <div class="col-12 ">
                <h4 class="mb-3" v-if=" edit_bool == false ">Crear producto</h4>
                <h4 class="mb-3" v-else>Editar producto</h4>
                
                <form id="form_product" class="needs-validation" @submit.prevent="loading = true" >
                  
                    <div class="row g-3 mb-3">

                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">
                                Nombre
                                <span class="text-danger">(*)</span>
                            </label>
                            <input 
                                id="name"  
                                type="text" 
                                class="form-control was-validated" 
                                placeholder="Nombre producto" 
                                name="name_product"
                                v-model="form_product.name" 
                                required
                                :disabled="view_bool" 
                                >
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="ref_product" class="form-label">
                                Referencia producto
                                <span class="text-danger">(*)</span>
                            </label>
                            <input 
                                id="ref_product" 
                                name="ref_product" 
                                type="text" 
                                class="form-control" 
                                placeholder="Referencia producto"
                                v-model="form_product.ref"  
                                :disabled="view_bool"
                                >
                            <div class="invalid-feedback">
                                Valid last ref is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="unitary_value" class="form-label">
                                Valor unitaio
                                <span class="text-danger">(*)</span>
                            </label>
                            <input 
                                id="unitary_value"  
                                name="unitary_value"
                                type="text" 
                                class="form-control was-validated" 
                                placeholder="Valor unitaio" 
                                v-model="form_product.unitary_value" 
                                >
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="weight" class="form-label">
                                Peso (en gramos o mililitros)
                                <span class="text-danger">(*)</span>
                            </label>
                            <input 
                                id="weight" 
                                name="weight" 
                                type="text" 
                                class="form-control" 
                                placeholder="Peso (en gramos o mililitros)" 
                                v-model="form_product.weight" 
                                required
                                >
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="fk_category_id" class="form-label">
                                Categoria --
                                <span class="text-danger">(*)</span>
                            </label>

                            <select v-model="form_product.fk_category_id" id="fk_category_id" name="fk_category_id" class="form-select" aria-label="Default select example">
                              <option selected>Open this select menu</option>
                                <option  v-for="( item , i ) in categories" :value="item.id" :key="i">
                                    {{item.name + item.id}} 
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="stock" class="form-label">
                                Stock
                                <span class="text-danger">(*)</span>
                            </label>
                            <input 
                                id="stock" 
                                name="stock" 
                                type="text" 
                                class="form-control" 
                                placeholder=""
                                v-model="form_product.stock"  
                                >
                            <div class="invalid-feedback">
                                Valid last stock is required.
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="description" class="form-label">
                                Descripción
                                <span class="text-muted">(Optional)</span>
                            </label>

                            <textarea
                                id="description" 
                                name="description" 
                                type="text" 
                                class="form-control" 
                                placeholder="Descripción" 
                                v-model="form_product.description" 
                                >
                                
                            </textarea>

                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-center mb-3">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-danger" v-for="( item , i ) in errors" :key="i">
                                {{item}}
                            </li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-center">
                        
                        <button class="m-auto btn btn-primary btn-lg" type="submit" v-if="edit_bool == false">
                            Crear producto
                        </button>

                        <button class="m-auto btn btn-primary btn-lg" type="submit" v-else>
                            Actualizar producto
                        </button>

                    </div>
                        
                </form>
            
            </div>
        </ModalBootstrap>

    </AppLayout>
</template>

<script>

import AppLayout from '@/Layouts/AppLayout.vue';
import ModalBootstrap from './Components/ModalBootstrap.vue';

import Swal from 'sweetalert2'

export default {
    props:['categories'],
    name: 'Products',
    data(){
        return {
            show: 5,
            field: 'name',
            order: 'DESC',
            search: '',

            form_product:{
                name:'',
                ref:'',
                unitary_value:'',
                weight:'',
                fk_category_id:'',
                stock:''
            },

            products: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0,
            },
            offset: 3,
            setTimeoutBuscador: '',

            loading:false,
            errors: [],
            editar_bool:false
        }
    },
    components:{
        AppLayout,
        ModalBootstrap,
        Swal
    },
    mounted(){

        this.getProducts();
        
        this.Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 4000
        });

        $.validator.setDefaults({
            submitHandler:  ()=> {

                if (this.edit_bool == false)
                {
                    this.store()
                }
                else
                {
                    this.update()
                }
            }
        });
          
        $('#form_product').validate({
            rules: {
                name: {
                    required: true
                },
                ref_product: {
                    required: true
                },
                unitary_value: {
                    required: true
                },
                weight: {
                    required: true
                },
                fk_category_id: {
                    required: true
                },
                stock: {
                    required: true
                }
            },
            errorElement: 'span',
            errorPlacement:  (error, element) => {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {

              $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {

              $(element).removeClass('is-invalid');
            }
        });
    },
    computed: {
        count(){
          var counted = 0;
          counted = this.pagination.from + parseInt(this.show) - 1;
          if (counted > this.pagination.total) {
            counted = this.pagination.total;
          }
          return counted;
        },
        isActived(){

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

        validateRolesComputed()
        {
            let x = this.form_user.roles_user.length;
            if ( x == 0)
            {

            }
            else
            {
                $("#rol_validate").removeClass('error-j');
                $("#vs1__combobox").removeClass('v-select-error');
            }

            return x;
        }
    },
    methods:{
        getProducts(page)
        {
            var payload = {
                show:this.show,
                field:this.field,
                order:this.order,
                search:this.search
            };

            this.loading = true;

            axios.post("/products-pagination?page=" +
                page +
                "&show=" +
                this.show +
                "&search=" +
                this.search
            , payload)
            .then(response => {
              this.pagination = response.data.pagination;
              this.products = response.data.products.data;
            })
            .catch(error => {
                // var data = error.response.data;
            });

            this.loading = false;
        },
        createProduct()
        {
            this.edit_bool=false;

            this.form_product={
                name:'',
                ref:'',
                unitary_value:'',
                weight:'',
                fk_category_id:'',
                stock:''
            }

            $('#modal_product').modal('show');
        },
        editProduct(i)
        {
            this.edit_bool=true;
            this.form_product = this.products[i];
            $('#modal_product').modal('show');
        },
        viewProduct(i)
        {
            this.view_bool=true;
            this.form_product = this.products[i];
            $('#modal_product').modal('show');
        },
        async store()
        {
            this.errors=[];
           
            await axios.post('/products',this.form_product)
            .then(response => {
                if (response.data.status == 'ok')
                {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.getProducts();

                    setTimeout(()=>{
                        $(".btn-close").trigger("click");
                    },200);

                }
                else
                {
                    this.Toast.fire({
                        icon: 'warning',
                        title: 'Error de validación.'
                    });

                    this.errors = response.data.errors;
                }
            })
            .catch(error => {
                this.Toast.fire({
                    icon: 'warning',
                    title: 'Error del servidor.'
                })
            }); 
        },
        async update()
        {
            this.errors=[];

            alert("update"+this.form_product.id)
           
            await axios.put('/products/'+this.form_product.id,this.form_product)
            .then(response => {
                if (response.data.status == 'ok')
                {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.getProducts();

                    setTimeout(()=>{
                        $(".btn-close").trigger("click");
                    },200);

                }
                else
                {
                    this.Toast.fire({
                        icon: 'warning',
                        title: 'Error de validación.'
                    });

                    this.errors = response.data.errors;
                }
            })
            .catch(error => {
                this.Toast.fire({
                    icon: 'warning',
                    title: 'Error del servidor.'
                })
            }); 
        },
        // Metodos paginación
        changePage(page) 
        {
          this.pagination.current_page = page;
          this.getProducts(page);
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

          this.getProducts();
        },
        searchProduct(){
          
          clearTimeout( this.setTimeoutBuscador );

          this.setTimeoutBuscador=setTimeout( this.getProducts , 200);
        },



        deleteProduct(id)
        {
            Swal.fire({
                title: 'Quieres eliminar este producto?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                denyButtonText: `Cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed)
                {
                    axios.delete("products/"+id)
                    .then(response => {
                        Swal.fire('Producto eliminado!', '', 'success')
                        this.getProducts();
                    })
                    .catch(error => {
                      var data = error.data;
                    });

                }
                else if (result.isDenied)
                {
                    Swal.fire('Ten mas cuidado a la proxima', '', 'info')
                }
            });
        }
    }
}
</script>

<style>

    .input-bg{
        background-color: #7b11f8 !important;
    }

    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: auto;
    }

    .form-signin .checkbox {
        font-weight: 400;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
