<template>
  <header >
      <nav class="navbar navbar-expand-lg navbar-light bg-light bg-custom">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="/images/Heatmap.svg" alt="Logo" class="custom-img  img-fluid" />
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ml-auto">
                        <a class="nav-link Homebtn" href="/">Home</a>
                    </li>
                </ul>
            </div>
        </div>
        </nav>
    </header>
    <div class="container mt-5 text1" >
        <h1 class="text-center font-weight-bold text-white ">
            Mentalome: Unveiling the Complex Landscape of Psychiatric Disorders through Comprehensive Transcriptome Analysis
        </h1>
        </div>
</template>
<script>
  export default {
  name: 'Heade',
}
</script>
<style scoped>
/* Custom CSS for the image size */
.custom-img {
  width: 150px;
  height: 56px;
}
.bg-custom {
  background-color: #6E85B7 !important;
}
.container.text1 {
  background-color: #6E85B7 !important;
  margin-bottom: 3% !important;
}

.Homebtn{
  color: #ffc56c!important;
}


</style>