import { createRouter, createWebHistory } from 'vue-router'

function isAuthenticated() {
  return !!localStorage.getItem('token')
}

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import('../pages/Home.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../pages/auth/Login.vue')
    }
  ]
})

// Guardia global para proteger rutas
router.beforeEach((to, from, next) => {
  const loggedIn = isAuthenticated()

  if (to.meta.requiresAuth && !loggedIn) {
    // Si intenta ir a una ruta protegida sin estar autenticado → login
    next('/login')
  } else if (to.path === '/login' && loggedIn) {
    // Si está logueado e intenta entrar al login → redirige a home
    next('/')
  } else {
    // Caso normal → continuar
    next()
  }
})

export default router
