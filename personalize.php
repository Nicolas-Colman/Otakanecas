<?php include 'conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Otakaneca - Personalize sua Caneca</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #0f0f0f;
      color: #e0e0e0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: url('imagens/fundo.png') no-repeat center center/cover;
      filter: blur(18px);
      z-index: -1;
      opacity: 0.6;
    }
    header {
      background: #1a1a1a;
      padding: 20px;
      text-align: center;
      color: #0ff;
      font-size: 2em;
      text-shadow: 0 0 10px #0ff;
      flex-shrink: 0;
    }
    nav {
      background: #121212;
      padding: 10px 0;
      text-align: center;
      box-shadow: 0 0 10px #0ff5;
      margin-bottom: 10px;
      flex-shrink: 0;
    }
    nav a {
      color: #0ff;
      text-decoration: none;
      font-weight: 600;
      margin: 0 20px;
      font-size: 1.1em;
      padding: 6px 12px;
      border-radius: 6px;
      transition: background-color 0.3s, box-shadow 0.3s;
      display: inline-block;
    }
    nav a:hover {
      background-color: #0ff;
      color: #000;
      box-shadow: 0 0 15px #0ff;
    }

    main {
      flex-grow: 1;
      position: relative;
      display: flex;
      background: transparent;
    }

    /* Canvas 3D ocupa o espaço disponível */
    #scene-container {
      flex-grow: 1;
      display: block;
    }

    /* Botão voltar */
    #voltar {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 10;
      background: #0ff;
      color: #000;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      user-select: none;
      font-weight: 600;
      box-shadow: 0 0 8px #0ffaaaff;
      transition: background-color 0.3s ease;
    }
    #voltar:hover {
      background-color: #06c;
      color: #fff;
      box-shadow: 0 0 12px #06c;
    }

    /* Controles de envio da estampa */
    #controls {
      position: absolute;
      top: 20px;
      right: 20px;
      z-index: 10;
      background: rgba(255 255 255 / 0.9);
      padding: 10px 15px;
      border-radius: 8px;
      color: #000;
      font-family: sans-serif;
      user-select: none;
    }
    #controls label {
      cursor: pointer;
      font-weight: 600;
      user-select: none;
    }
    #uploadTexture {
      display: none;
    }

    /* Responsividade */
    @media(max-width: 600px) {
      nav a {
        margin: 0 10px;
        font-size: 1em;
      }
      #voltar, #controls {
        top: 10px;
        padding: 8px 12px;
      }
    }
  </style>
