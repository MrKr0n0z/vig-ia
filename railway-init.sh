#!/bin/bash

# Script de inicialización para Railway
echo "🚀 Iniciando aplicación en Railway..."

# Crear el directorio de base de datos si no existe
mkdir -p /app/database

# Crear el archivo SQLite si no existe
if [ ! -f /app/database/database.sqlite ]; then
    echo "📦 Creando archivo SQLite..."
    touch /app/database/database.sqlite
    chmod 664 /app/database/database.sqlite
fi

# Ejecutar migraciones
echo "🔄 Ejecutando migraciones..."
php artisan migrate --force

# Ejecutar seeders si es necesario
echo "🌱 Ejecutando seeders..."
php artisan db:seed --force

# Limpiar caché
echo "🧹 Limpiando caché..."
php artisan config:cache
php artisan route:cache

echo "✅ Inicialización completada"