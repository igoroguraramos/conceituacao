import { createRouter, createWebHistory } from 'vue-router'
import AppLayout from '@/components/layouts/AppLayout.vue'
import Dashboard from '@/views/Dashboard.vue'
import Users from '@/views/Users.vue'
import Profiles from '@/views/Profiles.vue'

const router = createRouter({
  history: createWebHistory(),

  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/AuthView.vue'),
    },

    {
      path: '/',
      redirect: '/login',
    },

    {
      path: '/',
      component: AppLayout,
      meta: { requiresAuth: true },

      children: [
        {
          path: '',
          redirect: '/dashboard',
        },

        {
          path: 'dashboard',
          name: 'dashboard',
          component: Dashboard,
        },

        {
          path: 'users',
          name: 'users',
          component: Users,
        },

        {
          path: 'profiles',
          name: 'profiles',
          component: Profiles,
        },
      ],
    },
  ],
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token')

  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'login' })
    return
  }

  if (to.name === 'login' && isAuthenticated) {
    next({ name: 'dashboard' })
    return
  }

  next()
})

export default router