<template>
  <div class=" container .selection-class box shadow-lg rounded" >
    <div class="text-center "  id="heatmap">
    </div>
</div>

</template>
<script>
import { ref, onMounted, watch } from 'vue';

export default {
  name: 'Heatmap',
  props: {
    apiUrl: String, // Assuming apiUrl is passed as a string
    nDiseases: Number,
    sra: String,
  },
  setup(props) {
    const chartData = ref(null);
    // const dataTable = new google.visualization.DataTable();
    let chart = null; // Variable to store the chart instance
    const chartOptions = ref(null); // Variable to store chart options

// Function to redraw the chart with the updated URL
const redrawChart = (newApiUrl) => {
  if (chart && chartOptions.value) {
    chartOptions.value.vega.data[0].url = newApiUrl; // Update the URL in the chart options
    console.log('chartOptions', chartOptions.value);
    chart.draw(new google.visualization.DataTable(), chartOptions.value); // Redraw the chart with updated options
  }
};

    // Create a watch function to react to changes in the apiUrl prop
    watch(
      () => props.apiUrl,
      (newApiUrl, oldApiUrl) => {
        // apiUrl has changed, update the chart
        if (newApiUrl !== oldApiUrl) {
          // const asr= newApiUrl.split('&sra=')[1] === null ? null : newApiUrl.split('&sra=')[1];
          // console.log('asr',asr)
          console.log("props.sra",props.sra)
          if (props.sra  == 'All'){ 
            console.log(props.nDiseases)
            chartOptions.value.vega.marks[0].encode.enter.width.value = 50;
            console.log("chartOptions.value.vega.marks[0].encode.enter.width.value",chartOptions.value.vega.marks[0].encode.enter.width.value)
            chartData.value = newApiUrl; // Update chart data (you can also trigger a chart redraw here)
          redrawChart(newApiUrl); // Redraw the chart with the updated URL
          }else{
            chartOptions.value.vega.marks[0].encode.enter.width.value = 500; // Update chart data (you can also trigger a chart redraw here)
            redrawChart(newApiUrl); // Redraw the chart with the updated URL
          }
        } 
      }
    );


    onMounted(() => {
      // Load Google Charts and initialize the chart
      const url = props.apiUrl == null? "http://127.0.0.1:8000/api/gene-data?gene_id[]=NR1H5P&disease=Disease&expriment=&sra=": props.apiUrl;
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
                  "text": "Heatmap",
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
                    "range": "width"

                  },
                  {
                    "name": "y",
                    "type": "band",
                    "domain": {"data": "gene_data", "field": "gene_id"},
                    "range": "height",
                    
                    
                  },
                  {
                    "name": "color",
                    "type": "linear",
                    "range": {"scheme": "redyellowblue"},
                    "domain": {"data": "gene_data", "field": "value"},
                    "reverse": true,
                    "zero": false, "nice": true
                  }
                ],

                "axes": [
                  {"orient": "bottom", "scale": "x", "domain": false, "title": "SRA"},
                  {
                  "orient": "left",
                  "scale": "y",
                  "domain": false,
                  "title": "Gene ID",
                  
                }
                ],

                "legends": [
                  {
                    "fill": "color",
                    "type": "gradient",
                    "title": "Value",
                    "titleFontSize": 12,
                    "titlePadding": 4,
                    "gradientLength": {"signal": "height - 16"}
                  }
                ],

                "marks": [
                  {
                    "type": "rect",
                    "from": {"data": "gene_data"},
                    "encode": {
                      "enter": {
                        "x": {"scale": "x", "field": "SRA"},
                        "y": {"scale": "y", "field": "gene_id"},
                        "width": {"value": 500/12},
                        "height": {"scale": "y", "band": 1},
                        "tooltip": {
                          "signal":
                            "datum.SRA + ' - ' + datum.gene_id + ': ' + datum.value"
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

</style>
