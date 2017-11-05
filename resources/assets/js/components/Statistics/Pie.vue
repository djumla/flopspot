<template>
<section id="rating">
  <h1>Gesamtstatistik der letzten sechs Monate</h1>
  <div class="chart-container">
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
    /**
     * @param  {integer} insufficient
     *
     * @param  {integer} satisfying
     *
     * @param  {integer} satisfactory
     *
     * @return {void}
     */
    chart: function(insufficient, satisfying, satisfactory) {
      let ctx = document.getElementById('history');
      let data = {
        datasets: [{
          data: [insufficient, satisfying, satisfactory],
          backgroundColor: [
            '#D80B55',
            '#EFF281',
            '#00ed97',
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
            fontColor: '#fff',
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

    /**
     * @return {void}
     */
    create: function() {
      let self = this;

      Axios.get('/api/rating/pastSixMonth')
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
