
<template>

    <div>
        
        <Head :title="title" />

        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">
               Johann Ramirez
            </a>
            <button 
                class="navbar-toggler position-absolute d-md-none collapsed" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#sidebarMenu" 
                aria-controls="sidebarMenu" 
                aria-expanded="false" 
                aria-label="Toggle navigation"
                >
                <span class="navbar-toggler-icon"></span>
            </button>
            <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                  <!-- <a class="nav-link px-3" href="#">Sign out</a> -->
                </div>
            </div>
        </header>

        <div class="container-fluid">
            <div class="row">
                
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                  <div class="position-sticky pt-3">
                    
                    <ul class="nav flex-column">
                        
                        <li class="nav-item">
                            <Link :class="isUrl('') ? 'nav-link active' : 'nav-link'" href="/" > 
                              <i class="fas fa-tachometer-alt"></i>
                              <p>
                                Dashboard
                              </p>
                            </Link>
                        </li>
        
                        <li class="nav-item">
                            <Link :class="isUrl('cash-register') ? 'nav-link active' : 'nav-link'" href="/cash-register" > 
                                <i class="fas fa-cash-register"></i>
                                <p>
                                    Registradora
                                </p>
                            </Link>
                        </li>

                        <li class="nav-item">
                            <Link :class="isUrl('products') ? 'nav-link active' : 'nav-link'" href="/products" > 
                                <i class="fas fa-boxes"></i>
                                <p>
                                    Products
                                </p>
                            </Link>
                        </li>

                        <li class="nav-item">
                            <Link :class="isUrl('invoices') ? 'nav-link active' : 'nav-link'" href="/invoices" > 
                                <i class="fas fa-file-invoice-dollar"></i>
                                <p>
                                    Facturas ventas
                                </p>
                            </Link>
                        </li>

                    </ul>

                  </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <slot/>
                </main>

            </div>
        </div>

    </div>

</template>

<style scoped>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
</style>

<script>

    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        props:['title'],
        components: {
            Link
        },
        data() {
            return {
                count: 0,
                data_modal:[]
            }
        },
        methods:{
            isUrl(...urls) 
            {
                let currentUrl = this.$inertia.page.url.substr(1); 
                if (urls[0] === '') 
                {
                  return currentUrl === ''
                }
                return urls.filter(url => currentUrl.startsWith(url)).length
            }
        }
    }

</script>
