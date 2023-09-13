<template>
 <div class="container .selection-class box shadow-lg rounded mycss "  >
  <h1 class="color font-weight-bold h1 ">Heatmap</h1>
  <!-- <div class="map "
       :style="{
          backgroundColor: 'green',
      
       }"
  ></div> -->
  <div class="map">
    <div class="colored-section row" :style="{
      'width': getWidthForAbbreviation('CT') + getWidthForAbbreviation('PT'),
      'height': '100%',
      'padding': '0px 0px 0px 0px',
    }">
      <div class="red-section" :style="{
        'width': getWidthForAbbreviation('CT'),
        'height': '100%',
        'background-color': 'red',
        'padding': '0px 0px 0px 0px',
        
      }"></div>
      <div class="blue-section" :style="{
        'width': getWidthForAbbreviation('PT'),
        'height': '100%',
        'max-width': '510px',
        'background-color': 'blue',
        'padding': '0px 0px 0px 0px',
        'border-radius': '3px',

      }" ></div>
    </div>
  </div>
  <div class="heatmapClass" id="heatmap" ></div> <!-- Set a fixed height and enable overflow -->
  
  <hr>
  <strong>Abbreviation:</strong>
  <div class="container">
    <div class="abbreviation-container" v-for="(abbr, index) in this.abbreviation" :key="index">
      <div class="square"
           :style="{
             'background-color': abbr.Abbreviation === 'CT' ? 'red' : 'blue',
           }"
      ></div>
      <div class="abbreviation">{{ abbr.Abbreviation }}</div>
    </div>
  </div>
</div>



</template>
<script>
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';


// async function loadData(url) {
//   try {
//     const response = await axios.get(url);
//     const data = response.data; // Get the response data

//     // Create sets to store unique SRA values for CT and PT
//     const uniqueSRA_CT = new Set();
//     const uniqueSRA_PT = new Set();

//     // Iterate through the data and add unique SRA values to the respective sets
//     data.forEach(item => {
//       if (item.Abbreviation === 'CT') {
//         uniqueSRA_CT.add(item.SRA);
//       } else if (item.Abbreviation === 'PT') {
//         uniqueSRA_PT.add(item.SRA);
//       }
//     });

//     // Get the size (count) of unique SRA values in each set
//     const countUniqueSRA_CT = uniqueSRA_CT.size;
//     const countUniqueSRA_PT = uniqueSRA_PT.size;

//     // Create an object to hold the counts
//     const counts = {
//       CT: countUniqueSRA_CT,
//       PT: countUniqueSRA_PT
//     };

//     console.log('counts',counts);
//     this.AbbCounts=counts; // Pass the counts object to the callback function
//   } catch (error) {
//     console.error(error);
//   }
// }


