import { createRouter, createWebHistory } from 'vue-router'
// 顶部loading进度条
import NProgress from 'nprogress'
import 'nprogress/nprogress.css' 

const routes = [
    {
        path: '/',
        component: () => import('@v/layouts/PageBaseLayout.vue'),
        children: [
            {
                path: '',
                name: 'Index',
                component: () => import('@v/Index.vue'),
            },
            {
                path: '/word',
                name: 'Word',
                component: () => import('@v/word/Index.vue'),
            },
            {
                path: '/grammar',
                name: 'Grammar',
                component: () => import('@v/grammar/Index.vue'),
            },
            {
                path: '/about',
                name: 'About',
                component: () => import('@v/About.vue'),
            },
            {
                path: '/home',
                name: 'Home',
                component: () => import('@v/Home.vue'),
            }
        ]
    },
    {
        path: '/admin',
        component: () => import('@v/layouts/PageAdminLayout.vue'),
        children: [

        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(){
        return { top: 0 }
    }
})

router.beforeEach((to, from, next) => {
    NProgress.start()
    next()
  }
)
  
  router.afterEach(() => {
    NProgress.done()
  })

export default router