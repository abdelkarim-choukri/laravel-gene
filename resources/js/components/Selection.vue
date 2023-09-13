<template >
  <div >
        
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
              v-model="geneIds"
              mode="tags"
              :close-on-select="false"
              :searchable="true"
              :create-option="true"
              :options="genes"
              :disabled="false"
              placeholder="Select the gene ids"
            />
            
        </div>
  
        </div>
  
        <!-- Second Row - Select Disease, Select Expriment, Select SRA -->
        <div class="row">
          <div class="col-md-4 mb-3">
            <label class="mb-2">Select Disease:</label>
            <Multiselect
              v-model="disease"
              :options="diseases"
              placeholder="Search"
            />
          </div>
          <div class="col-md-4 mb-3">
            <label class="mb-2">Select Expriment:</label>
            <!-- <select class="form-control" id="expriment" v-model="expriment">
              <option value="All">All</option>
              <option v-for="expriment in expriments" :key="expriment">{{ expriment }}</option>
            </select> -->
            <Multiselect
              v-model="expriment"
              :options="expriments"
              placeholder="Search"
            />
          </div>
          <div class="col-md-4 mb-3">
            <label class="mb-2">Select SRA:</label>
            <!-- <select class="form-control" id="sra" v-model="sra">
              <option value="all">All</option>
              <option v-for="sra in sras" :key="sra">{{ sra }}</option>
            </select> -->
            <Multiselect
            v-model="sra"
              :options="sras"
              placeholder="Search"
            />
            
          </div>
        </div>
  
        <!-- Select Button -->
        <div class="mt-4 text-center">
          <button class="btn btn-primary w-50" @click="constructApiUrl">Select</button>
          
        </div>
      </div>
    </div>
    <Heatmap :apiUrl="apiUrlFromSelection"
             :nDiseases="this.diseases.length" 
             :sra="this.sra" 
             :abbreviation="this.abbreviation"
             :AbbCounts="this.AbbCounts"  /> 
    
    </div>
</template>

<script>
import axios from 'axios';

import * as Vue from 'vue';
import { ref,watch } from 'vue';
import Multiselect from '@vueform/multiselect'
import { watchEffect } from 'vue';
import Heatmap from './Heatmap.vue';

export default {
  components: {
    Multiselect,
    Heatmap
  },
  data() {
    return {
      geneIds:['LOC124900550', 'TDRD5', 'LOC124904954', 'LINC01224', 'LOC105370990'],
      disease: 'Autism',
      expriment: 'All',
      sra: 'All',
      genes:['LOC124900550', 'TDRD5', 'LOC124904954', 'LINC01224', 'LOC105370990'], // Define your genes data here
      sras: [] ,  // Define your sras data here
      expriments: [], // Define your expriments data here
      diseases: [],
      apiUrlFromSelection: '',
      abbreviation: [
    {
        "Abbreviation": "CT",
        "count": 30
    },
    {
        "Abbreviation": "PT",
        "count": 35
    }
],
      AbbCounts:{
    "CT": 6,
    "PT": 7
},
    }
  },
  mounted() {
    // console.log(this.AbbCounts);
    this.loadUniqueGeneIds();
    this.loadUniqueDiseases();
    this.loadUniqueAbbreviations();
    
    watchEffect(() => {

      if (this.disease === null ) {
        this.expriments = [{ value: 'sorry', label: 'sorry, no match options', disabled: true },];
        this.sras = [{ value: 'sorry', label: 'sorry, no match options', disabled: true },];
      } else {
        this.loadUniqueExpriments();
        this.loadUniqueSras();
      }
    }, [this.disease]);
  },

  methods: {


async loadUniqueGeneIds() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/unique-gene-ids');
        this.genes = response.data; // Assign the response data to the genes property
        // this.geneIds=['NR1H5P'];
      } catch (error) {
        console.error(error);
      }
    },
async loadUniqueSras() {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/possible-sras',
    {
      params: {
        gene_id: this.geneIds,
        disease: this.disease==='All' ? null : this.disease,
        expriment: this.expriment==='All' ? null : this.expriment,
      },
    });
     console.log('response',response.data)
    this.sras = ['All',...response.data]; // Assign the response data to the sras property
  } catch (error) {
    console.error(error);
  }
  },
async loadUniqueExpriments() {
      try {
    // const selectedGeneIds = this.geneIds;
    // const selectedDisease = this.disease;

    const response = await axios.get('http://127.0.0.1:8000/api/possible-expriments', {
      params: {
        gene_id: this.geneIds,
        disease: this.disease==='All' ? null : this.disease,
      },
    });

    this.expriments = ['All', ...response.data];
  } catch (error) {
    console.error(error);
  }
    },

async loadUniqueDiseases() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/diseases', {
          params: {
            gene_id: this.selectedGeneIds,
          },
        });
        this.diseases =['All',...response.data];

      } catch (error) {
        console.error(error);
      }
    },

async loadUniqueAbbreviations() {
  try {
    const { geneIds, disease, expriment, sra } = this;

 
    const modifiedDisease = disease === 'All' ? '' : disease;
    const modifiedExpriment = expriment === 'All' ? '' : expriment;
    const modifiedSra = sra === 'All' ? '' : sra;

    const response = await axios.get('http://127.0.0.1:8000/api/unique-abbreviation', {
      params: {
        gene_id: geneIds,
        disease: modifiedDisease,
        expriment: modifiedExpriment,
        sra: modifiedSra,
      },
    });
    console.log('d' ,response.data);
    this.abbreviation = response.data;
  } catch (error) {
    console.error(error);
  }
},

constructApiUrl() {
  const { geneIds, disease, expriment, sra } = this;
  const baseUrl = 'http://127.0.0.1:8000/api/gene-data';
  const queryParams = [];

  if (geneIds.length > 0) {
    queryParams.push(`gene_id[]=${geneIds.join('&gene_id[]=')}`);
  }

  if (disease !== 'All') {
    queryParams.push(`disease=${disease}`);
  }

  if (expriment !== 'All') {
    queryParams.push(`expriment=${expriment}`);
  }

  if (sra !== 'All') {
    queryParams.push(`sra=${sra}`);
  }

  const queryString = queryParams.length > 0 ? `?${queryParams.join('&')}` : '';

  this.apiUrlFromSelection = baseUrl + queryString;
  this.loadUniqueAbbreviations();
  this.loadData(this.apiUrlFromSelection);

},
async loadData(url) {
  try {
    const response = await axios.get(url);
    const data = response.data; // Get the response data

    // Create sets to store unique SRA values for CT and PT
    const uniqueSRA_CT = new Set();
    const uniqueSRA_PT = new Set();

    // Iterate through the data and add unique SRA values to the respective sets
    data.forEach(item => {
      if (item.Abbreviation === 'CT') {
        uniqueSRA_CT.add(item.SRA);
      } else if (item.Abbreviation === 'PT') {
        uniqueSRA_PT.add(item.SRA);
      }
    });

    // Get the size (count) of unique SRA values in each set
    const countUniqueSRA_CT = uniqueSRA_CT.size;
    const countUniqueSRA_PT = uniqueSRA_PT.size;

    // Create an object to hold the counts
    const counts = {
      CT: countUniqueSRA_CT,
      PT: countUniqueSRA_PT
    };

    
    this.AbbCounts=counts; // Pass the counts object to the callback function
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
  
  .multiselect-option.is-disabled{
    color:grey !important;
  }
  .multiselect-tag {
    background-color: #F0F0F0 !important;
    color: #797373 !important;
    font: 16px  ;
  }
  
</style>

