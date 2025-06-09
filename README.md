# 🚀 Proyecto
Integración de pasarelas: Paypal, 

## 💳 Paypal

- 📑 Crear una cuenta de Paypal. Crear una cuenta (para crear la ordern - vendedor) en Sandbox desde Apps & Credentials, documentación: https://developer.paypal.com/api/rest/

- 📑 Documentación para usar Paypal en Laravel: https://laravel-paypal.readthedocs.io/en/latest/installation.html

- Instalar el paquete:
```
composer require srmklive/paypal:~3.0
```

- Agregar las variables puestas en .env.example tanto en Laravel como en Vue

- Ejecutar el comando para agregar un el archivo ```config/paypal``` :
```
php artisan vendor:publish --provider "Srmklive\PayPal\Providers\PayPalServiceProvider"
```

- Ajustar el ```config/paypal``` según se requiera

- Crear una cuenta personal en TestingTools para realizar el pago (comprador)


### Flujo

> [!NOTE]
>
> [Usuario hace clic en botón de PayPal (Vue 3)]
>
> ↓
>
> [Vue 3 llama a /api/paypal/order en Laravel]
>
> ↓
>
> [Laravel crea la orden con srmklive]
>
> ↓
>
> [PayPal devuelve un ID de orden al frontend]
>
> ↓
>
> [Usuario aprueba el pago en el popup de PayPal]
>
> ↓
>
> [Vue 3 llama a /api/paypal/capture en Laravel]
>
> ↓
>
> [Laravel captura el pago con PayPal API]
>
> ↓
>
> [Se guarda pago y se responde al cliente]
>