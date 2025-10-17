import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('../views/AboutView.vue')
  },

  {
    path: '/showproduct',
    name: 'showproduct',
    component: () => import('../views/ShowProduct.vue')
  },

  {
    path: '/customer',
    name: 'customer',
    component: () => import('../views/Customer.vue')
  },
  {
    path: '/addcustomer',
    name: 'addcustomer',
    component: () => import('../views/add_customer.vue')
  },
  {
    path: '/product',
    name: 'product',
    component: () => import('../views/Product.vue')
  },
  {
    path: '/addproduct',
    name: 'addproduct',
    component: () => import('../views/add_product.vue')
  },
  {
    path: '/student',
    name: 'student',
    component: () => import('../views/Student.vue')
  },
  {
    path: '/addstudent',
    name: 'addstudent',
    component: () => import('../views/add_student.vue')
  },
  {
    path: '/pro_edit',
    name: 'pro_edit',
    component: () => import('../views/product_edit.vue')
  },
  {
    path: '/edit_ct',
    name: '/edit_ct',
    component: () => import('../views/Edit_customer.vue')
  },
  {
    path: '/emp',
    name: '/emp',
    component: () => import('../views/employee.vue')
  },
  {
    path: '/ed_emp',
    name: '/ed_emp',
    component: () => import('../views/Edit_employee.vue')
  },
  {
    path: '/addemp',
    name: '/addemp',
    component: () => import('../views/add_employee.vue')
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
