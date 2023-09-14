<template>
    <div class="form_admi_compo">
        <h1>
          <a class="pt-2 pb-2 re_btn rounded mt-2 mb-2">Panel de Marcas y Componentes</a>
        </h1>
        <div class="d-flex justify-content-around mt-5 mb-5 ">
            <button @click="mostrar_brand()" class=" re_btn_admi">Ver Marcas</button>
            <button @click="form_agregarbc()" class="re_btn_admi">Agregar Marca/Component</button>
            <button @click="mostrar_compo()" class=" re_btn_admi">Ver Componentes</button>  
        </div>

        <div v-if="agregarbc" >

            <form  @submit.prevent="addBrand" class="el_mar">
            <h3>Agregar Marca</h3>
            <label for="brandName">Nombre de la Marca:</label>
            <input class="el_inp" type="text" v-model="newBrand.name_product_brand">
            <input class="el_inp" type="text" v-model="newBrand.descrip">

            <button type="submit" class="re_btn_admi" >Agregar</button>
            </form>

            <!-- Formulario para agregar un componente -->
            <form class="el_form" @submit.prevent="addComponent">
            <h3>Agregar Componente</h3>
            <label for="componentName">Nombre del Componente:</label>
            <input class="el_inp" type="text" v-model="newComponent.compo_type">
            <input class="el_inp" type="text" v-model="newComponent.compo_descrip">
            <button type="submit" class="re_btn_admi" >Agregar</button>
            </form>


        </div>





        <div v-if="istable_brand" class="li_pro ">
            <li  v-for="brand in marcas" :key="brand.id_product_brand">
                <div class="container-fluid d-flex justify-content-between mt-1">
                    <a class="re_btn rounded pt-3 pb-3">
                      {{ brand.id_product_brand }}
                    </a>
                    <div class="bg-white  flex-fill pt-3 pb-3">
                      <a class="art_move_end">
                      {{ brand.name_product_brand }}
                      {{ brand.descrip }}
                      </a>
                    </div>

                          <button
                        class="re_btn_admi"
                        @click="showMoreData(brand)">
                        Productos Relacionados
                        </button>


                </div>


                <div v-if="brand.showMore">
                    <div v-if="brand.productos.length <=0"><h5>No tiene productos esta marca</h5></div>
                    <ul v-else class="">
                        <li  v-for="product in brand.productos" :key="product.id_product_brand">
                         
                         <div class="bg-white d-inline-flex pt-4 pb-4 sep_in rounded border_b">
                            <a> 
                                {{ product.product_names }} 
                            </a>  
                         </div> 

                        
            
                        </li>
                    </ul>
                </div>
            </li>

    </div>
    <div v-if="istable_compo" >
        <li class="li_pro" v-for="compo in componentes" :key="compo.id_component">


              <div class="container-fluid d-flex justify-content-between mt-1">
                <a class="re_btn rounded pt-3 pb-3">
                  {{ compo.id_component }}
                </a>
                <div class="bg-white  flex-fill pt-3 pb-3">
                      <a class="art_move_end">
                        {{  compo.compo_type }}
                        {{ compo.compo_descrip }}
                      </a>
                </div>
                <button @click="showMoreData(compo)" class="re_btn_admi ">
                  Productos Relacionados
                </button>

              </div>

                <div v-if="compo.showMore">
                    <div v-if="compo.productos.length <=0"><h5>No tiene productos este componente</h5></div>
                    <ul v-else>
                        <li v-for="product in compo.productos" :key="product.id_component">
                        <div class="bg-white d-inline-flex pt-4 pb-4 sep_in rounded border_b">
                            <a> 
                                {{ product.product_names }} 
                            </a>  
                         </div> 

                        </li>
                    </ul>






                </div>
            </li>
    </div>

    </div>

</template>
<script>
   import { mapActions, mapState } from 'vuex';

export default {
    data(){
        return{
            newBrand:{
                name_product_brand:'',
                descrip:'',

            },
            newComponent:{
                compo_type:'',
                compo_descrip:'',
          },
          agregarbc: true,
          istable_brand: false,
          istable_compo: false,
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.getAdmin();
        console.log(this.type_user);
        this.table_brand();
        this.table_compo();

    },

computed: {
  ...mapState('admin', ['admin','type_user']),
  ...mapState('marca',['marcas']),
  ...mapState('component',['componentes']),

},
methods: {
  ...mapActions('admin', ['getAdmin', 'logout_admin']),
  ...mapActions('marca',['table_brand','createBrand']),
  ...mapActions('component',['table_compo','createCompo']),
  addBrand() {
      // Lógica para agregar una marca
      // Utiliza this.brandName para acceder al nombre de la marca ingresado
      // Realiza las acciones necesarias para agregar la marca
      this.createBrand(this.newBrand)
      .then(response => {
        console.log(response);
      })
      .catch(error => {
        console.error(error);
      });

      // Luego, puedes limpiar el campo de nombre de marca
      this.newBrand = '';
    },
    addComponent() {
      // Lógica para agregar un componente
      // Utiliza this.componentName para acceder al nombre del componente ingresado
      // Realiza las acciones necesarias para agregar el componente
      this.createCompo(this.newComponent)
      .then(response => {
        console.log(response);
      })
      .catch(error => {
        console.error(error);
      });

      // Luego, puedes limpiar el campo de nombre de marca
      this.newComponent = '';
    },
    mostrar_brand(){
        this.istable_brand = true;
        this.agregarbc = false;
        this.istable_compo =false;
    },
    form_agregarbc(){
        this.istable_brand = false;
         this.agregarbc = true;
         this.istable_compo = false;
    },
    mostrar_compo(){
        this.istable_brand = false;
         this.agregarbc = false;
         this.istable_compo = true;
    },
    showMoreData(brand) {
    brand.showMore = !brand.showMore; // Alternar el valor de la propiedad showMore
  },
},



};
</script>
