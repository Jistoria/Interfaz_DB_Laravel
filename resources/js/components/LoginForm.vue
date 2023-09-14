<template>
    <title>Login</title>
    <div>
      <h1 >
       <a class="pt-2 pb-2 re_btn rounded mt-2 mb-2 ">Iniciar sesion</a>
      </h1>






  <form @submit.prevent="submitLoginForm"  method="post" class="regi">
    <label for="email">Correo electrónico:</label>
    <input type="email" v-model="credentials.email">

    <label for="contrasena">Contraseña:</label>
    <input type="password" v-model="credentials.password">

    <div class=" d-flex justify-content-center">
      <input type="submit"  value="Iniciar sesión">
    </div>

    <div v-if="modalOpen" class="modal_prueba">

          <div class="modal_content_prueba">
            <span class="close_prueba" @click="closeModal2">&times;</span>
            <b>Error al iniciar sesion:</b>
            <ul class="errores">
              {{ error }}
            </ul>
          </div>
  
    </div>


    <div class="registrarse">
      ¿No tienes cuenta? <RouterLink to="/registro">Regístrate aquí</RouterLink>
    </div>

  </form>




  <div class="container_robo">
    <img src="img/robo1.png" width="500" height="400" class="robo_admi " alt="log" >
    <div class="boto_admi "><button class="pt-2 pb-2 re_btn_admi rounded mt-2 mb-2" @click="openModal">
      <p>Eres</p>
      <a>administrador?</a>
    </button></div>
  </div>



  </div>
  
  <ul class="base" id="modal" style="display: none;" >
          <b class=" identif">Identifiquese</b>
                <form class="admin_mo" @submit.prevent="Identificacion"  method="post">
                        <div v-if="typeUser">{{ typeUser.message }}</div>
                    <label for="contrasena">Contraseña:</label>
                    <input type="password" v-model="identify.password_rol">
                    <input type="submit" value="Iniciar sesión">
                 </form>
          <button @click="closeModal()" class="button1 mt-3">Cerrar</button>
        </ul>
</template>

<script>
   let modalVisible = false;
import {mapActions} from 'vuex';
export default{
    data() {
  return {
    modalOpen: false,
    error: '',
    credentials:{
        email:'',
        password:'',
    },
    identify:{
        password_rol: '',
    },
    typeUser:'',


 }
},

methods:{
    ...mapActions( 'auth', ['login']), // Mapea la acción 'login' del módulo 'auth' en Vuex
    ...mapActions( 'admin', ['password_type']),
    submitLoginForm() {
    this.login(this.credentials) // Utiliza this.login en lugar de this.$store.dispatch('auth/login')
      .then(() => {
        // Redireccionar a la página principal después del inicio de sesión exitoso
        this.$router.push('/');
      })
      .catch(error => {
        // Manejar el error de inicio de sesión
        this.error = error.response.data.message;
        console.log(error);
        this.openModal2();
      });
  },


openModal() {
  modalVisible = true;
  var modal = document.getElementById("modal");
  modal.style.display = "block";
},

closeModal() {
  modalVisible = false;
  var modal = document.getElementById("modal");
  modal.style.display = "none";
},

openModal2(){
      this.modalOpen = true;
      console.log('modal abierto');
},
    closeModal2(){
      this.modalOpen = false;
      
},

Identificacion(){
    this.password_type(this.identify).then(type_user => {
        this.typeUser = type_user
        console.log(this.typeUser);
      // Redireccionar a la página principal con el type_user_id como parámetro
      if(this.typeUser.success){
        const user_type = this.typeUser.type_admin.user_rol;
        const user_type_id = this.typeUser.type_admin.id_admin_type;
        const user_type_password_rol = this.typeUser.type_admin.password_rol;

        console.log(  user_type_id );
        this.$router.push({ path: 'admin-login', query: { user_type, user_type_id, user_type_password_rol } });
      }
      })
}

}


}


</script>
