<template>
<footer>
  <div id="service">
    <div id="flex-service">
      <section id="contact">
        <h1 class="underlined">Fragen oder Anregungen?</h1>
        <h2> Schreib uns an <a href="#">kontakt@flopspot.de</a> </h2>
      </section>
      <section id="social-media">
        <h1 class="underlined">Werde ein Fan von flopspot</h1>
        <div>
          <h2>Folge uns auf Facebook oder Twitter</h2>
          <a href="#"><img src="/assets/facebook.png"></img></a>
          <a href="https://twitter.com/FlopspotDE/"><img src="../../../../public/assets/twitter.png"></img></a>
        </div>
      </section>
      <nav class="underlined">
        <ul>
          <li><a href="/imprint">Impressum</a></li>
          <li><a href="/views/contact.html">Kontakt</a></li>
          <li><a href="../../../../public/views//privacyPolicy.html">Datenschutz</a></li>
        </ul>
      </nav>
    </div>
    <section id="tweets">
      <!-- TODO: By every additional tweet, which'll be added, this height needs to be added in #column-container  -->
    </section>
  </div>
  <div id="copyright">Copyright 2016 - flopspot</div>
</footer>
</template>

<script>
import Axios from 'axios';

export default {
  mounted: function() {
    this.$nextTick(function() {
      this.tweets();
    })
  },

  methods: {
    tweets: function() {
      //title underlined
      Axios.get('/tweets')
        .then(function(response) {
          response.data.statuses.forEach(function(val, key) {
            if (key < 5) {
              let p = document.createElement('p');
              let pText = document.createTextNode(val.text);
              let header = document.createElement('span');
              let hText = document.createTextNode(val.created_at);
              let container = document.createElement('div');

              container.className = "tweet";
              header.className = "title underlined";

              header.appendChild(hText);
              p.appendChild(pText);

              document.getElementById('tweets').appendChild(container);
              container.appendChild(header);
              container.appendChild(p);
            }
          });

        })
    }
  }
}
</script>
