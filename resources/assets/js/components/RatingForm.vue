<template>
<main class="wrapper">
  <h1 class="underlined">Hotspot Bewerten</h1>
  <h2>Bitte geben Sie die Daten zu Ihrer Zugverbindung an und bewerten Sie anschließend die Qualität Ihres Hotspots.</h2>
  <form id="rating" v-on:submit.prevent="send">
    <div id="flex-form">
      <label for="entrance">
          Einstieg
          <autocomplete
            anchor="station"
            label="station"
            placeholder="Bahnhof / Haltestelle / Berlin Hbf"
            :onShouldGetData="getStation"
            url="/stations"
            id="entrance">
          </autocomplete>
      </label>
      <label for="exit">
          Ausstieg
          <autocomplete
            anchor="station"
            label="station"
            placeholder="Bahnhof / Haltestelle / Köln Hbf"
            :onShouldGetData="getStation"
            url="/stations"
            id="exit">
          </autocomplete>
      </label>
      <label for="trainNumber">
          Zugnummer
          <autocomplete
            anchor="trainNumber"
            label="trainNumber"
            placeholder="Zugnummer / Zug-ID / ICE 105"
            :onShouldGetData="getTrainNumber"
            url="/trainNumbers"
            id="trainNumber">
          </autocomplete>
      </label>
      <label for="date">
          Reisedatum
          <datepicker
          :value="state.date"
          format="dd.MM.yyyy">
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
      <div class="container">
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
import Vue from 'vue';
import Autocomplete from 'vue2-autocomplete-js';
import Datepicker from 'vuejs-datepicker';
import Axios from 'axios';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

let state = {
  date: new Date()
};

export default {
  data() {
    return {
      state
    }
  },
  components: {
    Autocomplete,
    Datepicker
  },
  methods: {
    getStation(value) {
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
    getTrainNumber(value) {
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
    send() {
      let entrance = document.getElementById('entrance').value;
      let exit = document.getElementById('exit').value;
      let trainNumber = document.getElementById('trainNumber').value;
      let rating = this.getCheckedRadio();

      Axios.post('api/rating/save', {
          entrance: entrance,
          exit: exit,
          trainNumber: trainNumber,
          rating: rating
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    getCheckedRadio() {
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
    }
  }
};
</script>
