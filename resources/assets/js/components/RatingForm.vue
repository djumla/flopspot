<template>
  <main class="wrapper">
    <h1 class="underlined">Hotspot Bewerten</h1>
    <h2>Bitte geben Sie die Daten zu Ihrer Zugverbindung an und bewerten Sie anschließend die Qualität Ihres Hotspots.</h2>
    <form id="rating">
      <div id="flex-form">
        <label for="entrance">
          Einstieg
          <input type="text" id="entrance" placeholder="Einstieg" />
        </label>
        <label for="exit">
          Ausstieg
          <input type="text" id="exit" placeholder="Ausstieg" />
        </label>
        <label for="train-number">
          Zugnummer
          <input type="text" id="train-number" placeholder="Zugnummer" />
        </label>
        <label for="date">
          Reisedatum
          <input type="text" id="datepicker" placeholder="Datum" />
        </label>
      </div>
      <div id="satisfaction">Zufriedenheit</div>
      <div id="flex-thumbs">
        <div class="container">
          <label id ="insufficient-label" for="insufficient">
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