export default {
  name: 'Heatmap',
  data() {
    return {
      previousColor: null,
      // AbbCounts:{},
    }
  },
  props: {
    apiUrl: String, // Assuming apiUrl is passed as a string
    nDiseases: Number,
    sra: String,
    abbreviation: Array,
    AbbCounts: Object,
  },
  methods: {
    getRandomColor() {
      const colors = ['red', 'yellow', 'blue', 'green', 'orange', 'purple', 'pink', 'brown', 'black', 'gray', 'cyan', 'magenta', 'indigo'];
  let randomIndex;

  // Ensure that the next color is not the same as the previous one
  do {
    randomIndex = Math.floor(Math.random() * colors.length);
  } while (colors[randomIndex] === this.previousColor);

  this.previousColor = colors[randomIndex];
  return colors[randomIndex];
    },

getWidthForAbbreviation( abbr) {
  // Use the obj object to determine the width based on the Abbreviation
  let Cabbr=abbr
  // console.log('Cabbr',this.AbbCounts.CT)
  if (Cabbr === 'CT') {
    if(this.AbbCounts.PT==0){
      return '510px';
    }
    return this.AbbCounts.CT>0 ? ((510/(this.AbbCounts.CT+this.AbbCounts.PT))*this.AbbCounts.CT ) + 'px' : '0px';
  } else if (Cabbr === 'PT') {
    if(this.AbbCounts.CT==0){
      return '510px';
    }
    return this.AbbCounts.PT>0 ? ((510/(this.AbbCounts.CT+this.AbbCounts.PT))*this.AbbCounts.PT ) + 'px' : 'px';
  }
  
},

getDivDisplay( abbr) {
  let Cabbr=abbr
  console.log('Cabbr',Cabbr)
  // Use the this.AbbCounts this.AbbCountsect to determine the display value based on the Abbreviation
  if ((Cabbr === 'CT' && this.AbbCounts.CT == 0) || (Cabbr === 'PT' && this.AbbCounts.PT == 0)) {
    return 'block';
  }

  return 'none';
},





  },
 
 
  setup(props) {
  
    
    const AbbCounts = ref({});
    const chartData = ref(null);
    // const dataTable = new google.visualization.DataTable();
    let chart = null; // Variable to store the chart instance
    const chartOptions = ref(null); // Variable to store chart options
  //  const abbrev =props.abbreviation
  //  console.log('abbrev',abbrev)
   

// Function to redraw the chart with the updated URL
const redrawChart = (newApiUrl) => {
  if (chart && chartOptions.value) {
    // abbrev =props.abbreviation
    chartOptions.value.vega.data[0].url = newApiUrl; // Update the URL in the chart options
    console.log('chartOptions', chartOptions.value);
    chart.draw(new google.visualization.DataTable(), chartOptions.value); // Redraw the chart with updated options
  }
  // console.log('abbrev',abbrev)
};
const loadData = async (url) => {
      try {
        const response = await axios.get(url);
        const data = response.data;

        const uniqueSRA_CT = new Set();
        const uniqueSRA_PT = new Set();

        data.forEach(item => {
          if (item.Abbreviation === 'CT') {
            uniqueSRA_CT.add(item.SRA);
          } else if (item.Abbreviation === 'PT') {
            uniqueSRA_PT.add(item.SRA);
          }
        });

        const countUniqueSRA_CT = uniqueSRA_CT.size;
        const countUniqueSRA_PT = uniqueSRA_PT.size;

        AbbCounts.value = {
          CT: countUniqueSRA_CT,
          PT: countUniqueSRA_PT
        };
        console.log('AbbCounts',AbbCounts.value)
      } catch (error) {
        console.error(error);
      }
    };




    // Create a watch function to react to changes in the apiUrl prop
    watch(
      () => props.apiUrl,
      (newApiUrl, oldApiUrl) => {
        // apiUrl has changed, update the chart
        console.log('Heatmap D',props.abbreviation)
        if (newApiUrl !== oldApiUrl) {
          // const asr= newApiUrl.split('&sra=')[1] === null ? null : newApiUrl.split('&sra=')[1];
          // console.log('asr',asr)
          console.log("props.sra",props.sra)

          if (props.sra  == 'All'){ 
            console.log(props.nDiseases)
            chartOptions.value.vega.marks[0].encode.enter.width.value = 50;
            
            chartData.value = newApiUrl; // Update chart data (you can also trigger a chart redraw here)
          redrawChart(newApiUrl); // Redraw the chart with the updated URL
          }else{
            chartOptions.value.vega.marks[0].encode.enter.width.value = 500; // Update chart data (you can also trigger a chart redraw here)
            redrawChart(newApiUrl); // Redraw the chart with the updated URL
          }
          console.log('Heatmap D',props.abbreviation)
        } 
        loadData(newApiUrl);
      }
    ),
    
    onMounted(() => {
      // Load Google Charts and initialize the chart
      const url = props.apiUrl == undefined || props.apiUrl == '' ? " http://127.0.0.1:8000/api/gene-data?gene_id[]=TDRD5&gene_id[]=LOC124904954&gene_id[]=LOC124900550&gene_id[]=PRKG1-AS1&gene_id[]=LINC01224&gene_id[]=LOC105370990&disease=Autism": props.apiUrl;
      
      google.charts.load('upcoming', { packages: ['vegachart'] }).then(() => {
        google.charts.setOnLoadCallback(() => {
        const dataTable = new google.visualization.DataTable();
        
        console.log('url',url);
        chartOptions.value = {
          'vega': {
                "$schema": "https://vega.github.io/schema/vega/v5.json",
                "width": 500,
                "height": 500,
                "padding": 5,

                "title": {
                  "text": "",
                  "anchor": "middle",
                  "fontSize": 16,
                  "frame": "group",
                  "offset": 4
                },

                "data": [
                  {
                    "name": "gene_data", // Name of your data set
                    "url":   url,
                    "format": {"type": "json"},}
                ],

                "scales": [
                  {
                    "name": "x",
                    "type": "band",
                    "domain": {"data": "gene_data", "field": "SRA"},
                    "range": "width",
                    

                  },
                  {
                    "name": "y",
                    "type": "band",
                    "domain": {"data": "gene_data", "field": "gene_id"},
                    "range": "height",
                    
                    
                  },
                  {
                    "name": "color",
                    "type": "pow",
                    "range": {"scheme": "redyellowblue"},
                    "domain": {"data": "gene_data", "field": "value"},
                    "reverse": true,
                    "zero": false, "nice": true
                  },
                  // {
                  //   "name": "ador",
                  //   "type": "band", // Use a band scale for categorical data
                  //   "domain": {"data": "gene_data", "field": "Abbreviation"},
                  //   "range": "width",
                  //   "padding": 0.1 // Adjust padding as needed
                  // }
                ],

                "axes": [
                  {"orient": "bottom", "scale": "x", "domain": false, "title": "SRA"},
                  {
                  "orient": "left",
                  "scale": "y",
                  "domain": false,
                  "title": "Gene ID",
                  
                },
                // {
                //   "orient": "top",
                //   "scale": "ador",
                //   "domain": false,
                //   "title": "Abbreviation"
                // }
                ],

                "legends": [
                  {
                    "fill": "color",
                    "type": "gradient",
                    "title": "Value",
                    "titleFontSize": 12,
                    "titlePadding": 4,
                    "gradientLength": {"signal": "height - 16"}
                  },
                  
                ],

                "marks": [
                  {
                    "type": "rect",
                    "from": {"data": "gene_data"},
                    "encode": {
                      "enter": {
                        "x": {"scale": "x", "field": "SRA"},
                        "y": {"scale": "y", "field": "gene_id"},
                        "abbr": {"scale": "ador", "field": "Abbreviation"},
                        "width": {"value": 500/12},
                        "height": {"scale": "y", "band": 1},
                        "tooltip": {
                          "signal":
                            "datum.SRA + ' - ' + datum.gene_id + ': ' + datum.value + ' (' + datum.Abbreviation + ')'"
                        }
                      },
                      "update": {
                        "fill": {"scale": "color", "field": "value"}
                      }
                    }
                  }
                ]
              }
        };                               
        console.log('chartOptions.value',chartOptions.value.vega.marks[0].encode.enter.width.value);

        chart = new google.visualization.VegaChart(document.getElementById('heatmap'));
        chart.draw(dataTable, chartOptions.value);
        
      });
      });
      


      
    });
    return {
      chartData,
      loadData,
    };
  },

};
</script>


