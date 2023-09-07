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
          <Multiselect
            v-model="genes.value"
            mode="tags"
            :close-on-select="false"
            :searchable="true"
            :create-option="true"
            :options="genes"
            :disabled="false"
          />
          
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
            <option v-for="expriment in expriments" :key="expriment">{{ expriment }}</option>
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
import axios from 'axios';

import * as Vue from 'vue';

import Multiselect from '@vueform/multiselect'

export default {
  components: {
    Multiselect
  },
  data() {
    return {
      geneIds: [],
      disease: '',
      experiment: '',
      sra: '',
      genes: [], // Define your genes data here
      sras: [] ,  // Define your sras data here
      expriments: [], // Define your expriments data here
    }
  },
  mounted() {
    this.loadUniqueGeneIds();
    this.loadUniqueSras();
    this.loadUniqueExpriments();
  },
  methods: {
async select() {
  try {
    const geneIds = this.geneIds;
    const disease = this.disease;
    const experiment = this.experiment;
    const sra = this.sra;

    const url = 'http://127.0.0.1:8000/api/gene-data';
    const params = {
      gene_id: geneIds,
      disease: disease,
      experiment: experiment,
      sra: sra
    };

    const response = await axios.get(url, { params });
    // Do something with the response 
    console.log(response.data);
  } catch (error) {
    console.log(error);
  }
},
async loadUniqueGeneIds() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/unique-gene-ids');
        this.genes = response.data; // Assign the response data to the genes property
      } catch (error) {
        console.error(error);
      }
    },
async loadUniqueSras() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/unique-sras');
    this.sras = response.data; // Assign the response data to the sras property
  } catch (error) {
    console.error(error);
  }
  },
async loadUniqueExpriments() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/unique-expriments');
        this.expriments = response.data;
      } catch (error) {
        console.error(error);
      }
    },
  },
  }
</script>
<style src="@vueform/multiselect/themes/default.css" ></style>
<style >

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

