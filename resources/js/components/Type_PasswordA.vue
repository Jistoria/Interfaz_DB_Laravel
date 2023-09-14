<template>
    <title>Identifiquese</title>
        <div >
        <h1>Ingrese Password</h1>
        <ul>
          {{ error }}
        </ul>
      <form @submit.prevent="submitLoginForm"  method="post">

        <label for="contrasena">Contraseña:</label>
        <input type="password" v-model="credentials.password_rol">

        <input type="submit" value="Iniciar sesión">

      </form>

      </div>
    </template>





<script>
import {mapActions} from 'vuex';
export default{
    data() {
  return {
    error: '',
    credentials:{
        password_rol:'',
    }

 }
},
methods:{
    ...mapActions( 'admin', ['login','password_type']), // Mapea la acción 'login' del módulo 'auth' en Vuex
  submitLoginForm() {
    this.password_type(this.credentials) // Utiliza this.login en lugar de this.$store.dispatch('auth/login')
    .then(type_user => {
        const typeUser = type_user
        console.log(typeUser);
      // Redireccionar a la página principal con el type_user_id como parámetro
      this.$router.push({ path: 'admin-login', query: { typeUser } });
      })
      .catch(error => {
        // Manejar el error de inicio de sesión
        console.error(error);
      });
  },


}
}
</script>
