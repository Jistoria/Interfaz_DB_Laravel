<template>
    <div class="  admin-dashboard">
      <h1 >
       <a class="pt-2 pb-2 re_btn rounded mt-2 mb-2">Panel de Administrador</a>
      </h1>

      <div class="admin-buttons">
        <button @click="verUsuarios" class="re_btn_admi rounded">Ver Usuarios</button>
        <button @click="verFacturas" class="re_btn_admi rounded">Ver Facturas</button>
      </div>

            <div v-if="mostrarUsuarios" class=" mt-4">
            <h3>
              <a class="re_btn rounded mt-2 mb-2">Usuarios</a>
            </h3>
              <div class=" d-flex justify-content-center">
                  <table >
                      <thead class="users">
                      <tr>
                          <th class="re_btn  sep_us border_b">ID</th>
                          <th class="re_btn  sep_us border_b">Nombre</th>
                          <th class="re_btn  sep_us border_b">Email</th>
                          <th class="re_btn sep_us border_b">Address</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr  v-for="user in users_all" :key="user.id_user">
                          <td class="bg-white border_b"  >{{ user.id_user }}</td>
                          <td class="bg-white border_b">{{ user.name }}</td>
                          <td class="bg-white border_b">{{ user.email }}</td>
                          <td class="bg-white border_b">{{ user.address }}</td>
                      </tr>
                      </tbody>
                  </table>
              </div>



             </div>

             <div v-if="mostrarFacturas" class="mt-4">
              <h3>
              <a class="re_btn rounded mt-2 mb-2">Facturas</a>
            </h3>
                <div class=" d-flex justify-content-center">


                  <table>
                    <thead>
                      <tr>
                        <th class="re_btn sep_in border_b">ID Factura</th>
                        <th class="re_btn sep_in border_b">Usuario</th>
                        <th class="re_btn sep_in border_b">Método de Pago</th>
                        <th class="re_btn sep_in border_b">Total de la Compra</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="invoice in invoice_all" :key="invoice.id_invoice">
                        <td class="bg-white border_b" ><a @click="redirectToInvoiceDetail(invoice.id_invoice)">{{ invoice.id_invoice }}</a></td>
                        <td class="bg-white border_b">{{ invoice.user.name }}</td>
                        <td class="bg-white border_b">{{ invoice.payment_method ? invoice.payment_method.payment_type : '-' }}</td>
                        <td class="bg-white border_b">{{ invoice.amount_total }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
          </div>
    </div>
  </template>

  <script>
  import { mapState, mapActions } from 'vuex';
  export default {
    data() {
      return {
        mostrarUsuarios: false,
        mostrarFacturas: false
      };
    },
    computed:{
        ...mapState('admin',['users_all']),
        ...mapState('products',['invoice_all'])
    },
    methods: {
        ...mapActions('admin',['getUsers_All']),
        ...mapActions('products',['getInvoiceAll']),
      verUsuarios() {
        this.getUsers_All();
        this.mostrarUsuarios = true;
        this.mostrarFacturas = false;
      },
      verFacturas() {
        this.getInvoiceAll();
        this.mostrarUsuarios = false;
        this.mostrarFacturas = true;
      },
      redirectToInvoiceDetail(invoiceId) {
      this.$router.push(`/detalle-factura/${invoiceId}`);
    }
    },
    // mounted(){

    // }
  };
  </script>

  <style>
  .admin-dashboard {
    text-align: center;
    margin-top: 50px;
  }

  .admin-buttons {
    margin-top: 20px;
  }

  button {
    margin-right: 10px;
  }
  </style>
