<template>
<div>
    <h1>
      <a class="pt-2 pb-2 re_btn rounded mt-5 mb-5">   {{ admin?.username }} - {{ admin?.type_admin.user_rol }}</a>
    </h1>
</div>
<div class="agregar-producto">
      <div class=" mx-auto mt-4 mb-4" >
              <div class="mx-auto pt-2 pb-2 re_btn rounded" style="width: 350px;">
                <h2>Agregar Producto </h2>
              </div>
      </div>



        <form method="post"  @submit.prevent="guardar_product">
          <label for="nombre">Nombre:</label>
                <input type="text" v-model="a_product.product_name" name="nombre" >
            <label for="precio">Precio:</label>
                <input type="number" v-model="a_product.price" name="precio" >
                <br>
                <label for="cantidad">cantidad:</label>
                <input type="number" v-model="a_product.quantity" name="cantidad" >
                <br>
                <label for="descripcion">Descripción:</label>
                <textarea v-model="a_product.description_product" name="descripcion" rows="4" cols="30"></textarea>
                <br>
                <label for="imagen">Imagen:</label>
                <input type="text" v-model="a_product.image" name="imagen">
                <label for="marca">Marca:</label>
                    <select v-model="a_product.id_product_brand" name="marca">
                    <option v-for="marca in marcas" :value="marca.id_product_brand">{{ marca.name_product_brand }}</option>
                    </select>
                <label for="componente">Componente:</label>
                    <select v-model="a_product.id_component" name="componente">
                    <option v-for="component in componentes" :value="component.id_component">{{ component.compo_type }}</option>
                    </select>
                    <button type="submit" class="button1">Guardar</button>
        </form >
      </div>

</template>
<script>
 import { mapActions, mapState } from 'vuex';

export default {
    data(){
        return{
          a_product:{
            product_name :'',
            description_product:'',
            image:'',
            price:'',
            quantity:'',
            id_product_brand:'',
            id_component:''
          }
        }
    },
    mounted() {
        console.log('Component mounted.')
        this.getAdmin();
        console.log(this.admin);
        this.get_marca();
        this.get_compo();
        console.log(this.componentes);

    },

computed: {
  ...mapState('admin', ['admin']),
  ...mapState('marca',['marcas']),
  ...mapState('component',['componentes']),
},
methods: {
  ...mapActions('admin', ['getAdmin', 'logout_admin']),
  ...mapActions('marca',['get_marca']),
  ...mapActions('component',['get_compo']),
  ...mapActions('products',['createProduct']),

  guardar_product(){
    this.createProduct(this.a_product)
      .then(() => {

      })
      .catch(error => {
        console.error(error);
      });
  }
},


};

</script>
<style>
@import "../../css/style.css";
</style>
