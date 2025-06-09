import { createRouter, createWebHistory } from 'vue-router'

function isAuthenticated() {
  return !!localStorage.getItem('token')
}

const routes = [
  {
    path: '/',
    meta: { requiresAuth: true },
    component: () => import('../pages/layout/DefaultLayour.vue'),
    children: [
      {
        path: '',
        name: 'home',
        component: () => import('../pages/Home.vue'),
      },
      {
        path: 'paypal',
        name: 'paypal',
        component: () => import('../pages/payments/Paypal.vue'),
      }
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('../pages/auth/Login.vue')
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const loggedIn = isAuthenticated()

  if (to.meta.requiresAuth && !loggedIn) {
    next({ name: 'login', query: { redirect: to.fullPath } })
  } else if (to.name === 'login' && loggedIn) {
    next({ name: 'home' })
  } else {
    next()
  }
})

export default router
