<template>
<section id="rating">
  <div class="chart-container">
    <h1>Gesamtstatistik der letzten sechs Monate!</h1>
    <canvas id="history"></canvas>
  </div>
</section>
</template>

<script>
import Chart from 'chart.js';
import Axios from 'axios';

export default {
  // Mounted? Yes. The view needs to be rendered to actually create a chart.
  mounted: function() {
    this.$nextTick(function() {
      this.create();
    })
  },
  methods: {
    chart: function(insufficient, satisfying, satisfactory) {
      let ctx = document.getElementById('history');
      let data = {
        datasets: [{
          data: [insufficient, satisfying, satisfactory],
          backgroundColor: [
            '#EB0A54',
            '#FFF283',
            '#00ff00',
          ]
        }],
        labels: [
          'Unzufrieden: ' + insufficient,
          'Zufrieden: ' + satisfying,
          'Sehr zufrieden: ' + satisfactory
        ]
      };

      let options = {
        responsive: true,
        tooltips: {
          enabled: false
        },
        legend: {
          display: true,
          labels: {
            fontColor: '#000',
            fontSize: 18,
          }
        }
      }

      let chart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
      });
    },

    create: function() {
      // WHAT THE HACK?
      let self = this;
      Axios.get('/rating/pastSixMonth')
        .then(function(response) {
          self.chart(response.data.insufficient, response.data.satisfying, response.data.satisfactory);
        })
        .catch(function(error) {
          console.log(error);
        });
    },


  }
}
</script>
<style>
#rating {
  width: 80%;
  background-color: #fff;
  height: 800px;
  margin: 0 auto;
}

.chart-container h1 {
  color: #000;
  text-align: center;
  margin-top: 80px;
  margin-bottom: 80px;
  padding: 20px;
}

.chart-container {
  width: 50%;
  margin: 0 auto;
}
</style>
