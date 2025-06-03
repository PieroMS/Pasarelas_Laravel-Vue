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
    
    <!-- Información adicional -->
    <div class="max-w-3xl mx-auto mt-12 text-center">
      <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-center mb-3">
          <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
          </svg>
          <h3 class="text-lg font-semibold text-gray-800">Pagos 100% Seguros</h3>
        </div>
        <p class="text-gray-600">Todas nuestras pasarelas de pago utilizan encriptación SSL y cumplen con los estándares PCI DSS para garantizar la seguridad de tus datos.</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const gateways = [
  {
    name: 'PayPal',
    route: '/gateway/paypal',
    image: 'https://play-lh.googleusercontent.com/iQ8f5plIFy9rrY46Q2TNRwq_8nCvh9LZVwytqMBpOEcfnIU3vTkICQ6L1-RInWS93oQg',
    description: 'Pago rápido y seguro con tu cuenta PayPal',
    gradient: 'from-blue-500 to-blue-600'
  },
  {
    name: 'Stripe',
    route: '/gateway/stripe',
    image: 'https://yt3.googleusercontent.com/EiQSNs-L34NwO-pFTpsgdWaTKHRieqFX0QG9so1xxZ5mpPal_UJf_XYV6Tre3aNiJgRgpUXj=s900-c-k-c0x00ffffff-no-rj',
    description: 'Procesamiento de tarjetas de crédito y débito',
    gradient: 'from-purple-500 to-indigo-600'
  },
  {
    name: 'MercadoPago',
    route: '/gateway/mercadopago',
    image: 'https://avatars.githubusercontent.com/u/33136169?s=200&v=4',
    description: 'Solución de pagos para América Latina',
    gradient: 'from-cyan-500 to-blue-500'
  },
]

const selectGateway = (route) => {
  router.push(route)
}
</script>