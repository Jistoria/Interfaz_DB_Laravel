import { createStore } from 'vuex';
import axios from 'axios';
//module de user
const authModule = {
    namespaced: true,
    state: {
      isAuthenticated: false,
      user: null,
      invoice_user:null
    },
    mutations: {
      SET_AUTHENTICATED(state, value) {
        state.isAuthenticated = value;
      },
      SET_USER(state, user) {
        state.user = user;
      },
      SET_INVOICE_USER(state, invoice_user){
        state.invoice_user = invoice_user
      }
    },
    actions: {
      login({ commit }, credentials) {
        return new Promise((resolve, reject) => {
          axios.post('/login', credentials)
            .then(response => {
              const authenticatedUser = response.data.user;
              commit('SET_AUTHENTICATED', true);
              commit('SET_USER', authenticatedUser);
              resolve(); // Resuelve la promesa sin pasar ningún valor
            })
            .catch(error => {
              reject(error); // Rechaza la promesa con el error recibido
            });
        });
      },
      async getUserData({ commit }) {
        try {
          const response = await axios.get('/user'); // Ruta de tu API para obtener los datos del usuario
          const user = response.data;
          console.log(user);
          commit('SET_USER', user);
        } catch (error) {
            console.log('No hay Sesion');
          // Manejo de errores
        }
      },
      async getInvoiceData({ commit },id) {
        try {
          const response = await axios.get(`/invoice_user/${id}`); // Ruta de tu API para obtener los datos del usuario
          const invoice_user = response.data;
          console.log(invoice_user);
          commit('SET_INVOICE_USER', invoice_user);
        } catch (error) {
            console.log('No hay Sesion');
          // Manejo de errores
        }
      },
      logout({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get('/logout')
              .then(response => {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', null);
                resolve();
              })
              .catch(error =>{

              });})
      },
    },
    getters: {
      isAuthenticated: state => state.isAuthenticated,
      user: state => state.user,
    },
  };

//Module de productos
const productModule = {
  namespaced: true,
  state: {
    products: [], // Estado para almacenar los productos
    cart: [], // Estado para almacenar los productos en el carrito
    currentPage: 1, // Estado para almacenar el número de página actual
    lastPage: 1, //estado para almacenar la ultima pagina actual
    invoice_all: null
  },
  mutations: {
    SET_PRODUCTS(state, payload) {
        state.products = payload.products;
        state.currentPage = payload.currentPage;
        state.lastPage = payload.lastPage;
    },
    ADD_TO_CART(state, product) {
      state.cart.push(product);
    },
    CLEAR_CART(state) {
      state.cart = [];
    },
    SET_ALL_INVOICE(state, invoice_all){
        state.invoice_all = invoice_all;
    },
  },
  actions: {
    fetchProducts({ commit, state },page) {
        page = page !== undefined ? page : state.currentPage; // Utiliza la página actual si no se proporciona una nueva página
        return new Promise((resolve, reject) => {
          axios.get('/products?page=' + page)
            .then(response => {
              const products = response.data.data;
              const currentPage = response.data.current_page;
              const lastPage = response.data.last_page;
              //se debe declarar de donde proviene de cada objeto
              commit('SET_PRODUCTS',{ products: products, currentPage: currentPage, lastPage: lastPage } );
              console.log(products);
              resolve();
            })
            .catch(error => {
              reject(error);
            });
        });
      },
    //   getinvoice_all
      async getProductsList({ commit }) {
        try {
          const response = await axios.get('/products_list');
          const products = response.data.products;
          commit('SET_PRODUCTS', {products: products});
          console.log(products);
        } catch (error) {
          console.error(error);
        }
      },
      async getInvoiceAll({ commit }) {
        try {
          const response = await axios.get('/getinvoice_all');
          const invoice_all = response.data;
          commit('SET_ALL_INVOICE', invoice_all);
          console.log(invoice_all);
        } catch (error) {
          console.error(error);
        }
      },
    addToCart({ commit, state }, product) {
        //busco si existe el producto en cart
        const existingProduct = state.cart.find((item) => item.id_product === product.id_product);
        if (existingProduct) {
            //si existe primero se actualiza el state de producto
            const updatedProduct = state.products.find((item) => item.id_product === product.id_product);
            if (updatedProduct) {
                updatedProduct.quantity--;
            }
            // Si el producto ya está en el carrito, incrementar el contador
            existingProduct.count++;
            existingProduct.quantity--;
            console.log(existingProduct.count);

            // Actualizar la quantity del producto en el estado 'products'

          } else{
             // Actualizar la quantity del producto en el estado 'products'
             const updatedProduct = state.products.find((item) => item.id_product === product.id_product);
             if (updatedProduct) {
                 updatedProduct.quantity--;
             }
             //luego se añade un count al cart porque hereda todo product y este no tiene un count
             const newProduct = { ...product, count: 1 };
             commit('ADD_TO_CART', newProduct);
             console.log(state.cart);
          }
    },
        clearCart({ commit, state }) {
            state.cart.forEach((product) => {
                const originalProduct = state.products.find((item) => item.id_product === product.id_product);
                if (originalProduct) {
                originalProduct.quantity += product.count;
                }
            }),
        commit('CLEAR_CART');
        },
        createProduct({ commit }, a_product) {
            // Realizar una petición HTTP POST para guardar el producto en la base de datos
            axios.post('/create_product', a_product)
            .then(response => {
                // La petición fue exitosa, puedes hacer commit para actualizar el state si es necesario
                console.log(response.data);
            })
            .catch(error => {
                // Hubo un error en la petición, puedes manejar el error aquí
                console.error(error);
            });
        },
      updateProduct({ commit }, product) {
        console.log(product);
        return new Promise((resolve, reject) => {
          axios.put(`/products/${product.id}`, product.product)
            .then(response => {
              // La petición de actualización fue exitosa, puedes hacer commit para actualizar el state si es necesario
              console.log(response.data);
              resolve();
            })
            .catch(error => {
              // Hubo un error en la petición, puedes manejar el error aquí
              console.error(error);
              reject(error);
            });
        });
      },


    },
  getters: {
    getProducts: state => state.products,
    getCart: state => state.cart,
    getCurrentPage: state => state.currentPage,
    getLastPage: state => state.lastPage,
  },
};
 //Module de Admin
