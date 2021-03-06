<template>
  <main class="wrapper">
    <div id="recaptcha"></div>
    <h1 class="underlined">Hotspot Bewerten</h1>
    <h2>
      Bitte geben Sie die Daten zu Ihrer Zugverbindung an und bewerten Sie anschließend die Qualität Ihres
      Hotspots.</h2>
    <form id="rating" @submit.prevent="trigger()">
      <div id="flex-form">
        <div id="entrance-container" class="inputs">
          <label for="entrance">
            Einstieg
            <autocomplete
              anchor="station"
              label="station"
              placeholder="Bahnhof / Haltestelle / Berlin Hbf"
              :onShouldGetData="getStations"
              url="/stations"
              id="entrance">
            </autocomplete>
          </label>
        </div>
        <div id="exit-container" class="inputs">
          <label for="exit">
            Ausstieg
            <autocomplete
              anchor="station"
              label="station"
              placeholder="Bahnhof / Haltestelle / Köln Hbf"
              :onShouldGetData="getStations"
              url="/stations"
              id="exit">
            </autocomplete>
          </label>
        </div>
        <div id="trainNumber-container" class="inputs">
          <label for="trainNumber">
            Zugnummer
            <autocomplete
              anchor="trainNumber"
              label="trainNumber"
              placeholder="Zugnummer / Zug-ID / ICE 105"
              :onShouldGetData="getTrainNumbers"
              url="/trainNumbers"
              id="trainNumber">
            </autocomplete>
          </label>
        </div>
        <div id="date-container" class="inputs">
          <label for="date">
            Reisedatum
            <datepicker
              calendar-class="calendar"
              id="datepicker"
              :value="state.date"
              format="dd.MM.yyyy"
              :disabled="state.disabled">
            </datepicker>
          </label>
        </div>
      </div>
      <div id="satisfaction">Zufriedenheit</div>
      <div id="flex-thumbs">
        <div class="container">
          <label id="insufficient-label" for="insufficient">
            Unzufrieden
            <input type="radio" id="insufficient" name="rate" value="insufficient" v-model="checked"/>
          </label>
          <div class="description">
            <p class="title underlined">
              Unzufrieden!
            </p>
            <div class="text">Die Zuverlässigkeit und/oder Qualität des WiFi war nicht zufriedenstellend!
            </div>
          </div>
        </div>
        <div class="container">
          <label id="satisfying-label" for="satisfying">
            Zufrieden
            <input type="radio" id="satisfying" name="rate" value="satisfying" v-model="checked"/>
          </label>
          <div class="description">
            <p class="title underlined">Befriedigend</p>
            <div class="text">Die Internetverbindung war befriedigend für meine Zwecke!</div>
          </div>
        </div>
        <div class="satisfactory container">
          <label id="satisfactory-label" for="satisfactory">
            Sehr Zufrieden
            <input type="radio" id="satisfactory" name="rate" value="satisfactory" v-model="checked"/>
          </label>
          <div class="description">
            <p class="title underlined">Sehr Zufrieden</p>
            <div class="text">Die WiFi-Qualität war sehr zurfriedenstellend</div>
          </div>
        </div>
      </div>
      <input id="ratingButton" type="submit" value="Senden"/>
    </form>
  </main>
</template>

