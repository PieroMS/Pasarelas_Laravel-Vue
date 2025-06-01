<template>
  <div
    class="min-h-screen flex items-center justify-center px-4 bg-gray-900 bg-center bg-cover"
    style="background-image: linear-gradient(rgba(17, 24, 39, 0.85), rgba(17, 24, 39, 0.85)), url('https://images.pexels.com/photos/2246476/pexels-photo-2246476.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');"
  >
    <div class="w-full max-w-sm">
      <div class="bg-[#ebebebc2] shadow-sm rounded-xl px-8 py-10">
        <h1 class="text-2xl font-semibold text-gray-800 text-center mb-6">Iniciar sesión</h1>
        
        <form @submit.prevent="login" class="space-y-5">
          <div>
            <label for="email" class="block text-sm text-gray-600 mb-1">Correo electrónico</label>
            <input
              v-model="email"
              id="email"
              type="email"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 transition"
              placeholder="tucorreo@ejemplo.com"
              required
            />
          </div>

          <div>
            <label for="password" class="block text-sm text-gray-600 mb-1">Contraseña</label>
            <input
              v-model="password"
              id="password"
              type="password"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-800 transition"
              placeholder="••••••••"
              required
            />
          </div>

          <button
            type="submit"
            class="w-full bg-gray-900 text-white py-2 rounded-lg hover:bg-gray-800 transition font-medium"
          >
            Entrar
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const email = ref('')
const password = ref('')

const login = () => {
  // Aquí iría la lógica de autenticación
  console.log('Login con:', email.value, password.value)
}
</script>
