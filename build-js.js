const { minify } = require('terser');
const fs = require('fs');
const path = require('path');
const { glob } = require('glob');

// Configuración de Terser para MÁXIMA optimización
const terserOptions = {
  compress: {
    passes: 3,                    // 3 pasadas de optimización
    drop_console: true,           // Eliminar console.log
    drop_debugger: true,          // Eliminar debugger
    pure_funcs: [                 // Funciones a eliminar
      'console.log',
      'console.info',
      'console.debug',
      'console.warn'
    ],
    dead_code: true,              // Eliminar código muerto
    conditionals: true,           // Optimizar condicionales
    evaluate: true,               // Evaluar expresiones constantes
    booleans: true,               // Optimizar booleanos
    loops: true,                  // Optimizar loops
    unused: true,                 // Eliminar variables no usadas
    hoist_funs: true,             // Hoisting de funciones
    hoist_vars: false,            // No hoist variables
    if_return: true,              // Optimizar if-return
    join_vars: true,              // Unir declaraciones de variables
    side_effects: true,           // Eliminar side effects
    unsafe: true,                 // Optimizaciones agresivas
    unsafe_comps: true,           // Comparaciones unsafe
    unsafe_math: true,            // Matemáticas unsafe
    unsafe_proto: true,           // Prototipo unsafe
    unsafe_regexp: true,          // RegExp unsafe
    unsafe_undefined: true        // Undefined unsafe
  },
  mangle: {
    toplevel: true,               // Mangle nombres top-level
    eval: true,                   // Mangle nombres en eval
    properties: {                 // Mangle propiedades
      regex: /^_/                 // Solo propiedades que empiezan con _
    }
  },
  format: {
    comments: false,              // Eliminar todos los comentarios
    beautify: false,              // No embellecer
    ascii_only: true              // Solo ASCII
  },
  sourceMap: false                // No generar sourcemap
};

async function optimizeJS() {
  console.log('🚀 Iniciando optimización de archivos JS...\n');

  // Buscar todos los archivos .js en src/js
  const jsFiles = await glob('src/js/**/*.js');

  if (jsFiles.length === 0) {
    console.log('⚠️  No se encontraron archivos JS en src/js/');
    return;
  }

  // Crear directorio de salida si no existe
  const outputDir = 'public/js';
  if (!fs.existsSync(outputDir)) {
    fs.mkdirSync(outputDir, { recursive: true });
  }

  let totalOriginalSize = 0;
  let totalMinifiedSize = 0;

  for (const file of jsFiles) {
    try {
      // Leer archivo
      const code = fs.readFileSync(file, 'utf8');
      const originalSize = Buffer.byteLength(code, 'utf8');

      // Obtener nombre del archivo
      const fileName = path.basename(file, '.js');
      const relativePath = path.relative('src/js', path.dirname(file));
      
      // Crear estructura de carpetas en public
      const outputSubDir = path.join(outputDir, relativePath);
      if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true });
      }

      // Minificar
      const result = await minify(code, terserOptions);

      if (result.error) {
        console.error(`❌ Error en ${file}:`, result.error);
        continue;
      }

      // Guardar archivo minificado
      const outputFile = path.join(outputSubDir, `${fileName}.min.js`);
      fs.writeFileSync(outputFile, result.code);

      const minifiedSize = Buffer.byteLength(result.code, 'utf8');
      const reduction = ((1 - minifiedSize / originalSize) * 100).toFixed(2);

      totalOriginalSize += originalSize;
      totalMinifiedSize += minifiedSize;

      console.log(`✅ ${file}`);
      console.log(`   📦 Original: ${(originalSize / 1024).toFixed(2)} KB`);
      console.log(`   📦 Minificado: ${(minifiedSize / 1024).toFixed(2)} KB`);
      console.log(`   💾 Reducción: ${reduction}%\n`);
    } catch (error) {
      console.error(`❌ Error procesando ${file}:`, error.message);
    }
  }

  // Resumen final
  const totalReduction = ((1 - totalMinifiedSize / totalOriginalSize) * 100).toFixed(2);
  console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
  console.log('📊 RESUMEN TOTAL DE OPTIMIZACIÓN JS');
  console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
  console.log(`📁 Archivos procesados: ${jsFiles.length}`);
  console.log(`📦 Tamaño original: ${(totalOriginalSize / 1024).toFixed(2)} KB`);
  console.log(`📦 Tamaño minificado: ${(totalMinifiedSize / 1024).toFixed(2)} KB`);
  console.log(`💾 Reducción total: ${totalReduction}%`);
  console.log(`✨ Ahorro: ${((totalOriginalSize - totalMinifiedSize) / 1024).toFixed(2)} KB\n`);
}

optimizeJS().catch(console.error);