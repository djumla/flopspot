<template>
<main class="wrapper">
  <h1 class="underlined">Hotspot Bewerten</h1>
  <h2>Bitte geben Sie die Daten zu Ihrer Zugverbindung an und bewerten Sie anschließend die Qualität Ihres Hotspots.</h2>
  <form id="rating">
    <div id="flex-form">
      <label for="entrance">
          Einstieg
          <autocomplete
            anchor="station"
            label="station"
            :onShouldGetData="getStation"
            url="/filter"
            id="entrance">
          </autocomplete>
      </label>
      <label for="exit">
          Ausstieg
          <autocomplete
            anchor="station"
            label="station"
            :onShouldGetData="getStation"
            url="/station"
            id="entrance">
          </autocomplete>
      </label>
      <label for="train-number">
          Zugnummer
          <autocomplete
            anchor="name"
            label="name"
            :onShouldGetData="getTrainName"
            url="/filter"
            id="entrance">
          </autocomplete>
      </label>
      <label for="date">
          Reisedatum
          <datepicker></datepicker>
        </label>
    </div>
    <div id="satisfaction">Zufriedenheit</div>
    <div id="flex-thumbs">
      <div class="container">
        <label id="insufficient-label" for="insufficient">
            Unzufrieden
            <input type="radio" id="insufficient" name="rate" />
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
            <input type="radio" id="satisfying" name="rate" />
          </label>
        <div class="description">
          <p class="title underlined">Befriedigend</p>
          <div class="text">Der Hotspot war ausreichend für meine Bedürfnisse.</div>
        </div>
      </div>
      <div class="container">
        <label id="satisfactory-label" for="satisfactory">
            Sehr Zufrieden
            <input type="radio" id="satisfactory" name="rate" />
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

export default {
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

        ajax.open('POST', "/station", true);
        // On Done
        ajax.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        ajax.addEventListener('loadend', (e) => {
          const {
            responseText
          } = e.target

          let response = JSON.parse(responseText);

          // The options to pass in the autocomplete
          resolve(response)
        });

        ajax.send(JSON.stringify(params));
      })
    },
    getTrainName(value) {
      return new Promise((resolve, reject) => {
        let ajax = new XMLHttpRequest();
        let params = {
          "name": value
        };

        ajax.open('POST', "/trainName", true);
        // On Done
        ajax.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        ajax.addEventListener('loadend', (e) => {
          const {
            responseText
          } = e.target

          let response = JSON.parse(responseText);

          // The options to pass in the autocomplete
          resolve(response)
        });

        ajax.send(JSON.stringify(params));
      })
    }
  }
};
</script>
