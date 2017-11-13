<template>
<main class="wrapper">
  <h1 class="underlined">Hotspot Bewerten</h1>
  <h2>Bitte geben Sie die Daten zu Ihrer Zugverbindung an und bewerten Sie anschließend die Qualität Ihres Hotspots.</h2>
  <form id="rating" v-on:submit.prevent="send($event)">
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
    <div id="satisfaction">Zufriedenheit</div>
    <div id="flex-thumbs">
      <div class="container">
        <label id="insufficient-label" for="insufficient">
            Unzufrieden
            <input type="radio" id="insufficient" name="rate"/>
          </label>
        <div class="description">
          <p class="title underlined">
            Unzufrieden!
          </p>
          <div class="text">Die Leistungen der Bahn waren inakzeptabel und nicht zuverlässig!</div>
        </div>
      </div>
      <div class="container">
        <label id="satisfying-label" for="satisfying">
            Zufrieden
            <input type="radio" id="satisfying" name="rate"/>
          </label>
        <div class="description">
          <p class="title underlined">Befriedigend</p>
          <div class="text">Der Hotspot war ausreichend für meine Bedürfnisse.</div>
        </div>
      </div>
      <div class="satisfactory container">
        <label id="satisfactory-label" for="satisfactory">
            Sehr Zufrieden
            <input type="radio" id="satisfactory" name="rate"/>
          </label>
        <div class="description">
          <p class="title underlined">Sehr Zufrieden</p>
          <div class="text">Der Hotspot funktioniere einwandfrei!</div>
        </div>
      </div>
    </div>
    <input type="submit" value="Bewertung abgeben" />
  </form>
</main>
</template>

<script>
import Autocomplete from 'vue2-autocomplete-js';
import Datepicker from 'vuejs-datepicker';
import Axios from 'axios';

