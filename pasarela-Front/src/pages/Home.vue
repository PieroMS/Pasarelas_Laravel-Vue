<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-6">
    <div class="max-w-4xl mx-auto text-center mb-12">
      <h1 class="text-4xl font-bold text-gray-800 mb-4">Selecciona una pasarela de pago</h1>
      <p class="text-gray-600 text-lg">Elige con qué pasarela deseas procesar tu pago de forma segura</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
      <div
        v-for="gateway in gateways"
        :key="gateway.name"
        class="group bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl cursor-pointer transition-all duration-300 transform hover:scale-105 border-2 border-transparent hover:border-blue-200 relative overflow-hidden"
        @click="selectGateway(gateway.route)"
      >
        <!-- Línea decorativa superior -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r" :class="gateway.gradient"></div>
        
        <!-- Efecto de hover sutil -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50/0 to-indigo-50/0 group-hover:from-blue-50/30 group-hover:to-indigo-50/30 transition-all duration-300 rounded-xl"></div>
        
        <div class="relative z-10">
          <div class="flex justify-center mb-6">
            <div class="bg-gray-50 rounded-full p-4 group-hover:bg-blue-50 transition-colors duration-300">
              <img :src="gateway.image" :alt="gateway.name" class="h-16 w-16 object-contain" />
            </div>
          </div>
          
          <h2 class="text-xl font-semibold text-center text-gray-800 mb-2 group-hover:text-blue-700 transition-colors duration-300">
            {{ gateway.name }}
          </h2>
          
          <p class="text-gray-500 text-sm text-center mb-4">{{ gateway.description }}</p>
        </div>
        
        <!-- Línea decorativa inferior -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r opacity-0 group-hover:opacity-100 transition-opacity duration-300" :class="gateway.gradient"></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
import paypal from '../assets/paypal.png'
import niubiz from '../assets/niubiz.jpeg'
import mercadopago from '../assets/mercadopago.png'

const router = useRouter()

const gateways = [
  {
    name: 'PayPal',
    route: '/paypal',
    image: paypal,
    description: 'Pago rápido y seguro con tu cuenta PayPal',
    gradient: 'from-blue-500 to-blue-600'
  },
  {
    name: 'Stripe',
    route: '/gateway/stripe',
    image: niubiz,
    description: 'Procesamiento de tarjetas de crédito y débito',
    gradient: 'from-purple-500 to-indigo-600'
  },
  {
    name: 'MercadoPago',
    route: '/gateway/mercadopago',
    image: mercadopago,
    description: 'Solución de pagos para América Latina',
    gradient: 'from-cyan-500 to-blue-500'
  },
]

const selectGateway = (route) => {
  router.push(route)
}
</script>