const userAdminModule = {
    namespaced: true,
    state: {
      type_user: null,
      admin: null,
      users_all: null,
    },
    mutations: {
        SET_USER_ADMIN(state, admin) {
            state.admin = admin;
          },
        SET_TYPE_ADMIN(state, type_user) {
            state.type_user = type_user;
          },
          SET_ALL_USERS(state, users_all) {
            state.users_all = users_all;
          },
    },
    actions: {
        //funciones para traer datos
        async getAdmin({ commit }) {
            try {
              const response = await axios.get('/get_admin'); // obtener la información del administrador
              const admin = response.data?.admin;
              const type_admin = response.data.admin?.type_admin;
              commit('SET_USER_ADMIN', admin);
              commit('SET_TYPE_ADMIN', type_admin);
            } catch (error) {
              console.error(error);
            }
          },
          async getUsers_All({ commit }) {
            try {
              const response = await axios.get('/getuser_all'); //obtener la información de los usuarios
              const users_all = response.data;
              console.log(users_all);
              commit('SET_ALL_USERS', users_all);
            } catch (error) {
              console.error(error);
            }
          },
        //funciones de autenticacion
        login_admin({ commit, state }, credentials) {
            return new Promise((resolve, reject) => {
              axios.post('/login-admin', credentials)
                .then(response => {
                  const authenticatedUser = response.data.user;
                  console.log(response);
                  commit('SET_USER_ADMIN', authenticatedUser);
                  console.log();
                  resolve(response); // Resuelve la promesa sin pasar ningún valor
                })
                .catch(error => {
                  reject(error); // Rechaza la promesa con el error recibido
                });
            });
          },
          logout_admin({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/logout_admin')
                  .then(response => {
                    commit('SET_USER_ADMIN', null);
                    resolve();
                  })
                  .catch(error =>{

                  });})
          },
      password_type({ commit }, credentials) {
        // Aquí puedes verificar si las credenciales son válidas y generar el token
        console.log('si entra');
        return new Promise((resolve, reject) => {
            axios.post('/type_password', credentials)
              .then(response => {
                const type_user = response.data;
                console.log(type_user);
                commit('SET_TYPE_ADMIN', type_user);
                resolve(type_user); // Resuelve la promesa sin pasar ningún valor
              })
              .catch(error => {
                reject(error); // Rechaza la promesa con el error recibido
              });
          });
      },
    },
    getters: {

    },
  };

