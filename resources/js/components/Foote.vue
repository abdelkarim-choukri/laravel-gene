
<template>
<footer class="bg-light mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <img src="/images/agc_logo.png" alt="agc" class="img-fluid" />
                </div>
                <div class="col-md-8">
                    <div class="row center-row">
                        <div class="col-md-12 ">
                            <img src="/images/Heatmap.svg" alt="Image 2" class="img-fluid custom-img"  />
                        </div>
                        <div class="col-md-12 mt-3 ">
                            <p>
                                2023 © Mentalome is freely available for non-commercial use with proper citations.
                            </p>
                        </div>
                        <div class="col-md-12 mt-3 ">
                            <p>
                                <a href="https://bioinformatics.um6p.ma">bioinformatics.um6p.ma</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">            
                    <img src="/images/um6p_logo.png" alt="Image 3" class="img-fluid" />            
                </div>
            </div>
        </div>
    </footer>
  
</template>
<script>
  export default {
  name: 'Foote',
}
</script>
<style scoped>
/* Custom CSS for the image size */
.custom-img {
  width: 150px;
  height: 56px;
}
footer {
  padding-top: 3% !important;
  background-color: #36383a !important;
  color: white;
}
</style>