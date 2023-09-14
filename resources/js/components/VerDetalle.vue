<template>
    <div>

    <h1>
       <a class="pt-2 pb-2 re_btn rounded mt-2 mb-2 ">Detalle de factura</a>
    </h1>

    <!-- Datos de la factura -->

    <div class="bg_blue_low">


    </div>
    <div class="container-fluid  rounded  ">
      <div class="row   ml-5">
          <div class="col-12 mt-4 mb-4">
            <h2>Factura #{{ factura.id_invoice }}</h2>
          </div>
          <div class="col-5">
            <p>Usuario: {{ factura.user.name }} {{ factura.user.lastname }}</p>
            <p>Método de pago: {{ factura.payment_method.payment_type }}</p>
          </div>
          <div class="col-7">
            <p>Fecha de creación: {{ factura.created_at }}</p>
          </div>
      </div>
    </div>

    <!-- Líneas de pedido -->
    <div class="container-fluid">
      <div class="rounded mt-4 bg_factu ml-5">
      <h3>Líneas de Pedido</h3>
          <table class="table">
                  <thead>
                      <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Precio Unitario</th>
                        <th scope="col">Precio Total</th>
                      </tr>
                </thead>
                <!-- linea de productos -->
                <tbody >
                  <tr  v-for="linea in factura.order_lines" :key="linea.id_order_line">
                    <td >
                      {{ linea.product.product_name }}
                    </td>
                    <td >
                     <a class="m-5 no_events color_b"> {{ linea.quantity }} </a>
                    </td>
                    <td >
                      <a class="m-5 no_events color_b"> {{ linea.price_unit }} </a>
                    </td>
                    <td >
                      <a class="m-5 no_events color_b">
                        {{ linea.price_total }}
                      </a>
                    </td>
                  </tr>
                </tbody>
          </table>
    </div>
    </div>
    <!-- totales -->
    <div class="container-fluid  ">
      <div class="d-flex justify-content-end mr-5 ">
        <p  >Total de la compra:
          <a class="negrilla no_events color_b">
            {{ factura.amount_total }}
          </a>
        </p>
      </div>

    </div>
  </div>

  </template>

  <script>
  import { mapState, mapActions } from 'vuex';

  export default {
    computed: {
      ...mapState('factura', ['invoice_details']),
      invoiceId() {
        // Obtener el ID de la factura de la ruta o de donde sea que lo hayas almacenado
        return this.$route.params.id_invoice;
      },
      factura() {
    // Retornar los detalles de la factura
    return this.invoice_details;
  }
    },
    methods: {
      ...mapActions('factura', ['getInvoiceDetails']),
    },
    created() {
      // Obtener los detalles de la factura al cargar el componente
      this.getInvoiceDetails(this.invoiceId);
    }
  };
  </script>
