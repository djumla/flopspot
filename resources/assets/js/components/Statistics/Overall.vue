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
  mounted: function() {
    this.$nextTick(function() {
      this.create();
    })
  },
  methods: {
    pie: function(insufficient, satisfying, satisfactory) {
      let ctx = document.getElementById('history');
      let data = {
        datasets: [{
          data: [insufficient, satisfying, satisfactory],
          backgroundColor: [
            '#736280',
            '#e5d9ca',
            '#5f9ea0',
          ],
          borderColor: [
            '#fff',
            '#fff',
            '#fff'
          ],
          hoverBorderColor: [
            ''
          ]
        }],

        labels: [
          'Unzufrieden',
          'Zufrieden',
          'Sehr zufrieden'
        ]
      };

      let options = {
        responsive: true
      }

      let myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: options
      });
    },

    create: function() {
      let self = this;
      Axios.get('/rating/pastSixMonth')
        .then(function(response) {
          self.pie(response.data.insufficient, response.data.satisfying, response.data.satisfactory);
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
  height: 800px;
}

.chart-container h1 {
  text-align: center;
  margin-top: 80px;
  margin-bottom: 80px;
}

.chart-container {
  width: 50%;
  margin: 0 auto;
}
</style>