</head>
<body>
  <header>Otakaneca - Personalize sua Caneca</header>

  <nav>
    <a href="index.php">Catálogo</a>
    <a href="nos.php">Quem Somos</a>
    <a href="personalize.php">Personalize</a>
  </nav>

  <main>
    <canvas id="scene-container"></canvas>

    <button id="voltar" onclick="window.location.href='index.php'">← Voltar para Catálogo</button>

    <div id="controls">
      <label for="uploadTexture">Enviar Estampa 🎨</label>
      <input type="file" id="uploadTexture" accept="image/*" />
    </div>
  </main>

  <script type="module">
    import * as THREE from 'https://esm.sh/three@0.160.0';
    import { OrbitControls } from 'https://esm.sh/three@0.160.0/examples/jsm/controls/OrbitControls.js';
    import { MTLLoader } from 'https://esm.sh/three@0.160.0/examples/jsm/loaders/MTLLoader.js';
    import { OBJLoader } from 'https://esm.sh/three@0.160.0/examples/jsm/loaders/OBJLoader.js';

    const canvas = document.getElementById('scene-container');
    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
    renderer.setSize(window.innerWidth, window.innerHeight - 120); // header + nav = aprox 120px
    renderer.setPixelRatio(window.devicePixelRatio);

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x000000);

    const camera = new THREE.PerspectiveCamera(45, window.innerWidth / (window.innerHeight - 120), 0.1, 100);
    camera.position.set(0, 1.5, 3);

    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const dirLight = new THREE.DirectionalLight(0xffffff, 1.5);
    dirLight.position.set(5, 10, 5);
    scene.add(dirLight);

    const textureLoader = new THREE.TextureLoader();

    const canecaMaterial = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.5,
      metalness: 0
    });

    let estampaMaterial;
    let objetoCaneca;

    function trocarMaterialEstampa(novoMaterial) {
      if (!objetoCaneca) return;
      objetoCaneca.traverse((child) => {
        if (child instanceof THREE.Mesh) {
          if (Array.isArray(child.material)) {
            child.material = child.material.map((mat) => {
              if (mat.name === 'estampa') {
                return novoMaterial;
              }
              return mat;
            });
          } else {
            if (child.material.name === 'estampa') {
              child.material = novoMaterial;
            }
          }
        }
      });
    }

    function iniciarCarregamentoModelo() {
      const mtlLoader = new MTLLoader();
      mtlLoader.load('assets/caneca.mtl', (materials) => {
        materials.preload();

        const objLoader = new OBJLoader();
        objLoader.setMaterials(materials);

        objLoader.load('assets/caneca.obj', (object) => {
          objetoCaneca = object;

          objetoCaneca.traverse((child) => {
            if (child instanceof THREE.Mesh) {
              console.log(`Mesh '${child.name}' material nome:`, child.material.name);
            }
          });

          trocarMaterialEstampa(estampaMaterial);

          objetoCaneca.traverse((child) => {
            if (child instanceof THREE.Mesh) {
              if (child.material.name === 'caneca') {
                child.material = canecaMaterial;
              }
            }
          });

          objetoCaneca.scale.set(0.05, 0.05, 0.05);
          objetoCaneca.position.y = -0.4;
          scene.add(objetoCaneca);
        }, undefined, (err) => {
          console.error('Erro ao carregar OBJ:', err);
        });
      }, undefined, (err) => {
        console.error('Erro ao carregar MTL:', err);
      });
    }

    // Carrega textura padrão
    textureLoader.load('assets/estampa.jpg', (texture) => {
      texture.encoding = THREE.sRGBEncoding;
      texture.anisotropy = 8;
      texture.wrapS = THREE.ClampToEdgeWrapping;
      texture.wrapT = THREE.ClampToEdgeWrapping;
      texture.repeat.set(1, 1);
      texture.offset.set(0, 0);

      estampaMaterial = new THREE.MeshStandardMaterial({
        map: texture,
        color: 0xffffff,
        roughness: 0.4,
        metalness: 0,
        emissive: 0x111111,
        emissiveMap: texture,
        name: 'estampa'
      });

      iniciarCarregamentoModelo();
    });

    document.getElementById('uploadTexture').addEventListener('change', (event) => {
      const file = event.target.files[0];
      if (!file) return;

      const url = URL.createObjectURL(file);
      textureLoader.load(url, (tex) => {
        tex.encoding = THREE.sRGBEncoding;
        tex.anisotropy = 8;
        tex.wrapS = THREE.ClampToEdgeWrapping;
        tex.wrapT = THREE.ClampToEdgeWrapping;
        tex.repeat.set(1, 1);
        tex.offset.set(0, 0);

        const novoMaterial = new THREE.MeshStandardMaterial({
          map: tex,
          color: 0xffffff,
          roughness: 0.4,
          metalness: 0,
          emissive: 0x111111,
          emissiveMap: tex,
          name: 'estampa'
        });

        trocarMaterialEstampa(novoMaterial);

        URL.revokeObjectURL(url);
      });
    });

    function animate() {
      requestAnimationFrame(animate);
      controls.update();
      renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
      renderer.setSize(window.innerWidth, window.innerHeight - 120);
      camera.aspect = window.innerWidth / (window.innerHeight - 120);
      camera.updateProjectionMatrix();
    });
  </script>
</body>
</html>
