<template>

    <div id="heatmap"></div>

</template>
<script>



export default {
  name: 'Heatmap',
  data () {
    return {
      data: {
        gene_ids: [],
        disease: '',
        experiment: '',
        sra: ''
      }
    }
  },
  mounted () {
    const url = 'http://127.0.0.1:8000/api/gene-data';
    const params = {
      gene_id: this.gene_ids,
      disease: this.disease,
      experiment: this.experiment,
      sra: this.sra
    };
    axios.get(url, { params })
      .then(response => {
        this.data.data = response.data;
        const vegaSpec = vegaLite.parse(
          `
        {
            data: {
                url: './data/heatmap.json'
            },
            mark: 'rect',
            encoding: {
                x: {
                field: 'x',
                type: 'ordinal'
                },
                y: {
                field: 'y',
                type: 'ordinal'
                },
                color: {
                field: 'value',
                type: 'quantitative',
                scale: {
                    range: ['red', 'blue']
                }
                }
            }
        }
      `
        );
        vega.embed('#heatmap', vegaSpec);
      })
      .catch(error => {
        console.log(error);
      });
  }
}

</script>