const marcaModule ={

    namespaced: true,
 state :{
    marcas: null
  },

  getters : {
    getMarca: state => state.marcas
  },

   actions :{
    createBrand({ commit }, newBrand) {
      // Aquí puedes realizar la lógica para crear una nueva marca en tu base de datos
      // Por ejemplo, hacer una petición HTTP a tu API
      console.log(newBrand);
      axios.post('/create_brand', newBrand)
      .then(response => {
          // La petición fue exitosa, puedes hacer commit para actualizar el state si es necesario
          console.log(response.data);
      })
      .catch(error => {
          // Hubo un error en la petición, puedes manejar el error aquí
          console.error(error);
      });
    //   // Una vez se haya creado la marca, puedes hacer commit para actualizar el state
    //   commit('SET_MARCA', newBrand);
    },
    deleteMarca({ commit }) {
      // Aquí puedes realizar la lógica para eliminar una marca de tu base de datos
      // Por ejemplo, hacer una petición HTTP a tu API
      // Una vez se haya eliminado la marca, puedes hacer commit para actualizar el state
      commit('SET_MARCA', null);
    },
    async table_brand({ commit }) {
        try {
          const response = await axios.get('/table_brand'); // usar get_admin del controller
          const marca = response.data;
          commit('SET_MARCA', marca);
          console.log(marca);
        } catch (error) {
          console.error(error);
        }
      },
    async get_marca({ commit }) {
            try {
              const response = await axios.get('/get_marca'); // usar get_admin del controller
              const marca = response.data;
              commit('SET_MARCA', marca);
              console.log(marca);
            } catch (error) {
              console.error(error);
            }
          },
  },

   mutations : {
    SET_MARCA(state, marcas) {
      state.marcas = marcas;
    }
  },

};
const componentModule ={

    namespaced: true,
 state :{
    componentes: null
  },

  getters : {
    getCompo: state => state.componentes
  },

   actions :{
    createCompo({ commit }, newComponent) {
      // Aquí puedes realizar la lógica para crear una nueva marca en tu base de datos
      // Por ejemplo, hacer una petición HTTP a tu API
      console.log(newComponent);
      axios.post('/create_compo', newComponent)
      .then(response => {
          // La petición fue exitosa, puedes hacer commit para actualizar el state si es necesario
          console.log(response.data);
      })
      .catch(error => {
          // Hubo un error en la petición, puedes manejar el error aquí
          console.error(error);
      });
    //   // Una vez se haya creado la marca, puedes hacer commit para actualizar el state
    //   commit('SET_COMPO', nuevaComponent);
    },
    async table_compo({ commit }) {
        try {
          const response = await axios.get('/table_compo'); // usar get_admin del controller
          const componentes = response.data;
          commit('SET_COMPO', componentes);
          console.log(componentes);
        } catch (error) {
          console.error(error);
        }
      },
    deleteCompo({ commit }) {
      // Aquí puedes realizar la lógica para eliminar una marca de tu base de datos
      // Por ejemplo, hacer una petición HTTP a tu API
      // Una vez se haya eliminado la marca, puedes hacer commit para actualizar el state
      commit('SET_COMPO', null);
    },
    async get_compo({ commit }) {
            try {
              const response = await axios.get('/get_compo'); // usar get_admin del controller
              const componentes = response.data;
              commit('SET_COMPO', componentes);
              console.log(componentes);
            } catch (error) {
              console.error(error);
            }
          },
  },

   mutations : {
    SET_COMPO(state, componentes) {
      state.componentes = componentes;
    }
  },

};
const facturaModule = {
    namespaced: true,
    state: {
      metodoDePago: '', // Estado para el método de pago
      invoice_details:'',
    },
    getters: {
      getMetodoDePago: state => state.metodoDePago, // Getter para obtener el método de pago
    },
    mutations: {
      SET_METODO_DE_PAGO(state, metodoDePago) {
        state.metodoDePago = metodoDePago; // Mutación para actualizar el método de pago
      },
      SET_INVOICE_DETAILS(state, invoice_details){
        state.invoice_details = invoice_details
      }
    },
    actions: {
      setMetodoDePago({ commit }, metodoDePago) {
        return new Promise((resolve, reject) => {
            axios.get('/get_methodop')
              .then(response => {
                const methodp = response.data;
                //se debe declarar de donde proviene de cada objeto
                commit('SET_METODO_DE_PAGO', methodp); // Acción para establecer el método de pago
                console.log(methodp);
                resolve();
              })
              .catch(error => {
                reject(error);
              });
          });
      },
      finalizarcompra({ commit }, factura) {
        console.log(factura.factura);
        return new Promise((resolve, reject) => {
            axios.post(`/finalizar_compra/${factura.factura.user}/${factura.factura.methodp_id}`,factura.factura.item)
              .then(response => {
                const methodp = response.data;
                console.log(methodp);
                resolve();
              })
              .catch(error => {
                reject(error);
              });
          });
      },
      async getInvoiceDetails({ commit }, id_invoice) {
        try {
          const response = await axios.get(`/detalle_factura/${id_invoice}`); // usar get_admin del controller
          const invoice_details = response.data;
          commit('SET_INVOICE_DETAILS', invoice_details);
          console.log(invoice_details);
        } catch (error) {
          console.error(error);
        }
      },

    },
  };






  export default createStore({
    modules: {
      auth: authModule,
      products: productModule,
      admin: userAdminModule,
      marca: marcaModule,
      component: componentModule,
      factura: facturaModule,
    },
  });
