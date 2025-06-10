
<template>
  <header class="px-6 bg-gradient-to-r from-gray-900 via-blue-900 to-gray-900 text-white shadow-lg relative overflow-hidden">

    <div class="absolute inset-0 opacity-10">
      <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-white/20 to-transparent"></div>
      <div class="absolute top-4 right-4 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
      <div class="absolute bottom-4 left-4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
    </div>
    
    <div class="relative z-10 flex items-center justify-between px-6 py-4">
      
      <div class="flex items-center space-x-3">
        <div>
          <h1 class="text-2xl font-bold bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
            PayHub
          </h1>
          <p class="text-blue-200 text-sm font-medium">Panel de Pasarelas</p>
        </div>
      </div>
      <router-link to="/" class="px-3 text-base font-bold border-b-3 border-transparent hover:border-white transition-colors duration-200">
        INICIO
      </router-link>
      <div class="flex items-center space-x-4">
        <button
          @click="logout"
          class="cursor-pointer group relative bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl border border-red-500/50"
        >
          <div class="flex items-center space-x-2">
            <span>Cerrar sesión</span>
          </div>
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const logout = async () => {
  try {
    await axios.post('http://127.0.0.1:8000/api/logout', {}, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })

    localStorage.removeItem('token')
    router.push('/login')
  } catch (error) {
    console.error('Error cerrando sesión:', error)
    // puedes manejar el error, pero igual forzar logout local
    localStorage.removeItem('token')
    router.push('/login')
  }
}
</script>