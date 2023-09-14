<template>
    <div class="checkout form_admi_compo2">
      <h1 >
       <a class="pt-2 pb-2 re_btn rounded mt-2 mb-2 ">Finalizar compra</a>
      </h1>
      <div v-if="cart.length">
        <div class="container-fluid mt-5">
            <div class="row ">
                <div class="col-4 li_pro  ">
                  <div >
                      <li class="d-flex justify-content-end  mb-3" v-for="item in cart" :key="item.product_id">
                      <img :src="item.image" :alt="item.product_name" style="width: 230px; height: 230px;">
                    </li>
                  </div>
                </div>
                <div class="col-8">
                  <ul class="li_pro mt-5 mb-5">
                    <li class="mt-5 mb-5" v-for="({product_id, product_name, count, price }, index) in cart" :key="product_id">
                        <h3>{{ product_name }}</h3>
                        <p>Cantidad: {{ count }}</p>
                        <p>Precio Unitario: {{ price }}</p>
                      <p>Amount Unit: {{ amounts_unit[index] }}</p>
                    </li>
                    <h3>Total de la compra {{ amount_total }}</h3>
                    <label for="metodo_pago">Método de Pago:</label>
              <select v-model="methodp_id" name="metodo_pago">
                    <option v-for="methodp in metodoDePago" :value="methodp.id_method">{{ methodp.payment_type }}</option>
                  </select>
              <button
              class="re_btn_admi art_move_end"
               @click="comprar(cart, user.id_user, methodp_id)">Finalizar Compra</button>
                  </ul>
                </div>

            </div>
        </div>
      </div>
      <div v-else>
        <div class="container-fluid  " >
          <div >
           <div class="mx-auto  mt-5 " style="width: 180px;">
            <a> Compra realizada </a>
           </div>
           <div class=" mx-auto"   style="width: 400px;">
            <img src="img/robo_factu.png">
           </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { mapState, mapActions } from 'vuex';

  export default {
    data() {
      return {
        methodp_id: '',
        array_amount_unit:[],
      };
    },
    mounted() {
      this.setMetodoDePago();
      this.getUserData();
    },
    computed: {
      ...mapState('products', ['cart']),
      ...mapState('factura', ['metodoDePago']),
      ...mapState('auth', ['user']),
      amounts_unit(){
        let total = 0; // Variable para almacenar el total de los precios unitarios
        this.cart.forEach(product => {
            const unitPrice = product.price * product.count; // Calcula el precio total unitario del producto
            total = unitPrice; // Suma el precio total unitario al total
            this.array_amount_unit.push(total);
        });
        return this.array_amount_unit ;
     },
     amount_total(){
        let total = 0;
        this.amounts_unit.forEach(product =>{
            total += product ;
        })
        return total.toFixed(2);
     }
    },
    methods: {
      ...mapActions('factura', ['setMetodoDePago', 'finalizarcompra']),
      ...mapActions('auth', ['getUserData', 'logout']),
      ...mapActions('products', ['clearCart']),
      comprar(item, user, methodp_id) {
        const factura = {
          item,
          user,
          methodp_id,
        };
        console.log(factura);
        this.finalizarcompra({ factura: factura })
      .then(() => {
        this.clearCart(); // Limpiar el carrito después de finalizar la compra
      })
      .catch(error => {
        console.error(error);
      });
      },
    },
  };
  </script>

