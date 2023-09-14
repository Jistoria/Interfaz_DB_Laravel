<template>
    <title>Welcome</title>
<div class="container ">
    <div class="row align-items-center" id="columnas">
      <div class="col-md-6">

        <div class="information text-justify">
          <h2 class="text-center" style="color:rgb(103, 62, 142)">ValoTech</h2>
          <p>Bienvenido a nuestra tienda en línea de electrónica. Nos complace ofrecerte una amplia gama de productos electrónicos de calidad para satisfacer tus necesidades tecnológicas. En nuestra tienda, encontrarás una selección cuidadosamente curada de productos, desde ratones ergonómicos y de alta precisión, hasta auriculares con cancelación de ruido y tarjetas de memoria RAM de alto rendimiento.</p>
          <p>Trabajamos con reconocidas marcas y fabricantes de renombre en la industria electrónica para garantizar la calidad y confiabilidad de nuestros productos. Nuestro catálogo incluye una variedad de opciones, desde marcas líderes en el mercado hasta opciones más asequibles sin comprometer la calidad.</p>
        </div>
      </div>
      <div class="col-md-6">
        <div id="carouselExample"  class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img  width=540 height=350 src= https://www.servnet.mx/hubfs/Blog/Blog_Articulos/Blog_Art%C3%ADculos/Blog_Articulos_2022_Noviembre/Blog_Articulos_2022_Noviembre_Art11_TECE/Robotica-como-tecnologia-emergente.png class="d-block " alt="Image 1">
            </div>
            <div class="carousel-item">
              <img  width=540 height=350 src=https://imagenes.20minutos.es/files/og_thumbnail/uploads/imagenes/2023/02/13/jugador-jugando-vista-lateral-interior-gamer-gaming-afiliacion.jpeg class="d-block " alt="Image 2">
            </div>
            <div class="carousel-item">
              <img width=540 height=350 src=https://images2.alphacoders.com/123/1231556.png class="d-block " alt="Image 3">
            </div>
          </div>
        </div>
        <div class="carousel-controls">
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
          </button>
        </div>
      </div>
    </div>
      <div class="row ">
      <div class="col-md-16" id="contenedor">
        <section class="info-section">
          <div class="container">
            <div class="info-content">
              <h3>¿Quiénes somos?</h3>
              <div class="sub-section">
                <h4>Meta:</h4>
                <p>Nosotros somos un grupo de estudiantes realizando un proyecto de la materia Interfaces Humano Computador, en la cual creamos este prototipo de interfaz sobre un sistema de comprar y venta de productos electronicos</p>
              </div>
              <div class="sub-section">
                <h4>Integrantes</h4>
                <ul>
                  <li>Padilla Espinar Carlos</li>
                  <li>Cañizares Mantuano Gustavo</li>
                  <li>Mieles Alvarez Diego</li>
                  <li>Meneses Tuarez William</li>
                </ul>
              </div>
              <div class="sub-section">
                <h4>Profesor</h4>
                <p>Ing. William Zamora Mero, PHD</p>
              </div>
              <div class="sub-section">
                <h4>Facultad</h4>
                <p>Ciencias de la Vida y Tecnologia</p>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

</template>

<script>
import axios from 'axios';
export default {

}

</script>

