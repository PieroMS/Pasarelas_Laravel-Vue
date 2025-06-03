<template>
  <div 
    class="min-h-screen flex items-center justify-center px-4 bg-gray-900 bg-center bg-cover relative"
    style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.7)), url('https://images.pexels.com/photos/773471/pexels-photo-773471.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"
  >
    <!-- Partículas animadas sutiles -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-white/5 rounded-full blur-2xl animate-pulse"></div>
      <div class="absolute top-3/4 right-1/4 w-24 h-24 bg-blue-300/10 rounded-full blur-xl animate-pulse" style="animation-delay: 1s;"></div>
      <div class="absolute bottom-1/4 left-1/3 w-16 h-16 bg-white/5 rounded-full blur-lg animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
      <div class="bg-[#85858550] backdrop-blur-sm shadow-2xl rounded-2xl px-8 py-10 border border-gray-200">
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-white mb-2">Iniciar sesión</h1>
        </div>
        
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
          <div class="flex items-center mb-3">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-blue-800 font-semibold text-sm">Credenciales de prueba</p>
          </div>
          <div class="space-y-2 text-sm">
            <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2 shadow-sm">
              <span class="text-gray-600">Email:</span>
              <span class="text-gray-800 font-mono">piero@example.com</span>
            </div>
            <div class="flex items-center justify-between bg-white rounded-lg px-3 py-2 shadow-sm">
              <span class="text-gray-600">Password:</span>
              <span class="text-gray-800 font-mono">12345678</span>
            </div>
          </div>
        </div>

        <div v-if="errorMessage" class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 flex items-center">
          <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
          <span>{{ errorMessage }}</span>
        </div>

        <!-- Formulario mejorado -->
        <form @submit.prevent="handleLogin" class="space-y-6">
          <div>
            <label for="email" class="block text-sm font-medium text-white mb-2">Correo electrónico</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                </svg>
              </div>
              <input
                v-model="email"
                id="email"
                type="email"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                placeholder="piero@example.com"
                required
              />
            </div>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-white mb-2">Contraseña</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
              </div>
              <input
                v-model="password"
                id="password"
                type="password"
                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                placeholder="••••••••"
                required
              />
            </div>
          </div>

          <!-- Botón de login mejorado -->
          <button
            type="submit"
            :disabled="isLoading"
            class="group relative w-full bg-gray-900 hover:bg-gray-800 text-white py-3 px-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl font-medium disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none cursor-pointer"
          >
            <span v-if="!isLoading" class="flex items-center justify-center">
              Iniciar sesión
            </span>
            <span v-else class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Iniciando sesión...
            </span>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const isLoading = ref(false)
const router = useRouter()

const handleLogin = async () => {
  isLoading.value = true
  errorMessage.value = ''
  
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: email.value,
      password: password.value
    })
    console.log(response.data)
    const token = response.data.token
    localStorage.setItem('token', token)    
    router.push('/')
  } catch (error) {
    errorMessage.value = 'Credenciales incorrectas. Inténtalo de nuevo.'
    console.error('Error: ', error)
  } finally {
    isLoading.value = false
  }
}
</script>