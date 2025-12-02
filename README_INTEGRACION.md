# VIG-IA - Sistema de Videovigilancia Inteligente
## Integración MATLAB + Laravel

### 🚀 **Sistema Completamente Funcional**

Tu sistema VIG-IA ya está listo para recibir alertas reales de MATLAB y mostrarlas en la interfaz web en tiempo real.

---

## 📋 **Funcionalidades Implementadas**

### **1. API REST Completa**
- ✅ Endpoint para recibir alertas de MATLAB: `POST /api/recibir-alerta`
- ✅ Endpoint para obtener alertas: `GET /api/alertas`
- ✅ Endpoint para alertas recientes: `GET /api/alertas/recientes`
- ✅ Endpoint para marcar alertas como vistas: `POST /api/alertas/{id}/marcar-vista`
- ✅ Endpoint para estado del sistema: `GET /api/sistema/estado`

### **2. Base de Datos**
- ✅ Tabla `alerts` con todos los campos necesarios
- ✅ Modelo `Alert` con relaciones y métodos útiles
- ✅ Seeders con datos de prueba

### **3. Frontend Dinámico**
- ✅ Feed de eventos en tiempo real
- ✅ Polling automático cada 5 segundos para nuevas alertas
- ✅ Actualización automática del estado del sistema
- ✅ Panel de evidencia que se activa con alertas reales
- ✅ Botones de acción que interactúan con la API

### **4. Configuración MATLAB**
- ✅ Función `enviarAlertaAPI()` actualizada
- ✅ Manejo de errores robusto
- ✅ Configuración modular y fácil de cambiar

---

## 🔧 **Cómo Usar el Sistema**

### **Paso 1: Iniciar el Servidor Laravel**
```bash
cd /home/user/Proyectos/TInvestigacion
php artisan serve --host=0.0.0.0 --port=8000
```

### **Paso 2: Abrir la Interfaz Web**
Navega a: http://localhost:8000

### **Paso 3: Probar la Conexión MATLAB**
1. Abre MATLAB
2. Cambia al directorio del proyecto
3. Ejecuta el script de prueba:
```matlab
run('test_api_matlab.m')
```

### **Paso 4: Usar tu Código de Detección**
1. Integra la función `enviarAlertaAPI()` en tu código existente
2. Reemplaza la URL si es necesario
3. Ejecuta tu código de detección

---

## 📡 **Formato de Datos MATLAB → API**

Tu código MATLAB ya está configurado para enviar alertas en este formato:

```json
{
    "camera_id": "camara_01",
    "location": "Callejon Principal",
    "track_id": 123,
    "alert_type": "persona_detenida", // o "movimiento_sospechoso"
    "description": "Descripción de la alerta",
    "duration_seconds": 30,
    "frame_count": 900,
    "timestamp": "2025-12-01 15:30:45"
}
```

---

## 🎯 **Tipos de Alertas Soportadas**

### **1. Persona Detenida** (`persona_detenida`)
- Persona que permanece inmóvil por más de X segundos
- Nivel de prioridad: ALTO (si >60s) o MEDIO (si <60s)
- Color: Rojo

### **2. Movimiento Sospechoso** (`movimiento_sospechoso`)
- Persona con patrón de movimiento "va-y-viene"
- Nivel de prioridad: MEDIO
- Color: Naranja

---

## 🔄 **Flujo de Trabajo Completo**

1. **MATLAB detecta actividad** → Analiza movimiento
2. **Se cumple condición de alerta** → Llama `enviarAlertaAPI()`
3. **API Laravel recibe datos** → Guarda en base de datos
4. **Frontend hace polling** → Obtiene nuevas alertas cada 5s
5. **Interfaz se actualiza** → Muestra alerta en feed y panel de evidencia
6. **Guardia toma acción** → Usa botones para marcar como vista/falsa alarma

---

## 🛠 **Configuración para Producción**

### **Para Publicar en Internet:**
1. Cambia la URL en `matlab_config.m`:
```matlab
apiBaseUrl = 'https://tu-dominio.com';
```

2. Configura tu servidor web (Apache/Nginx)
3. Asegúrate de que HTTPS esté habilitado
4. Actualiza las configuraciones de CORS si es necesario

---

## 🐛 **Troubleshooting**

### **Si MATLAB no puede enviar alertas:**
1. Verifica que Laravel esté ejecutándose
2. Prueba la URL manualmente: http://localhost:8000/api/sistema/estado
3. Revisa los logs de Laravel: `tail -f storage/logs/laravel.log`

### **Si el frontend no actualiza:**
1. Abre las herramientas de desarrollador (F12)
2. Verifica la consola por errores JavaScript
3. Comprueba las peticiones en la pestaña Network

### **Si hay errores de CORS:**
1. El middleware `HandleCors` ya está configurado
2. Verifica que las rutas API estén correctamente registradas

---

## 📊 **Endpoints Disponibles**

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `POST` | `/api/recibir-alerta` | Recibe alertas de MATLAB |
| `GET` | `/api/alertas` | Lista todas las alertas |
| `GET` | `/api/alertas/recientes` | Alertas últimas 24h |
| `POST` | `/api/alertas/{id}/marcar-vista` | Marca alerta como vista |
| `DELETE` | `/api/alertas/{id}` | Marca como falsa alarma |
| `GET` | `/api/sistema/estado` | Estado actual del sistema |

---

## 🎉 **¡Tu Sistema Está Listo!**

El sistema VIG-IA ya puede:
- ✅ Recibir alertas reales de MATLAB
- ✅ Mostrar alertas en tiempo real en la web
- ✅ Permitir acciones de guardia de seguridad
- ✅ Mantener historial de todas las alertas
- ✅ Calcular nivel de amenaza automáticamente
- ✅ Funcionar tanto local como en producción

¡Ahora solo integra tu código de MATLAB y tendrás un sistema completo de videovigilancia profesional! 🚀