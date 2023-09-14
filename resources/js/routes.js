import { createRouter, createWebHistory } from 'vue-router';

import store from '../js/store';
import axios from 'axios';
const isAdminRoute = async (to, from, next) => {
    try {
      const response = await axios.get('/user');
      const user = response.data;
      if (user && user.admin) {
        // El usuario está autenticado y es administrador, permite el acceso a la ruta
        next();
      } else {
        // El usuario no está autenticado o no es administrador, redirige a otra página o muestra un mensaje de error
        next('/'); // Redirige a la página principal en este caso
      }
    } catch (error) {
      console.error(error);
      next('/');
    }
  };


// Creación de rutas
const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('./Components/WelcomeComponent.vue'),
  },
  {
    path: '/ver-articulos',
    name: 'Articulos',
    component: () => import('./Components/VerArticulos.vue'),
    props: true
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('./Components/LoginForm.vue'),
    beforeEnter: (to, from, next) => {
      const user = store.state.auth.user;
      const admin = store.state.admin.admin;

      if (user || admin) {
        // El usuario está autenticado, redirige a la página principal
        next('/');
      } else {
        // El usuario no está autenticado, permite el acceso a la ruta
        next();
      }
    },
  },
  {
    path: '/registro',
    name: 'Registro',
    component: () => import('./Components/RegisterForm.vue'),
    beforeEnter: (to, from, next) => {
      const user = store.state.auth.user;
      const admin = store.state.admin.admin;

      if (user || admin) {
        // El usuario está autenticado, redirige a la página principal
        next('/');
      } else {
        // El usuario no está autenticado, permite el acceso a la ruta
        next();
      }
    },
  },
  {
    path: '/admin-login',
    name: 'admin-login',
    component: () => import('./Components/LoginAdmins.vue'),
    beforeEnter: (to, from, next) => {
      const user = store.state.auth.user;
      const type_user = store.state.admin.type_user;
      const admin = store.state.admin.admin;

      if (user || admin) {
        // El usuario está autenticado, redirige a la página principal
        next('/');
      } else if (type_user !== null) {
        // El usuario no está autenticado, pero el tipo de usuario está definido
        next();
      } else {
        // El usuario no está autenticado y no se ha definido el tipo de usuario, redirige a otra página o muestra un mensaje de error
        next('/'); // Redirige a otra página, por ejemplo, la página de inicio de sesión normal
        // También puedes mostrar un mensaje de error o redireccionar a otra página de acuerdo a tu lógica de negocio
      }
    },
  },


  {
    path: '/type_password',
    name: 'type_password',
    component: () => import('./Components/Type_PasswordA.vue'),
    beforeEnter: (to, from, next) => {
      const user = store.state.auth.user;
      if (user) {
        // El usuario está autenticado, redirige a la página principal
        next('/');
      } else {
        // El usuario no está autenticado, permite el acceso a la ruta
        next();
      }
    },
  },
  {
    path: '/create_product',
    name: 'Create_Product',
    component: () => import('./Components/CreateProduct.vue'),
    beforeEnter: (to, from, next) => {
      const admin = store.state.admin;
      if (admin) {
        // El administrador está autenticado, permite el acceso a la ruta
        next();
      } else {
        // El administrador no está autenticado, redirige a otra página
        next('/'); // Puedes redirigir a la página de inicio de sesión o a otra página adecuada
      }
    },
  },
  {
    path: '/modify_products',
    name: 'Modificar_Products',
    component: function () {
      return import('./Components/ModificarProducts.vue');
    },
    beforeEnter: (to, from, next) => {
      const admin = store.state.admin;
      if (admin) {
        // El administrador está autenticado, permite el acceso a la ruta
        next();
      } else {
        // El administrador no está autenticado, redirige a otra página
        next('/'); // Puedes redirigir a la página de inicio de sesión o a otra página adecuada
      }
    },
  },
  {
    path: '/agregar_mp',
    name: 'Agg_M_P',
    component: function () {
      return import('./Components/AggMP.vue');
    },
    beforeEnter: (to, from, next) => {
      const admin = store.state.admin;
      if (admin) {
        // El administrador está autenticado, permite el acceso a la ruta
        next();
      } else {
        // El administrador no está autenticado, redirige a otra página
        next('/'); // Puedes redirigir a la página de inicio de sesión o a otra página adecuada
      }
    },
  },


  {
    path: '/ver_compra',
    name: 'Finalizar Compra',
    component: function () {
        return import('./Components/VerCompra.vue');
      },
    beforeEnter: (to, from, next) => {
        const user = store.state.auth.user;
        if (user) {
          // El usuario está autenticado, redirige a la página principal
          next();
        } else {
          // El usuario no está autenticado, permite el acceso a la ruta
          next({params: { message: 'No se puede realizar la compra sin iniciar sesión' } });
        }
      },
  },
  {
    path: '/detalle-factura/:id_invoice',
    name: 'DetalleFactura',
    component:function () {
        return import('./Components/VerDetalle.vue');
      },
    props: true
  },
  {
    path: '/admin',
    name: 'Admin',
    component: () => import('./Components/View_Admin.vue'),
    beforeEnter: (to, from, next) => {
        const admin = store.state.admin;
        if (admin) {
          // El administrador está autenticado, permite el acceso a la ruta
          next();
        } else {
          // El administrador no está autenticado, redirige a otra página
          next('/'); // Puedes redirigir a la página de inicio de sesión o a otra página adecuada
        }
    } ,
  },

  {
    path: '/index_user',
    name:'index_user',
    component: () => import('./Components/Index_User.vue'),
    beforeEnter: (to, from, next) => {
        const user = store.state.auth.user;
        if (user) {
          // El usuario está autenticado, redirige a la página principal
          next();
        } else {
          // El usuario no está autenticado, permite el acceso a la ruta

        }
      },
  },
//   {
//     path: '/logout',
//     component: Home,
//   },
//   {
//     path: '/admin',
//     name: 'Admin',
//     component: () => import('./Components/Admin-user.vue'),
//     beforeEnter: isAdminRoute,
//   },
//   {
//     path: '/admin/crear_critica',
//     name: 'Crear-Critica',
//     component: () => import('./Components/Crear-critica.vue'),
//     beforeEnter: isAdminRoute,
//   },
//   {
//     path: '/admin/editar/:id',
//     name: 'editar',
//     component: () => import('./Components/Preview-Critica.vue'),
//     props: true,
//   },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
