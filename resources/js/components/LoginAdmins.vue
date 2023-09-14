<template>
    <title>LoginAdmins</title>
    <div >

      <h1 >
       <a class="pt-2 pb-2 re_btn rounded mt-2 mb-2">Iniciar sesion - {{ typeUser }}</a>
      </h1>




  <form class="form_admi" @submit.prevent="submitLoginForm()"  method="post">
    <label for="username">Nombre de Usuario*</label>
    <input type="username" v-model="credentials.username">

    <label for="contrasena">Contraseña:*</label>
    <input type="password" v-model="credentials.password">
    <input type="hidden" v-model="credentials.id_admin_type">
    <div class=" d-flex justify-content-center">
      <input type="submit"   value="Iniciar sesión">
    </div>

  </form>

  <div v-if="modalOpen" class="modal_prueba">
      <div class="modal_content_prueba">
        <span class="close_prueba" @click="closeModal2">&times;</span>
        <b>Por favor, corrija el(los) siguiente(s) error(es):</b>
        <ul v-if="errors">
        <li class="errores" v-for="(error, field) in errors" :key="field">{{ error }}</li>
        </ul>
        <li v-else>{{ incorrect }}</li>
      </div>
  </div>



<!-- :disabled="errors" -->




  </div>

</template>
<script>
import {mapActions, mapState} from 'vuex';


export default{
    data() {
  return {
    modalOpen: false,
    errors: '',
    credentials:{
        username:'',
        password:'',
        id_admin_type:'',
        password_rol:'',
    },
    incorrect:'',

 }
},
computed:{
    ...mapState('admin', ['type_user']),
    noerror() {
      return this.errors;
    }

},

methods:{
    ...mapActions( 'admin', ['login_admin']), // Mapea la acción 'login' del módulo 'auth' en Vuex
  submitLoginForm() {
    this.login_admin(this.credentials) // Utiliza this.login en lugar de this.$store.dispatch('auth/login')
      .then(response => {
        // Redireccionar a la página principal después del inicio de sesión exitoso
        const verificador = response.data.success;
        console.log(verificador);
        if(verificador){
            return this.$router.push('/');
        }
         const message = response.data.message;
         console.log(message)
         this.incorrect = message;;
         this.openModal2();
      })
      .catch(error => {

         //Manejar el error de inicio de sesión
         const errorMessages = error.response.data.errors;
         this.errors = Object.values(errorMessages).flat();
        console.log(this.errors);
        this.openModal2();

      });


},

 openModal2(){
      this.modalOpen = true;
      console.log('modal abierto');
},
    closeModal2(){
      this.modalOpen = false;

},



},
created() {
    // Obtener el typeUserId del query de la URL
    this.typeUser=this.$route.query.user_type;
    this.credentials.id_admin_type=this.$route.query.user_type_id;
    this.credentials.password_rol=this.$route.query.user_type_password_rol;
    console.log(this.credentials.id_admin_type);
  },

}

</script>
