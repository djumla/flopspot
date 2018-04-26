<template>
  <section id="rating-section" class="wrapper">
    <h1>Gesamtstatistik der letzten sechs Monate</h1>
    <div class="chart-container">
      <canvas id="history"></canvas>
    </div>
  </section>
</template>

<script>
  import Chart from 'chart.js'
  import Axios from 'axios'

  export default {
    mounted: function () {
      this.$nextTick(function () {
        this.create()
      })
    },
    methods: {
      /**
       * @param  {integer} insufficient
       * @param  {integer} satisfying
       * @param  {integer} satisfactory
       * @returns {void || boolean}
       */
      chart: function (insufficient, satisfying, satisfactory) {
        let ctx = document.getElementById('history')
        let data = {
          datasets: [{
            data: [insufficient, satisfying, satisfactory],
            backgroundColor: [
              '#D80B55',
              '#EFF281',
              '#00ed97'
            ],
            borderColor: '#004b72',
            borderWidth: ['3', '3', '3']
          }],
          labels: [
            'Unzufrieden: ' + insufficient,
            'Zufrieden: ' + satisfying,
            'Sehr zufrieden: ' + satisfactory
          ]
        }

        let options = {
          responsive: true,
          tooltips: {
            enabled: false
          },
          legend: {
            display: true,
            labels: {
              fontColor: '#fff',
              fontSize: 16
            }
          }
        }

        if (window.innerWidth === 900) {
          return options.legend.display.false
        }

        const doughnut = new Chart(ctx, {
          type: 'doughnut',
          data: data,
          options: options
        })
      },

      /**
       * @returns {void}
       */
      create: function () {
        let self = this

        Axios.get('/api/rating/pastSixMonth')
        /**
         * @param {Object} response
         * @param {integer} response.data.insufficient
         * @param {integer} response.data.satisfying
         * @param {integer} response.data.satisfactory
         */
          .then((response) => {
            self.chart(response.data.insufficient, response.data.satisfying, response.data.satisfactory)
          })
      }

    }
  }
</script>
