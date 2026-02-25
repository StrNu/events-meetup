# Guía: Cómo Subir un Proyecto a GitHub con Resolución de Conflictos

Esta guía documenta el proceso completo para subir el proyecto EventFlow a GitHub, incluyendo la resolución de conflictos cuando el repositorio remoto ya tiene contenido.

## 📋 Contexto

**Situación inicial:**
- Proyecto local con 20 archivos listos
- Repositorio remoto en GitHub ya creado con un README básico
- Necesidad de combinar ambos historiales

**Repositorio:** https://github.com/StrNu/events-meetup

---

## 🔧 Paso 1: Inicializar Repositorio Local

```bash
# Inicializar Git en el directorio del proyecto
git init
```

**Resultado:** Se crea la carpeta `.git/` en el proyecto.

---

## 📦 Paso 2: Agregar Archivos al Staging

```bash
# Agregar todos los archivos al área de staging
git add .
```

**Resultado:** Todos los archivos del proyecto quedan listos para el commit.

---

## 💾 Paso 3: Crear el Primer Commit

```bash
# Crear el commit inicial con un mensaje descriptivo
git commit -m "Initial commit: EventFlow project setup with DDD architecture"
```

**Resultado:** 
- Se crea el commit con 19 archivos
- El commit queda registrado en la rama `main` local

**Salida del comando:**
```
[main (root-commit) 1b381da] Initial commit: EventFlow project setup with DDD architecture
 19 files changed, 1578 insertions(+)
 create mode 100644 .env.example
 create mode 100644 .gitignore
 create mode 100644 README.md
 create mode 100644 composer.json
 ... (más archivos)
```

---

## 🔗 Paso 4: Conectar con el Repositorio Remoto

```bash
# Agregar el repositorio remoto de GitHub
git remote add origin https://github.com/StrNu/events-meetup.git

# Renombrar la rama a 'main' (si es necesario)
git branch -M main
```

**Resultado:** El repositorio local queda conectado con GitHub.

**Verificar la conexión:**
```bash
git remote -v
```

---

## ⚠️ Paso 5: Primer Intento de Push (Falla)

```bash
# Intentar subir los cambios
git push -u origin main
```

**Error recibido:**
```
! [rejected]        main -> main (fetch first)
error: failed to push some refs to 'https://github.com/StrNu/events-meetup.git'
hint: Updates were rejected because the remote contains work that you do not
hint: have locally. This is usually caused by another repository pushing to
hint: the same ref.
```

**Causa:** El repositorio remoto tiene contenido (README.md) que no existe en el repositorio local.

---

## 🔄 Paso 6: Hacer Pull con Historiales No Relacionados

```bash
# Traer los cambios del remoto permitiendo historiales no relacionados
git pull origin main --allow-unrelated-histories --no-rebase
```

**Error recibido:**
```
Auto-merging README.md
CONFLICT (add/add): Merge conflict in README.md
Automatic merge failed; fix conflicts and then commit the result.
```

**Causa:** Tanto el repositorio local como el remoto tienen un archivo `README.md` con contenido diferente.

---

## 🛠️ Paso 7: Resolver el Conflicto

### 7.1 Verificar el estado

```bash
git status
```

**Salida:**
```
On branch main
You have unmerged paths.
  (fix conflicts and run "git commit")

Unmerged paths:
  (use "git add <file>..." to mark resolution)
        both added:      README.md
```

### 7.2 Revisar el conflicto

El archivo `README.md` contenía marcadores de conflicto:

```markdown
<<<<<<< HEAD
# EventFlow

PWA para administrar eventos tipo conferencia/meetup...
(contenido completo del README local)
=======
# events-meetup
sistema para gestión de eventos tipo meetup
>>>>>>> 6fdcb681c20399c3be4e6b1b19255e15847d3caa
```

### 7.3 Elegir la versión a mantener

**Opciones disponibles:**
- `git checkout --ours README.md` → Mantener la versión local
- `git checkout --theirs README.md` → Mantener la versión remota
- Editar manualmente el archivo para combinar ambas versiones

**Decisión:** Mantener la versión local porque tiene documentación completa.

```bash
# Mantener nuestra versión del README (la local)
git checkout --ours README.md
```

### 7.4 Agregar archivos resueltos

```bash
# Marcar el conflicto como resuelto
git add README.md

# Agregar también el archivo de instrucciones de GitHub
git add GITHUB_INSTRUCTIONS.md
```

---

## ✅ Paso 8: Completar el Merge

```bash
# Crear el commit de merge
git commit -m "Merge remote README and add complete project documentation"
```

**Resultado:**
```
[main 39684bf] Merge remote README and add complete project documentation
```

