<template>


    <title>Ver Articulos</title>
<div class="container">
        <label for="busqueda" >
            <a class="pt-2 pb-2 re_btn rounded mt-5 mb-5">  Buscar producto: </a>
        </label>
        <div class="search-bar">
            <input type="text" id="busqueda" oninput="filtrarProductos()" placeholder="Ingresa tu búsqueda">
        </div>
        <label for="filtroPrecio">
            <a class="pt-2 pb-2 re_btn rounded mt-5 mb-5">  Filtro de precio: </a>
        </label>
        <select id="filtroPrecio" onchange="filtrarProductos()">
            <option value="todos">Todos</option>
            <option value="menor200">Menor de 200</option>
            <option value="menor500">Menor a 500</option>
            <option value="mayor500">Mayor a 500</option>
        </select>
        <div class="espacio"></div>

    <div class="container ">
            <!-- ...Mostrar productos... -->

        <div class="container-fluid move_co">

                        <div v-if="products?.length > 0" class="productos">
                            <!-- ...contenido del producto... -->
                            <div class="producto" v-for="product in products" :key="product.id_product">
                                <div class=" d-flex justify-content-center">
                                    <img  :src="product.image" :alt="product.product_name" style="width: 200px; height: 200px;">
                                </div>
                                <div>
                                    <h3>{{ product.product_name }}</h3>
                                </div>


                                    <h2>{{ product.description_product }}</h2> 
                                    <h2>{{ product.product_brand.name_product_brand }} - {{ product.component.compo_type }}</h2>
                                    <p>{{ product.price }}$</p>
                                    <p>{{ product.quantity }} disponibles</p>
                                    
                                    <div class="d-flex justify-content-center">
                                        <button @click="addToCart(product)" :disabled="product.quantity <= 0" class="bg_vio">Agregar al carrito</button>
                                    </div>

                            </div>
                        </div>

                        <div v-else class="no-products-message">
                            <h1>No hay productos disponibles.</h1>
                        </div>
        </div>
            <!-- paginacion -->
            <div class=" d-flex justify-content-center">
                    <ul class="pagination">
                    <li v-for="pageNumber in lastPage" :key="pageNumber">
                        <button class="btn btn-primary bg_vio" @click="fetchPage(pageNumber)" :class="{ active: pageNumber === currentPage }">{{ pageNumber }}</button>
                    </li>
                    </ul>
                </div>

            <!-- ...Carrito... -->

            <div class="carrito">
                <div>
                <h2>Carrito de compras</h2>
                {{ message }}
                <ul>
                    <li v-for="product in cart" :key="product.id">
                    {{ product.product_name }} - {{ product.price }} - {{ product.count }}
                    </li>
                <button @click="clearCart" class="bg_vio">Vaciar carrito</button>
                <button @click="confirmSelection" class="bg_vio">Confirmar</button>
                </ul>
                </div>
            </div>
    </div>

</div>


</template>
<script>
import { mapActions, mapState } from 'vuex';
export default {
    props: ['message'],
    computed: {
    ...mapState('products', ['products','cart','currentPage', 'lastPage']), // Mapea el estado 'products' del módulo 'products'
    // errorMessage() {
    //   return this.$route.params.message;
    // }
},
  methods: {
    ...mapActions('products', ['fetchProducts','addToCart','clearCart']), // Mapea la acción 'fetchProducts' del módulo 'products'
    fetchPage(page) {
      this.fetchProducts(page);
    },
    //agregar metodo para mandar los productos de carrito
    confirmSelection(){
        if(this.cart.length){
            return this.$router.push('/ver_compra');
        } else {
    // Mostrar un mensaje en la página actual
    alert('El carrito está vacío. No se puede proceder a la compra.');
  }
    }
  },
  created() {
    this.fetchProducts(); // Llama a la acción 'fetchProducts' para obtener los productos
  },

}
</script>


