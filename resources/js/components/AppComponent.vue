<template>

    <header>
        <div class="container-fluid ">
          <div class="row align-items-center">
            <div class="col-md-9">
              <div class="logo " >
                <img src="img/logo.png" alt="log" >
              </div>
            </div>
            <div class="col-md-3">
              <nav class="text-md-right"> </nav>
              <!-- se usa vue router -->
 <div v-if="user">
  <ul class="nav">
    <li class="nav-item">
      <RouterLink to="/" class="nav-link"> Welcome</RouterLink>
    </li>
    <li class="nav-item">
      <router-link to="/ver-articulos" class="nav-link">Ver Articulos</router-link>
    </li>
    <li class="nav-item">
      <a class="nav-link" @click="postlogout()">Cerrar Sesion</a>
    </li>
    <router-link to="/index_user">
      <h4 style="color: rgb(249, 249, 241);">
        ¡Bienvenido {{ user?.name }}!
      </h4>
    </router-link>
  </ul>
</div>
<div v-else-if="admin">
  <ul class="nav">
    <li class="nav-item">
      <RouterLink to="/admin" class="nav-link"> ADMIN</RouterLink>
    </li>
    <li class="nav-item">
      <router-link to="/ver-articulos" class="nav-link">Articulos</router-link>
    </li>
    <li class="nav-item">
      <router-link to="/modify_products" class="nav-link">Modificar Articulos</router-link>
    </li>
    <li class="nav-item">
      <a class="nav-link" @click="admin_logout">Cerrar Sesion</a>
    </li>
    <h4 style="color: rgb(249, 249, 241);">¡Bienvenido {{admin?.username}}!</h4>
  </ul>
</div>
<div v-else>
  <ul class="nav">
    <li class="nav-item">
      <router-link to="/" class="nav-link">Inicio</router-link>
    </li>
    <li class="nav-item">
      <router-link to="/login" class="nav-link">Login</router-link>
    </li>
    <li class="nav-item">
      <router-link to="/registro" class="nav-link">Registro</router-link>
    </li>
    <li class="nav-item">
      <router-link to="/ver-articulos" class="nav-link">Articulos</router-link>
    </li>
  </ul>
</div>

          </div>


            </div>
          </div>

     </header>

        <RouterView></RouterView>

</template>
<script>
 import { mapActions, mapState } from 'vuex';

export default {
    mounted() {
        console.log('Component mounted.')
        this.getUserData();
        this.getAdmin();


    },

computed: {
  ...mapState('auth', ['user']),
  ...mapState('admin', ['admin','type_admin']),
},
methods: {
  ...mapActions('auth', ['getUserData', 'logout']),
  ...mapActions('admin', ['getAdmin', 'logout_admin']),

  postlogout() {
    this.logout()
      .then(() => {
        this.$router.push('/'); // Redirigir al usuario a la ruta "/"
      })
      .catch(error => {
        console.error(error);
      });

  },
  admin_logout(){
    this.logout_admin()
      .then(() => {
        this.$router.push('/'); // Redirigir al usuario a la ruta "/"
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