export default {
  data() {
      let date = new Date();
      let day = date.getDate();
      let month = date.getMonth();
      let year = date.getFullYear();

      return{
          state: {
              date: new Date(),
              disabled: {
                  to: new Date(year, month-3),
                  from: new Date(year, month, day+1)
              }
          }
      }
  },
  components: {
    Autocomplete,
    Datepicker
  },
  methods: {
    /**
     * @param  {string} value
     *
     * @return {void}
     */
    getStations(value) {
      return new Promise((resolve, reject) => {
        let ajax = new XMLHttpRequest();
        let params = {
          "station": value
        };

        ajax.open('POST', "/api/get/stations", true);

        ajax.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        ajax.addEventListener('loadend', (e) => {
          const {
            responseText
          } = e.target
          let response = JSON.parse(responseText);

          resolve(response)
        });

        ajax.send(JSON.stringify(params));
      })
    },

    /**
     * @param  {string} value
     *
     * @return {void}
     */
    getTrainNumbers(value) {
      return new Promise((resolve, reject) => {
        let ajax = new XMLHttpRequest();
        let params = {
          "trainNumber": value
        };

        ajax.open('POST', "/api/get/trainNumbers", true);

        ajax.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        ajax.addEventListener('loadend', (e) => {
          const {
            responseText
          } = e.target

          let response = JSON.parse(responseText);

          resolve(response)
        });

        ajax.send(JSON.stringify(params));
      })
    },
    /**
     * @return {void}
     */
    send(event) {
      let entrance = document.getElementById('entrance').value;
      let exit = document.getElementById('exit').value;
      let trainNumber = document.getElementById('trainNumber').value;
      let date = document.getElementById('datepicker').value;
      let rating = this.getSelectedRating();
      let self = this;

      let iso = this.dateFormat(date);

      Axios.post('api/rating/save', {
          entrance: entrance,
          exit: exit,
          trainNumber: trainNumber,
          date: iso,
          rating: rating
        })
        .then(function(response) {
            self.showSucceed();
            setTimeout(function () {
                window.location.href = "/statistic";
            }, 2500);
        })
        .catch(function(error) {
          self.showError(error);
        });
    },

    /**
     * @return {integer}
     */
    getSelectedRating() {
      let insufficient = document.getElementById('insufficient');
      let satisfying = document.getElementById('satisfying');
      let satisfactory = document.getElementById('satisfactory');
      let rating;

      if (insufficient.checked) {
        rating = 1;
      }
      if (satisfying.checked) {
        rating = 2;
      }
      if (satisfactory.checked) {
        rating = 3;
      }

      return rating;
    },

    /**
     * @param  {object} error response
     *
     * @return {void}
     */
    showError(error) {
      this.create(error);
      this.removeElement();
    },

    /**
     * @param  {object} error add element to the parent
     *
     * @return {void}
     */
    create(error) {
      let parent = document.getElementById('flex-form').children;
      let rating = document.getElementById('flex-thumbs');

      if(error) {
          console.log(error.response);
          if ('entrance' in error.response.data.errors) {
              this.addElement(parent[0], error.response.data.errors.entrance);
          }
          if ('exit' in error.response.data.errors) {
              this.addElement(parent[1], error.response.data.errors.exit);
          }
          if ('trainNumber' in error.response.data.errors) {
              this.addElement(parent[2], error.response.data.errors.trainNumber);
          }
          if('rating' in error.response.data.errors) {
            this.addElement(rating, error.response.data.errors.rating);
          }
      }
    },
    /**
     * @param {object} parent
     *
     * @param {string} message
     */
    addElement(parent, message) {
      let element = document.createElement('div');
      let msg = document.createTextNode(message);

      if(parent.getAttribute('class') === "inputs") {
          element.appendChild(msg);

          element.className = "error";

          switch (parent.getAttribute('id')) {
              case 'entrance-container':
                  element.id = "entrance-error";
                  break;
              case 'exit-container':
                  element.id = "exit-error";
                  break;
              case 'trainNumber-container':
                  element.id = "trainNumber-error";
                  break;
          }
          parent.appendChild(element);
      }

      if(parent.getAttribute('id') === "flex-thumbs") {
          element.appendChild(msg);

          element.className = "error";
          element.id = "rating-error";

          parent.appendChild(element);
      }
    },

    /**
     * @return {void}
     */
    removeElement() {
      for (let i = 0; i < document.getElementById('flex-form').children.length - 1; i++) {
        document.querySelectorAll(".autocomplete-input")[i].onkeyup = function() {
          let parent = document.getElementById('flex-form').children[i];

          if (parent.getAttribute('id') == 'entrance-container' && document.getElementById('entrance-error')) {
            parent.removeChild(document.getElementById('entrance-error'));
          }
          if (parent.getAttribute('id') == 'exit-container' && document.getElementById('exit-error')) {
            parent.removeChild(document.getElementById('exit-error'));
          }
          if (parent.getAttribute('id') == 'trainNumber-container' && document.getElementById('trainNumber-error')) {
            parent.removeChild(document.getElementById('trainNumber-error'));
          }
        }
      }

      document.getElementById('rating-error').onclick = function() {
          document.getElementById('rating-error').remove();
      }
    },
      /**
       *
       * @param date
       *
       * @returns {string}
       */
    dateFormat(date) {
        return date.substring(6,10)+"-"+date.substring(3,5)+"-"+date.substring(0,2);
    },


      /**
       * Called after form was successful submitted
       *
       * @return {void}
       */
      showSucceed() {
        let div = document.createElement('div');
        let msg = document.createTextNode(
            'Vielen Dank für deine Abstimmung! Sie werden jeden Moment weitergeleitet!'
        );
        let blackScreen = document.createElement('div');

        div.id = "succeed";
        blackScreen.id = "blackScreen";

        div.appendChild(msg);

        document.body.appendChild(div);
        document.body.appendChild(blackScreen);
      }
  }
};
</script>
