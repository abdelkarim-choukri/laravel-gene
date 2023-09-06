<template >
  <div class="container selection-class mb-3 selec">
    <div class="box shadow-lg rounded ">
      <div class="text-center mb-5 mt-4">
        <h1 class="color font-weight-bold ">Mentalome</h1>
      </div>

      <!-- First Row - Select gene ids -->
      <div class="form-row">
        <div class="form-group col-md-12 mt-3">
          <label class="mb-2">Select gene ids:</label>
          <select class="form-control" id="geneIds" multiple v-model="geneIds">
            <option v-for="gene in genes" :key="gene">{{ gene }}</option>
          </select>
        </div>
      </div>

      <!-- Second Row - Select Disease, Select Experiment, Select SRA -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="mb-2">Select Disease:</label>
          <select class="form-control" id="disease" v-model="disease">
            <option value="Autism">Autism</option>
            <option value="Cancer">Cancer</option>
            <option value="Heart disease">Heart disease</option>
            <option value="Diabetes">Diabetes</option>
            <option value="Stroke">Stroke</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label class="mb-2">Select Experiment:</label>
          <select class="form-control" id="experiment" v-model="experiment">
            <option value="All">All</option>
            <option value="Experiment 1">Experiment 1</option>
            <option value="Experiment 2">Experiment 2</option>
            <option value="Experiment 3">Experiment 3</option>
            <option value="Experiment 4">Experiment 4</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label class="mb-2">Select SRA:</label>
          <select class="form-control" id="sra" v-model="sra">
            <option value="all">All</option>
            <option v-for="sra in sras" :key="sra">{{ sra }}</option>
          </select>
          
        </div>
      </div>

      <!-- Select Button -->
      <div class="mt-4 text-center">
        <button class="btn btn-primary w-50" v-on:click="select">Select</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      geneIds: [],
      disease: '',
      experiment: '',
      sra: '',
      genes: [], // Define your genes data here
      sras: []   // Define your sras data here
    }
  },
  methods: {
    clearSra() {
      this.sra = '';
    },
    select() {
      // Add your logic for the "Select" button action here
    }
  }
}
</script>

<style>
.selection-class {
  background-color: #fff;
  padding: 20px;
}
.container {
  max-width: 960px;
  margin: 0 auto;
}

.box {
  padding: 20px;
}

.form-row {
  margin-bottom: 15px;
}

.form-group {
  margin-bottom: 10px;
}

.select-input {
  width: 100%;
}
.color {
  color: #6e85b7!important;
}

.form-row d-flex align-items-stretch {
  justify-content: space-between;}
  
  
</style>


