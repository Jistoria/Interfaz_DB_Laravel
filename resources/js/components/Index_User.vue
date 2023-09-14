<template>
    <div class="user-dashboard">
      <h2>Panel de Usuario</h2>
      <div class="user-buttons">
        <button @click="verDatosUsuario">Ver Datos de Usuario</button>
        <button @click="verFacturas(user.id_user)">Ver Facturas</button>
      </div>
      <!-- Contenido específico de cada vista -->
      <div v-if="mostrarDatosUsuario">
        <h3>Datos de Usuario</h3>
        {{ user }}
      </div>
      <div v-if="mostrarFacturas">
        <h3>Facturas del Usuario</h3>
        <ul>
            {{ invoice_user }}

        </ul>
      </div>
    </div>
  </template>

  <script>
  import { mapState, mapActions } from 'vuex';
  export default {
    data() {
      return {
        mostrarDatosUsuario: false,
        mostrarFacturas: false,
      };
    },
    computed: {
        ...mapState('auth', ['user','invoice_user']),

    },
    methods: {
        ...mapActions('auth', ['getUserData','getInvoiceData']),
      verDatosUsuario() {
        // Lógica para obtener los datos del usuario desde el backend o Vuex
        this.mostrarDatosUsuario = true;
        this.mostrarFacturas = false;
      },
      verFacturas(id_user) {
        // Lógica para obtener las facturas del usuario desde el backend o Vuex
        this.getInvoiceData(id_user);
        this.mostrarDatosUsuario = false;
        this.mostrarFacturas = true;
      },
    },
    mounted(){
        this.getUserData;
    }
  };
  </script>

  <style>
  .user-dashboard {
    text-align: center;
    margin-top: 50px;
  }

  .user-buttons {
    margin-top: 20px;
  }

  button {
    margin-right: 10px;
  }
  </style>
