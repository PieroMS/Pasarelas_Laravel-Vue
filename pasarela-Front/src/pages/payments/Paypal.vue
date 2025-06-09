<template>
  <div class="p-6 max-w-md mx-auto space-y-4">
    <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad</label>
    <input
      v-model="quantity"
      type="number"
      min="1"
      id="quantity"
      class="w-full p-2 border rounded"
    />

    <button
      @click="startPayPal"
      class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition"
    >
      Pagar
    </button>

    <div id="paypal-button" class="mt-4"></div>

    <!-- Modal Éxito -->
    <div v-if="showSuccessModal" class="fixed inset-0 bg-black/40 flex items-center justify-center">
      <div class="bg-white p-6 rounded shadow max-w-sm w-full text-center">
        <h2 class="text-xl font-bold text-green-600 mb-4">✅ Pago exitoso</h2>
        <p>Tu pago fue procesado correctamente.</p>
        <button @click="showSuccessModal = false" class="mt-4 text-blue-500">Cerrar</button>
      </div>
    </div>

    <!-- Modal Error -->
    <div v-if="showErrorModal" class="fixed inset-0 bg-black/40 flex items-center justify-center">
      <div class="bg-white p-6 rounded shadow max-w-sm w-full text-center">
        <h2 class="text-xl font-bold text-red-600 mb-4">❌ Error en el pago</h2>
        <p>No se pudo completar el pago. Inténtalo nuevamente.</p>
        <button @click="showErrorModal = false" class="mt-4 text-blue-500">Cerrar</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const quantity = ref(1)
const total = ref(25) // puedes calcularlo según cantidad
const showSuccessModal = ref(false)
const showErrorModal = ref(false)

console.log('cliente');
console.log(import.meta.env.VITE_PAYPAL_CLIENT_ID);
const startPayPal = async () => {
  const existing = document.getElementById('paypal-sdk')
  if (!existing) {
    const script = document.createElement('script')
    script.id = 'paypal-sdk'
    script.src = `https://www.paypal.com/sdk/js?client-id=${encodeURIComponent(import.meta.env.VITE_PAYPAL_CLIENT_ID)}&currency=USD`
    script.onload = () => {
      setTimeout(() => {
        renderPayPal()
      }, 300)
    }
    document.body.appendChild(script)
  } else {
    renderPayPal()
  }
}

const renderPayPal = () => {
  window.paypal.Buttons({
    createOrder: async () => {
      const res = await axios.post('http://127.0.0.1:8000/api/paypal/createPaypalOrder',
      {
        quantity: quantity.value,
        total: total.value * quantity.value
      },
      {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
      return res.data.paypal_order_id
    },
    onApprove: async (data) => {
      try {
        const res = await axios.post('http://127.0.0.1:8000/api/paypal/capturePaypalOrder',
        {
          orderID: data.orderID
        },
        {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      })

        if (res.data.status === 'COMPLETED') {
          showSuccessModal.value = true
        } else {
          showErrorModal.value = true
        }
      } catch (err) {
        console.error(err)
        showErrorModal.value = true
      }
    },
    onError: err => {
      console.error('❌ PayPal error:', err)
      showErrorModal.value = true
    }
  }).render('#paypal-button')
}
</script>

<style scoped>
input[type="number"]::-webkit-inner-spin-button {
  opacity: 1;
}
</style>
