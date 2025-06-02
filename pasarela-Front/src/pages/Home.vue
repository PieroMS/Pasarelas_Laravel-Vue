<template>
  <div>
    <h1>Holas</h1>
    <button @click="logout">Cerrar sesión</button>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const logout = () => {
  localStorage.removeItem('token')  // Elimina el token
  router.push('/login')             // Redirige al login
}
</script>

<style scoped>
button {
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  background-color: #e63946;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #d62828;
}
</style>
