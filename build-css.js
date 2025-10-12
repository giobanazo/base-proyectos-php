const postcss = require('postcss');
const cssnano = require('cssnano');
const fs = require('fs');
const path = require('path');
const { glob } = require('glob');

// Configuración de cssnano para MÁXIMA optimización
const cssnanoOptions = {
  preset: ['default', {
    discardComments: {
      removeAll: true              // Eliminar todos los comentarios
    },
    normalizeWhitespace: true,     // Normalizar espacios
    colormin: true,                // Minimizar colores
    minifyFontValues: true,        // Minimizar valores de fuentes
    minifyGradients: true,         // Minimizar gradientes
    minifyParams: true,            // Minimizar parámetros
    minifySelectors: true,         // Minimizar selectores
    convertValues: {               // Convertir valores
      length: true                 // Optimizar longitudes (0px -> 0)
    },
    normalizeCharset: true,        // Normalizar @charset
    normalizeDisplayValues: true,  // Normalizar valores display
    normalizePositions: true,      // Normalizar posiciones
    normalizeRepeatStyle: true,    // Normalizar repeat-style
    normalizeString: true,         // Normalizar strings
    normalizeTimingFunctions: true,// Normalizar timing functions
    normalizeUnicode: true,        // Normalizar unicode
    normalizeUrl: true,            // Normalizar URLs
    orderedValues: true,           // Ordenar valores
    reduceInitial: true,           // Reducir initial values
    reduceTransforms: true,        // Reducir transforms
    svgo: true,                    // Optimizar SVG inline
    uniqueSelectors: true,         // Eliminar selectores duplicados
    mergeRules: true,              // Merge de reglas duplicadas
    mergeLonghand: true,           // Merge propiedades longhand
    discardOverridden: true,       // Eliminar propiedades sobrescritas
    calc: true,                    // Optimizar calc()
    zindex: false                  // No modificar z-index (puede romper cosas)
  }]
};

async function optimizeCSS() {
  console.log('🎨 Iniciando optimización de archivos CSS...\n');

  // Buscar todos los archivos .css en src/css
  const cssFiles = await glob('src/css/**/*.css');

  if (cssFiles.length === 0) {
    console.log('⚠️  No se encontraron archivos CSS en src/css/');
    return;
  }

  // Crear directorio de salida si no existe
  const outputDir = 'public/css';
  if (!fs.existsSync(outputDir)) {
    fs.mkdirSync(outputDir, { recursive: true });
  }

  let totalOriginalSize = 0;
  let totalMinifiedSize = 0;

  for (const file of cssFiles) {
    try {
      // Leer archivo
      const css = fs.readFileSync(file, 'utf8');
      const originalSize = Buffer.byteLength(css, 'utf8');

      // Obtener nombre del archivo
      const fileName = path.basename(file, '.css');
      const relativePath = path.relative('src/css', path.dirname(file));
      
      // Crear estructura de carpetas en public
      const outputSubDir = path.join(outputDir, relativePath);
      if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true });
      }

      // Procesar con PostCSS + cssnano
      const result = await postcss([cssnano(cssnanoOptions)])
        .process(css, {
          from: file,
          to: undefined
        });

      // Guardar archivo minificado
      const outputFile = path.join(outputSubDir, `${fileName}.min.css`);
      fs.writeFileSync(outputFile, result.css);

      const minifiedSize = Buffer.byteLength(result.css, 'utf8');
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
  console.log('📊 RESUMEN TOTAL DE OPTIMIZACIÓN CSS');
  console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
  console.log(`📁 Archivos procesados: ${cssFiles.length}`);
  console.log(`📦 Tamaño original: ${(totalOriginalSize / 1024).toFixed(2)} KB`);
  console.log(`📦 Tamaño minificado: ${(totalMinifiedSize / 1024).toFixed(2)} KB`);
  console.log(`💾 Reducción total: ${totalReduction}%`);
  console.log(`✨ Ahorro: ${((totalOriginalSize - totalMinifiedSize) / 1024).toFixed(2)} KB\n`);
}

optimizeCSS().catch(console.error);