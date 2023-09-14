<template>
    <title>Registro</title>
    <div>
      <h1 >
       <a class="pt-2 pb-2 re_btn rounded mt-2 mb-2">Registro del cliente</a>
      </h1>
   






      
      <p v-if="errors.length">
        <!-- Le quite el modal, me daba un error de con la class, a de ser porque el id, no se mijo arregle usted -->

      </p>
     <form   method="post" class="mt-5 mb-5">
      <label for="name">Nombre*:</label>
      <input type="text" v-model="name" >

      <label for="lastname">Apellido*:</label>
      <input type="text" v-model="lastname">

      <label for="email">Email*:</label>
      <input type="email" v-model="email">

      <label for="phone">Teléfono*:</label>
      <input type="tel" v-model="phone">

      <label for="phone2">Teléfono 2:</label>
      <input type="tel" v-model="phone2">

      <label for="address" autocomplete="off">Dirección*:</label>
      <input type="text" v-model="address">

      <label for="contrasena" autocomplete="off">Contraseña*:</label>
      <input type="password" v-model="password">
      <label for="contrasena">Repetir Contraseña*:</label>
      <input type="password" v-model="r_password">
      <p v-if="!passwordMatch" class="error">Las contraseñas no coinciden</p>

<form class=" d-flex justify-content-center" @submit.prevent="registerUser">
  <!-- Resto del formulario -->
  <input type="submit"  :disabled="!passwordMatch" value="registro">
  

  <div v-if="modalOpen" class="modal_prueba">
      <div class="modal_content_prueba">
        <span class="close_prueba" @click="closeModal2">&times;</span>
        <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
        <ul v-if="errors">
        <li class="errores" v-for="(error, field) in errors" :key="field">{{ error }}</li>
        </ul>

      </div>
    </div>


</form>

    </form>





    </div>
</template>
<script>
import { routerKey } from "vue-router";
import "/resources/js/modal.js";
import axios from 'axios';
import { onMounted } from "vue";
export default{
    data() {
      return {
        modalOpen: false,
        errors: [],
        name: '',
        lastname:'',
        email:'',
        phone:'',
        phone2:'',
        address:'',
        password:'',
        r_password:''
     }
    },
    computed: {
    passwordMatch() {
      return this.password === this.r_password;
    }
  },
    methods: {

    openModal2(){
      this.modalOpen = true;
      console.log('modal abierto');
    },
    closeModal2(){
      this.modalOpen = false;
      
    },
  registerUser() {
    this.errors = []; // Limpiar los errores existentes
    const formData = {
      name: this.name,
      lastname: this.lastname,
      email: this.email,
      phone: this.phone,
      phone2: this.phone2,
      address: this.address,
      password: this.password,
    };
    console.log(formData);

    axios.post('/registro', formData)
      .then(response => {
        // Procesar la respuesta del backend
        return this.$router.push('/login');
        // Realizar acciones adicionales según sea necesario, como mostrar un mensaje de éxito o redirigir a otra página
      })
      .catch(errors => {
        // Procesar los errores de la respuesta del backend
        const errorMessages = errors.response.data.errors;
        this.errors = Object.values(errorMessages).flat();
        console.log(this.errors);
        this.openModal2();

        
      });

  },


}

}

</script>

<script>

</script>

<style>
@import "../../css/style.css";
</style>

