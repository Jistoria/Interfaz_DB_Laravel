<template>
    <div>
        <h1>
          <a class="pt-2 pb-2 re_btn rounded mt-2 mb-2">{{ admin?.username }} - {{ type_user?.user_rol }} </a>
        </h1>
        <button @click="index_agregarp" class=" art_move re_btn_admi">Agregar Producto</button>
        <button @click="index_agregarmc" class="art_move re_btn_admi">Agregar Marca/Component</button>

    </div>

    <div v-if="products?.length" class="products-list">
      <h2>
        <a class="art_move re_btn">
          Lista de Productos
        </a>
      </h2>
      <!-- {{  }} -->

      <div class="container-fluid ">
        <div class="row ">
            <div class="col-auto ">
                    <li class=" d-flex justify-content-startli_pro mt-2" v-for="product in products" :key="product.id_product">
                      <img :src="product.image" :alt="product.product_name" style="width: 230px; height: 230px;">
                    </li>
            </div>
            <div class="col-10 mt-0">

              <ul class="li_pro mt-5 mb-5">
          <li class="" v-for="product in products" :key="product.id_product">
          <h3 class="mt-2 mb-2">
            <a class="pt-0 pb-0 re_btn rounded mt-2 mb-2 ">   {{ product.product_name }} </a>
          </h3>
          <div class="bg-white mb-2 rounded ">
            <div class="mt-2 mb-2">
              <a class="color_b no_events ">{{ product.description_product }}</a>
            </div>
            <div class="mt-2 mb-2">
              <a class="bg-white no_events">Precio:
                      <a class="color_b "> {{ product.price }} </a>
              </a>
            </div>

            <div class="mt-2 mb-2">
              <a class="bg-white no_events">Marca:
               <a class="color_b"> {{ product.product_brand.name_product_brand }} </a>
              </a>
            </div>
            <div class="mt-2 mb-2">
              <a class="bg-white no_events"> Componente:
              <a class="color_b">{{ product.component.compo_type }} </a>
            </a>
            </div>

          </div>


          <!-- <p class="bg-white">{{ product.description_product }}</p>
          <p class="bg-white">Precio: {{ product.price }}</p>
          <p class="bg-white">Marca: {{ product.product_brand.name_product_brand }}</p>
          <p>Componente: {{ product.component.compo_type }}</p> -->

          <button @click="editProduct(product)"
          class="re_btn_admi rounded">Editar</button>

      <div v-if="product.editing" class="">
          <input type="hidden" v-model="product.id_product" />
        <input type="text" v-model="product.product_name" />
        <input type="text" v-model="product.description_product" />
        <input type="text" v-model="product.price" />
        <input type="text" v-model="product.quantity" />

        <button @click="saveProduct(product)"
        class="re_btn_admi rounded mt-2"
        >Guardar</button>
        <button @click="cancelEdit(product)"
        class="re_btn_admi rounded mt-2"
        >Cancelar</button>
      </div>
          </li>

              </ul>
            </div>

        </div>

      </div>





    </div>


    <div v-else>
        <h1>No hay productos ñaño, nos vamos a la bancarota</h1>
    </div>


    </template>
    <script>
     import { mapActions, mapState } from 'vuex';

    export default {
        data(){
            return{
              product:{
                id_product:'',
                product_name :'',
                description_product:'',
                price:'',
                cantidad:'',
              }
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.getAdmin();
            console.log(this.type_user);
            this.get_marca();
            this.get_compo();
            this.getProductsList();
            console.log(this.products);

        },

    computed: {
      ...mapState('admin', ['admin','type_user']),
      ...mapState('marcas',['marcas']),
      ...mapState('component',['componentes']),
      ...mapState('products',['products']),
    },
    methods: {
      ...mapActions('admin', ['getAdmin', 'logout_admin']),
      ...mapActions('marca',['get_marca']),
      ...mapActions('component',['get_compo']),
      ...mapActions('products',['createProduct','getProductsList','updateProduct']),
      editProduct(product) {
    product.editing = true;
  },
  saveProduct(product) {
    // Lógica para guardar los cambios del producto
    this.updateProduct({ id: product.id_product, product: product })
    .finally(() => {
      product.editing = false;
    });
  },
  cancelEdit(product) {
    product.editing = false;
  },
  index_agregarp(){
    return this.$router.push('/create_product');
  },
  index_agregarmc(){
    console.log('nos vamos a crear marca y component');
    return this.$router.push('/agregar_mp');
  }
    },


    };

    </script>
    <style>
    @import "../../css/style.css";
    </style>