---

## 🚀 Paso 9: Push Exitoso

```bash
# Subir los cambios a GitHub
git push -u origin main
```

**Resultado exitoso:**
```
Enumerating objects: 35, done.
Counting objects: 100% (35/35), done.
Delta compression using up to 8 threads
Compressing objects: 100% (28/28), done.
Writing objects: 100% (33/33), 18.45 KiB | 9.22 MiB/s, done.
Total 33 (delta 3), reused 0 (delta 0), pack-reused 0 (from 0)
remote: Resolving deltas: 100% (3/3), done.
To https://github.com/StrNu/events-meetup.git
   6fdcb68..39684bf  main -> main
branch 'main' set up to track 'origin/main'.
```

---

## 📊 Resumen de Comandos Ejecutados

```bash
# 1. Inicializar repositorio
git init

# 2. Agregar archivos
git add .

# 3. Primer commit
git commit -m "Initial commit: EventFlow project setup with DDD architecture"

# 4. Conectar con GitHub
git remote add origin https://github.com/StrNu/events-meetup.git
git branch -M main

# 5. Intentar push (falla)
git push -u origin main

# 6. Traer cambios remotos
git pull origin main --allow-unrelated-histories --no-rebase

# 7. Resolver conflicto
git checkout --ours README.md
git add README.md GITHUB_INSTRUCTIONS.md

# 8. Completar merge
git commit -m "Merge remote README and add complete project documentation"

# 9. Push exitoso
git push -u origin main
```

---

## 🎯 Estrategias de Resolución de Conflictos

### Opción 1: Mantener versión local
```bash
git checkout --ours <archivo>
```

### Opción 2: Mantener versión remota
```bash
git checkout --theirs <archivo>
```

### Opción 3: Edición manual
1. Abrir el archivo en un editor
2. Buscar los marcadores de conflicto (`<<<<<<<`, `=======`, `>>>>>>>`)
3. Editar manualmente para combinar o elegir el contenido deseado
4. Eliminar los marcadores de conflicto
5. Guardar el archivo
6. Ejecutar `git add <archivo>`

---

## 💡 Consejos y Mejores Prácticas

### 1. **Evitar conflictos desde el inicio**
- Crear el repositorio en GitHub **sin** README, .gitignore ni licencia
- Hacer el primer push antes de que otros colaboradores agreguen contenido

### 2. **Cuando ya existe contenido remoto**
- Usar `--allow-unrelated-histories` para combinar historiales independientes
- Revisar cuidadosamente qué versión mantener en caso de conflictos

### 3. **Verificar antes de hacer push**
```bash
# Ver el estado del repositorio
git status

# Ver los commits locales que no están en remoto
git log origin/main..HEAD

# Ver las diferencias
git diff origin/main
```

### 4. **Configurar identidad de Git**
```bash
# Configurar nombre y email globalmente
git config --global user.name "Tu Nombre"
git config --global user.email "tu@email.com"

# O solo para este repositorio
git config user.name "Tu Nombre"
git config user.email "tu@email.com"
```

---

## 🔍 Comandos Útiles para Diagnóstico

```bash
# Ver el historial de commits
git log --oneline

# Ver el estado actual
git status

# Ver los remotos configurados
git remote -v

# Ver las ramas locales y remotas
git branch -a

# Ver las diferencias no commiteadas
git diff

# Ver las diferencias en staging
git diff --staged
```

---

## ❌ Errores Comunes y Soluciones

### Error: "Updates were rejected"
**Causa:** El remoto tiene commits que no están en local.
**Solución:** Hacer `git pull` antes de `git push`.

### Error: "Need to specify how to reconcile divergent branches"
**Causa:** Git no sabe si hacer merge o rebase.
**Solución:** Agregar `--no-rebase` o `--rebase` al comando pull.

### Error: "CONFLICT (add/add)"
**Causa:** Ambos repositorios agregaron el mismo archivo.
**Solución:** Resolver manualmente o usar `git checkout --ours/--theirs`.

### Error: "fatal: refusing to merge unrelated histories"
**Causa:** Los historiales de commits no tienen un ancestro común.
**Solución:** Agregar `--allow-unrelated-histories` al pull.

---

## 📚 Recursos Adicionales

- [Git Documentation](https://git-scm.com/doc)
- [GitHub Guides](https://guides.github.com/)
- [Resolving Merge Conflicts](https://docs.github.com/en/pull-requests/collaborating-with-pull-requests/addressing-merge-conflicts/resolving-a-merge-conflict-using-the-command-line)

---

**Fecha:** 2026-01-09  
**Proyecto:** EventFlow  
**Repositorio:** https://github.com/StrNu/events-meetup