<script>
  import Autocomplete from 'vue2-autocomplete-js'
  import Datepicker from 'vuejs-datepicker'
  import Axios from 'axios'

  export default {
    data: function () {
      let date = new Date()
      let day = date.getDate()
      let month = date.getMonth()
      let year = date.getFullYear()

      return {
        state: {
          date: new Date(),
          disabled: {
            to: new Date(year, month - 3),
            from: new Date(year, month, day + 1)
          }
        },
        checked: [],
        widgetID: 0
      }
    },

    components: {
      Autocomplete,
      Datepicker
    },

    mounted () {
      let self = this

      this.$nextTick(function () {
        window.addEventListener('load', () => {
          setTimeout(function () {
            const element = document.createElement('div')
            const parent = document.getElementById('rating')

            parent.appendChild(element)

            grecaptcha.render(element, {
              'sitekey': '6LeYLjkUAAAAALRN_2VcXmaSC5i_adKckj5I3c7g',
              'callback': self.sendRating,
              'size': 'invisible'
            })
          }, 100)
        })
      })
    },

    methods: {
      /**
       * @param  {string} value
       *
       * @returns {Promise}
       */
      getStations: function (value) {
        return new Promise((resolve, reject) => {
          let ajax = new XMLHttpRequest()
          let params = {
            'station': value
          }

          ajax.open('POST', '/api/stations', true)

          ajax.setRequestHeader('Content-type', 'application/json; charset=utf-8')
          ajax.addEventListener('loadend', (e) => {
            const {
              responseText
            } = e.target
            let response = JSON.parse(responseText)

            resolve(response)
          })

          ajax.send(JSON.stringify(params))
        })
      },

      /**
       * @param {string} value
       *
       * @returns {Promise}
       */
      getTrainNumbers: function (value) {
        return new Promise((resolve, reject) => {
          let ajax = new XMLHttpRequest()
          let params = {
            'trainNumber': value
          }

          ajax.open('POST', '/api/trainNumbers', true)

          ajax.setRequestHeader('Content-type', 'application/json; charset=utf-8')
          ajax.addEventListener('loadend', (e) => {
            const {
              responseText
            } = e.target

            let response = JSON.parse(responseText)

            resolve(response)
          })

          ajax.send(JSON.stringify(params))
        })
      },

      /**
       * @returns {integer}
       */
      getSelectedRating: function () {
        let rating

        switch (this.checked) {
          case 'insufficient':
            rating = 1
            break

          case 'satisfying':
            rating = 2
            break

          case 'satisfactory':
            rating = 3
            break
        }

        return rating
      },

      /**
       * @returns {void}
       */
      sendRating: function (token) {
        let self = this

        Axios.post('api/rating/save', {
          response: token,
          entrance: document.getElementById('entrance').value,
          exit: document.getElementById('exit').value,
          trainNumber: document.getElementById('trainNumber').value,
          date: this.dateFormat(document.getElementById('datepicker').value),
          rating: this.getSelectedRating()
        })
          .then(() => {
            self.showSucceed()
            setTimeout(function () {
              window.location.href = '/statistic'
            }, 2500)
          })
          .catch(function (error) {
            self.showError(error)
            if (document.body.offsetWidth < 800) {
              document.body.scrollIntoView()
            }
          })
      },

      /**
       * @param  {object} error response
       *
       * @returns {void}
       */
      showError: function (error) {
        this.reset()
        this.create(error)
        this.removeElement()
      },

      /**
       * @param  {object} error add element to the parent
       *
       * @return {void}
       */
      create: function (error) {
        const parent = document.getElementById('flex-form').children
        const rating = document.getElementById('flex-thumbs')

        if (error) {
          if (error.response.data.errors.entrance) {
            this.addElement(parent[0], error.response.data.errors.entrance)
          }
          if (error.response.data.errors.exit) {
            this.addElement(parent[1], error.response.data.errors.exit)
          }
          if (error.response.data.errors.trainNumber) {
            this.addElement(parent[2], error.response.data.errors.trainNumber)
          }
          if (error.response.data.errors.rating) {
            this.addElement(rating, error.response.data.errors.rating)
          }
        }
      },
      /**
       * @param {object} parent
       *
       * @param {string} message
       */
      addElement: function (parent, message) {
        let element = document.createElement('div')
        let msg = document.createTextNode(message)

        if (parent.getAttribute('class') === 'inputs') {
          element.appendChild(msg)

          element.className = 'error'

          switch (parent.getAttribute('id')) {
            case 'entrance-container':
              element.id = 'entrance-error'
              break
            case 'exit-container':
              element.id = 'exit-error'
              break
            case 'trainNumber-container':
              element.id = 'trainNumber-error'
              break
          }
          parent.appendChild(element)
        }

        if (parent.getAttribute('id') === 'flex-thumbs') {
          element.appendChild(msg)

          element.className = 'error'
          element.id = 'rating-error'

          parent.appendChild(element)
        }
      },

      /**
       * @return {void}
       */
      removeElement: function () {
        for (let i = 0; i < document.getElementById('flex-form').children.length - 1; i++) {
          document.querySelectorAll('.autocomplete-input')[i].onkeyup = () => {
            let parent = document.getElementById('flex-form').children[i]

            if (parent.getAttribute('id') === 'entrance-container' && document.getElementById('entrance-error')) {
              parent.removeChild(document.getElementById('entrance-error'))
            }
            if (parent.getAttribute('id') === 'exit-container' && document.getElementById('exit-error')) {
              parent.removeChild(document.getElementById('exit-error'))
            }
            if (parent.getAttribute('id') === 'trainNumber-container' && document.getElementById('trainNumber-error')) {
              parent.removeChild(document.getElementById('trainNumber-error'))
            }
          }
        }

        document.getElementById('rating-error').onclick = function () {
          document.getElementById('rating-error').remove()
        }
      },
      /**
       *
       * @param date
       *
       * @returns {string}
       */
      dateFormat: function (date) {
        return date.substring(6, 10) + '-' + date.substring(3, 5) + '-' + date.substring(0, 2)
      },

      /**
       * Called after form was successful submitted
       *
       * @return {void}
       */
      showSucceed: function () {
        let div = document.createElement('div')
        let msg = document.createTextNode(
          'Vielen Dank für deine Abstimmung! Sie werden jeden Moment weitergeleitet!'
        )
        let blackScreen = document.createElement('div')

        div.id = 'succeed'
        blackScreen.id = 'blackScreen'

        div.appendChild(msg)

        document.body.appendChild(div)
        document.body.appendChild(blackScreen)
      },

      trigger: function () {
        grecaptcha.execute(this.widgetID)
      },

      reset: function () {
        grecaptcha.reset(this.widgetID)
      }
    }
  }
</script>