<style>
.container {
  max-width: 960px;
  margin: 0 auto;
  margin-bottom: 40px !important;
}
.selection-class {
  background-color: #fff;
  padding: 20px;
}
.abbreviation-container {
  display: flex;
  align-items: center;
  margin-bottom: 10px; /* Adjust the margin as needed */
}

.square {
  width: 20px;
  height: 20px;
  margin-right: 10px; /* Adjust the margin as needed */
}

.abbreviation {
  font-weight: bold;
 
}
.mycss{
  overflow: auto;
}
/* .map {
  /* margin: auto; */
  /* padding-left: 30px; */
  
  /* width: 500px;
  min-width: 500px; /* 
  height: 7px;
  border-radius: 3px;
  margin-left:211px; */
/* } */ 
.h1{
  /* margin-left:211px; */
/* margin: auto; */
margin-left:350px;

}
.heatmapClass{
  margin-left:112px;
}

.map {
  /* Your existing styles */
  /* width: 500px;
  min-width: 500px; */
  height: 8px;
  border-radius: 3px;
  margin-left: 212px;
  margin-bottom: -20px;
  overflow: hidden; /* Hide overflow to prevent child elements from spilling out */
  position: relative; /* Position relative to contain absolute child elements */
  /* border-radius:3px, */

}

/* .red-section {
  width: 250px;
  height: 100%;
  background-color: red;
  position: absolute;
  left: 0;
} */

/* .blue-section {
  width: 250px;
  height: 100%;
  background-color: blue;
  position: absolute;
  left: 100px; /* Position the blue section after the red section */


</style>
