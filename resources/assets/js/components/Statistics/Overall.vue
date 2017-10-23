<template>
<section id="rating" style="position: relative; height:40vh; width:80vh">
  <canvas id="history"></canvas>
</section>
</template>

<script>
import Chart from 'chart.js';
import Axios from 'axios';

export default {
  mounted: function() {
    this.$nextTick(function() {
      this.pie();
    })
  },
  methods: {

    pie: function() {
      let ctx = document.getElementById('history');

      let data = {
        datasets: [{
          data: [this.getRating()]
        }],

        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels: [
          'Red'
        ]
      };

      let myPieChart = new Chart(ctx, {
        type: 'pie',
        data: data
      });
    },

    getRating() {
      Axios.get('localhost:8000/rating/pastSixMonth')
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  }
}
</script>
