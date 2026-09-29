#!/bin/bash

# 1. Detectar el nombre de la carpeta actual de forma dinámica
REPO_NAME=$(basename "$PWD")
USERNAME="idei-dev"
BRANCH_NAME="main"

echo "📂 Proyecto local detectado: $REPO_NAME"

# 2. Solicitar el token por terminal de forma segura
echo -n "🔑 Introduce tu GitHub Token (no se mostrará en pantalla): "
read -s GITHUB_TOKEN
echo "" # Salto de línea estético

# Validar que el token no esté vacío
if [ -z "$GITHUB_TOKEN" ]; then
    echo "❌ Error: El token no puede estar vacío."
    exit 1
fi

echo "🔍 Verificando si el repositorio ya existe en GitHub..."

# 3. Comprobar si el repositorio ya existe usando la API de GitHub
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" \
  -H "Authorization: token $GITHUB_TOKEN" \
  "https://github.com{USERNAME}/${REPO_NAME}")

if [ "$HTTP_STATUS" -eq 200 ]; then
    echo "❌ Error: El repositorio '${REPO_NAME}' ya existe en la cuenta de GitHub de '${USERNAME}'."
    echo "Proceso abortado para evitar conflictos."
    exit 1
fi

echo "✨ El repositorio no existe. Creándolo de forma automática en GitHub..."

# 4. Crear el repositorio público mediante la API
CREATE_RESPONSE=$(curl -s -o /dev/null -w "%{http_code}" \
  -H "Authorization: token $GITHUB_TOKEN" \
  -H "Accept: application/vnd.github.v3+json" \
  -d "{\"name\":\"${REPO_NAME}\", \"private\": false}" \
  "https://api.github.com/user/repos")

if [ "$CREATE_RESPONSE" -ne 201 ]; then
    echo "❌ Error al crear el repositorio en GitHub (Código de error API: $CREATE_RESPONSE)."
    echo "Verifica que tu token tenga los permisos de 'repo' activos."
    exit 1
fi

echo "✅ Repositorio creado exitosamente en GitHub."
echo "🚀 Iniciando configuración local de Git..."

# 5. Inicializar Git local si no existe la carpeta .git
if [ ! -d ".git" ]; then
    git init -b "$BRANCH_NAME"
    echo "✅ Repositorio Git inicializado en la rama '$BRANCH_NAME'."
fi

# 6. Agregar archivos y hacer el commit inicial
git add .
if ! git diff-index --quiet HEAD -- 2>/dev/null; then
    git commit -m "Primer commit automático"
    echo "✅ Archivos guardados en el commit."
else
    if [ "$(git rev-list --all --count 2>/dev/null || echo 0)" -eq 0 ]; then
        git commit -m "Primer commit automático"
        echo "✅ Primer commit realizado con éxito."
    else
        echo "ℹ️ No hay cambios nuevos que guardar de forma local."
    fi
fi

# 7. Configurar el origen remoto limpiando enlaces previos
if git remote | grep -q "^origin$"; then
    git remote remove origin
fi

# 🌟 ¡LÍNEA CORREGIDA AQUÍ! Se quitó el '://' duplicado y se agregó el '$' a USERNAME
git remote add origin "https://${USERNAME}:${GITHUB_TOKEN}@github.com/${USERNAME}/${REPO_NAME}.git"

# 8. Enviar los cambios finales a GitHub
echo "📤 Subiendo archivos..."
git push -u origin "$BRANCH_NAME"

if [ $? -eq 0 ]; then
    # 🌟 ¡LÍNEA CORREGIDA AQUÍ! Enlace limpio de salida en pantalla
    echo "🎉 ¡Todo listo! Tu código ya está publicado en: https://://github.com{USERNAME}/${REPO_NAME}"
else
    echo "❌ Error al subir los archivos al nuevo repositorio."
fi
