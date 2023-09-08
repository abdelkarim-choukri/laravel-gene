<template>
  <div class="container selection-class mb-3 selec" id="heatmap"></div>

</template>

<script>
export default {
  name: 'Heatmap',
  mounted() {
    // Load Google Charts and initialize the chart in the mounted hook
    google.charts.load('upcoming', { packages: ['vegachart'] }).then(() => {
      // A DataTable is required, but it can be empty.
      const dataTable = new google.visualization.DataTable();

      const options = {
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
      "url": "http://127.0.0.1:8000/api/gene-data?gene_id[]=A1BG&gene_id[]=A2M&gene_id[]=A3GALT2&Disease=Autism&Expriment=PRJNA143369&SRA=SRR309133",
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
          "width": {"value": 500},
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

      const chart = new google.visualization.VegaChart(document.getElementById('heatmap'));
      chart.draw(dataTable, options);
    });
  }
}

// import axios from 'axios';

// import * as Vue from 'vue';
// import google from 'google-charts';

// // Initialize Google Charts when your app is ready
// google.charts.load('current', {
//   packages: ['corechart'],
//   callback: function () {
//     drawChart1();
//     drawChart2();
//   }
// });
// google.charts.setOnLoadCallback(initializeCharts);

// // function initializeCharts() {
// //   // Your chart initialization code here
// // }


// export default {
//   name: 'Heatmap',
//   data () {
//     return {
//       data: {
//         gene_ids: [],
//         disease: '',
//         experiment: '',
//         sra: ''
//       }
//     }
//   },
//   mounted () {
//     const url = 'http://127.0.0.1:8000/api/gene-data';
//     const params = {
//       gene_id: this.gene_ids,
//       disease: this.disease,
//       experiment: this.experiment,
//       sra: this.sra
//     };
//     axios.get(url, { params })
//       .then(response => {
//         this.data.data = response.data;
//         const vegaSpec = vegaLite.parse(
//           `
//         {
//             data: {
//                 url: './data/heatmap.json'
//             },
//             mark: 'rect',
//             encoding: {
//                 x: {
//                 field: 'x',
//                 type: 'ordinal'
//                 },
//                 y: {
//                 field: 'y',
//                 type: 'ordinal'
//                 },
//                 color: {
//                 field: 'value',
//                 type: 'quantitative',
//                 scale: {
//                     range: ['red', 'blue']
//                 }
//                 }
//             }
//         }
//       `
//         );
//         vega.embed('#heatmap', vegaSpec);
//       })
//       .catch(error => {
//         console.log(error);
//       });

//       google.charts.setOnLoadCallback(() => {
//       axios
//         .get(url, { params })
//         .then(response => {
//           this.data.data = response.data;
//           const vegaSpec = Vue.vegaLite.parse(/* ... your Vega-Lite spec ... */);
//           Vue.vega.embed('#heatmap', vegaSpec);
//         })
//         .catch(error => {
//           console.log(error);
//         });
//     });

//   }
// }

</script>